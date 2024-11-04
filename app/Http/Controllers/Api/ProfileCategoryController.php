<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\ProfileCategoryRepository;
use App\Http\Resources\ProfileCategory\GetAllResource;
use App\Http\Resources\ProfileCategory\GetResource;
use Illuminate\Http\Request;

class ProfileCategoryController extends Controller
{
    
    private $profileCategoryRepository;

    public function __construct(ProfileCategoryRepository $profileCategoryRepository)
    {
        $this->profileCategoryRepository = $profileCategoryRepository;
    }

    public function getAllApi(Request $request)
    {
        try {
            $profileCategories = $this->profileCategoryRepository->getAllApi($request);

            $resource = GetAllResource::collection($profileCategories);

            return response()->json([
                'total' => $profileCategories->total(),
                'current_page' => $profileCategories->currentPage(),
                'per_page' => $profileCategories->perPage(),
                'last_page' => $profileCategories->lastPage(),
                'data' => $resource,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getApi($id)
    {
        try {
            $profileCategory = $this->profileCategoryRepository->getById($id);

            $resource = new GetResource($profileCategory);

            if ($profileCategory == null) {
                return response()->json([
                    'message' => 'Kategori profil tidak ditemukan'
                ], 404);
            }

            return response()->json($resource);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
