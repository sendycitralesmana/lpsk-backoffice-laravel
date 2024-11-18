<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\ApplicationRepository;
use App\Http\Resources\Application\GetAllResource;
use App\Http\Resources\Application\GetResource;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    
    private $applicationRepository;

    public function __construct(ApplicationRepository $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
    }

    public function getAllApi(Request $request)
    {
        try {
            $applicationCategories = $this->applicationRepository->getAllApi($request);

            $resource = GetAllResource::collection($applicationCategories);

            return response()->json([
                // 'total' => $applicationCategories->total(),
                // 'current_page' => $applicationCategories->currentPage(),
                // 'per_page' => $applicationCategories->perPage(),
                // 'last_page' => $applicationCategories->lastPage(),
                'data' => $resource,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getApi($id)
    {
        try {
            $application = $this->applicationRepository->getById($id);

            $resource = new GetResource($application);

            if ($application == null) {
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
