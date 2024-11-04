<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\ApplicationCategoryRepository;
use App\Http\Resources\ApplicationCategory\GetAllResource;
use App\Http\Resources\ApplicationCategory\GetResource;
use Illuminate\Http\Request;

class ApplicationCategoryController extends Controller
{
    private $applicationCategoryRepository;

    public function __construct(ApplicationCategoryRepository $applicationCategoryRepository)
    {
        $this->applicationCategoryRepository = $applicationCategoryRepository;
    }

    public function getAllApi(Request $request)
    {
        try {
            $applicationCategories = $this->applicationCategoryRepository->getAllApi($request);

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

    public function getApi($id)
    {
        try {
            $applicationCategory = $this->applicationCategoryRepository->getById($id);

            $resource = new GetResource($applicationCategory);

            if ($applicationCategory == null) {
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
