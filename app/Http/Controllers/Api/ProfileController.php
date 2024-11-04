<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\ProfileRepository;
use App\Http\Resources\Profile\GetAllResource;
use App\Http\Resources\Profile\GetResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    
    private $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function getAllApi(Request $request)
    {
        try {
            $profileCategories = $this->profileRepository->getAllApi($request);

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
            $profile = $this->profileRepository->getById($id);

            $resource = new GetResource($profile);

            if ($profile == null) {
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
