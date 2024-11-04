<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\ServiceCategoryRepository;
use App\Http\Resources\ServiceCategory\GetAllResource;
use App\Http\Resources\ServiceCategory\GetResource;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    
    private $serviceCategoryRepository;

    public function __construct(ServiceCategoryRepository $serviceCategoryRepository)
    {
        $this->serviceCategoryRepository = $serviceCategoryRepository;
    }

    public function getAllApi(Request $request)
    {
        try {
            $serviceCategories = $this->serviceCategoryRepository->getAllApi($request);

            $resource = GetAllResource::collection($serviceCategories);

            return response()->json([
                'total' => $serviceCategories->total(),
                'current_page' => $serviceCategories->currentPage(),
                'per_page' => $serviceCategories->perPage(),
                'last_page' => $serviceCategories->lastPage(),
                'data' => $resource,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getApi($id)
    {
        try {
            $serviceCategory = $this->serviceCategoryRepository->getById($id);

            $resource = new GetResource($serviceCategory);

            if ($serviceCategory == null) {
                return response()->json([
                    'message' => 'Kategori layanan tidak ditemukan'
                ], 404);
            }

            return response()->json($resource);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
