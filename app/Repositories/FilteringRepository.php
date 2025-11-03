<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;


class FilteringRepository {

    protected $baseUrl = "https://www.exercisedb.dev/api/v1/";

    public function fetchAllBodyParts() {

        $response = Http::get("{$this->baseUrl}/bodyparts");

        if ($response->failed()) {
            throw new \Exception("Failed to fetch bodyparts");
        }

        return $response->json();
    }

    public function fetchAllEquipments() {

        $response = Http::get("{$this->baseUrl}/equipments");

        if ($response->failed()) {
            throw new \Exception("Failed to fetch equipments");
        }

        return $response->json();
    }
}
