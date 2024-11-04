<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\ServiceRepository;
use App\Http\Resources\Service\GetAllResource;
use App\Http\Resources\Service\GetResource;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function getAllApi(Request $request)
    {
        try {
            $serviceCategories = $this->serviceRepository->getAllApi($request);

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
            $service = $this->serviceRepository->getById($id);

            $resource = new GetResource($service);

            if ($service == null) {
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
