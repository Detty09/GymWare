<?php

namespace App\Services;

use App\Repositories\FilteringRepository;
use Illuminate\Support\Facades\Cache;

class FilteringService {

    protected $repository;

    public function __construct(FilteringRepository $repository) {
        $this->repository = $repository;
    }

    public function getAllBodyParts() {
        $cacheKey = "body_parts";

        return Cache::remember($cacheKey, now()->addDay(), function () {
            return $this->repository->fetchAllBodyParts();
        });
    }

    public function getAllEquipments() {
        $cacheKey = "equipments";

        return Cache::remember($cacheKey, now()->addDay(), function () {
            return $this->repository->fetchAllEquipments();
        });
    }
}
