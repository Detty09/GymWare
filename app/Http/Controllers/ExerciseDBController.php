<?php

namespace App\Http\Controllers;

use App\Services\FilteringService;
use App\Services\ExerciseDBService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class ExerciseDBController extends Controller
{
    protected $exerciseService;
    protected $filteringService;

    public function __construct(ExerciseDBService $exerciseService, FilteringService $filteringService) {
        $this->exerciseService = $exerciseService;
        $this->filteringService = $filteringService;
    }

    public function index(Request $request) {
        try {
            $page = $request->query("page", 1);
            $bodypart = $request->query("bodypart");
            $equipment = $request->query("equipment");

            $bodyparts = $this->filteringService->getAllBodyParts()["data"];
            $equipments = $this->filteringService->getAllEquipments()["data"];

            usort($bodyparts, fn($a, $b) => strcmp($a["name"], $b["name"]));
            usort($equipments, fn($a, $b) => strcmp($a["name"], $b["name"]));

            $filters = [
                "bodypart" => $bodypart,
                "equipment" => $equipment,
            ];

            $exercises = $this->exerciseService->getByFilters($filters, $page);

            return view("catalog", [
                "exercises" => $exercises,
                "bodyparts" => $bodyparts,
                "equipments" => $equipments,
                "selectedBodypart" => $bodypart,
                "selectedEquipment" => $equipment,
                "page" => $page
            ]);
        } catch (\Exception $e) {
            return view("catalog", [
                "error" => $e->getMessage(),
                "exercises" => ['data' => []],
                "page" => $page
            ]);
        }
    }

    public function show($id, Request $request) {

        $page = $request->query("page", 1);
        $bodypart = $request->query("bodypart");
        $equipment = $request->query("equipment");

        $cacheKey = "exercises_{$bodypart}_{$equipment}_page_{$page}";
        $cachedPage = Cache::get($cacheKey, ["data" => []]);

        $exercise = collect($cachedPage['data'] ?? [])->firstWhere("exerciseId", $id);

        return view("exercise-details", ["exercise" => $exercise]);

    }
}
