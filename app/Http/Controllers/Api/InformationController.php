<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\InformationRepository;
use App\Http\Resources\Information\GetAllResource;
use App\Http\Resources\Information\GetResource;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    private $informationRepository;

    public function __construct(InformationRepository $informationRepository)
    {
        $this->informationRepository = $informationRepository;
    }

    public function getAllApi(Request $request)
    {
        try {
            $applicationCategories = $this->informationRepository->getAllApi($request);

            $resource = GetAllResource::collection($applicationCategories);

            return response()->json([
                'total' => $applicationCategories->total(),
                'current_page' => $applicationCategories->currentPage(),
                'per_page' => $applicationCategories->perPage(),
                'last_page' => $applicationCategories->lastPage(),
                'data' => $resource,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // get 5 latest 
    public function getLatestApi()
    {
        try {
            $applicationCategories = $this->informationRepository->getLatestApi();

            return response()->json([
                'data' => $applicationCategories
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getApi($id)
    {
        try {
            $information = $this->informationRepository->getById($id);

            $resource = new GetResource($information);

            if ($information == null) {
                return response()->json([
                    'message' => 'Kategori aplikasi tidak ditemukan'
                ], 404);
            }

            return response()->json($resource);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
