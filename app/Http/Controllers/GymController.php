<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GymController extends Controller
{
    public function preload(Request $request)
    {

        $lat = $request->query('lat');
        $lng = $request->query('lng');
        $radius = $request->query('radius', 1000);

        if (!$lat || !$lng) {
            return response()->json(['error' => 'Missing coordinates'], 400);
        }

        $query = "[out:json];(
        node[\"leisure\"=\"fitness_centre\"](around:$radius,$lat,$lng);
        node[\"amenity\"=\"gym\"](around:$radius,$lat,$lng);
    );out center tags;";

        $url = "https://overpass-api.de/api/interpreter?data=" . urlencode($query);

        try {
            $json = file_get_contents($url);
            $data = json_decode($json, true);
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch Overpass data', 'message' => $e->getMessage()], 500);
        }
    }
}
