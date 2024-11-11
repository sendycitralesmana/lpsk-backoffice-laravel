<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\RoadMapRepository;
use App\Http\Resources\Roadmap\GetAllResource;
use App\Http\Resources\Roadmap\GetResource;
use Illuminate\Http\Request;

class RoadMapController extends Controller
{
    private $roadmapRepository;

    public function __construct(RoadMapRepository $roadmapRepository)
    {
        $this->roadmapRepository = $roadmapRepository;
    }

    public function getAllApi(Request $request)
    {
        try {
            $roadmapCategories = $this->roadmapRepository->getAllApi($request);

            $resource = GetAllResource::collection($roadmapCategories);

            return response()->json([
                'total' => $roadmapCategories->total(),
                'current_page' => $roadmapCategories->currentPage(),
                'per_page' => $roadmapCategories->perPage(),
                'last_page' => $roadmapCategories->lastPage(),
                'data' => $resource,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getApi($id)
    {
        try {
            $roadmap = $this->roadmapRepository->getById($id);

            $resource = new GetResource($roadmap);

            if ($roadmap == null) {
                return response()->json([
                    'message' => 'Kategori peta jalan tidak ditemukan'
                ], 404);
            }

            return response()->json($resource);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
