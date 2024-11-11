<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\InformationCategoryRepository;
use App\Http\Resources\InformationCategory\GetResource;
use App\Http\Resources\InformationCategory\GetAllResource;
use Illuminate\Http\Request;

class InformationCategoryController extends Controller
{
    private $informationCategoryRepository;

    public function __construct(InformationCategoryRepository $informationCategoryRepository)
    {
        $this->informationCategoryRepository = $informationCategoryRepository;
    }

    public function getAllApi(Request $request)
    {
        try {
            $informationCategories = $this->informationCategoryRepository->getAllApi($request);

            $resource = GetAllResource::collection($informationCategories);

            return response()->json([
                'total' => $informationCategories->total(),
                'current_page' => $informationCategories->currentPage(),
                'per_page' => $informationCategories->perPage(),
                'last_page' => $informationCategories->lastPage(),
                'data' => $resource,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getApi($id)
    {
        try {
            $informationCategory = $this->informationCategoryRepository->getById($id);

            $resource = new GetResource($informationCategory);

            if ($informationCategory == null) {
                return response()->json([
                    'message' => 'Kategori informasi tidak ditemukan'
                ], 404);
            }

            return response()->json($resource);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
