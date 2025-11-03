<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;


class ExerciseDBRepository{
    protected $baseUrl = "https://www.exercisedb.dev/api/v1";
    protected $limit = 25;

    public function fetchByFilters($filters = [], $page = 1) {
        $offset = ($page - 1) * $this->limit;

        $query = [
            "offset" => $offset,
            "limit" => $this->limit
        ];

        if (!empty($filters["equipment"])) {
            $query["equipment"] = $filters["equipment"];
        }

        if (!empty($filters["bodypart"])) {
            $query["bodyParts"] = $filters["bodypart"];
        }

        $url = "{$this->baseUrl}/exercises/filter";

        $response = Http::get($url, $query);

        if ($response->failed()) {
            throw new \Exception("Failed to fetch exercises by filters: ".$response->body());
        }

        return $response->json();
    }

    public function fetchById(string $id)
    {
        $url = "{$this->baseUrl}/exercises/{$id}";
        $response = Http::get($url);

        if ($response->failed()) {
            throw new \Exception("Failed to fetch exercise: ".$response->body());
        }

        return $response->json();
    }

}
