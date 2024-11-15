<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\SettingCategoryRepository;
use App\Http\Resources\SettingCategory\GetAllResource;
use App\Http\Resources\SettingCategory\GetResource;
use Illuminate\Http\Request;

class SettingCategoryController extends Controller
{
    private $settingCategoryRepository;

    public function __construct(SettingCategoryRepository $settingCategoryRepository)
    {
        $this->settingCategoryRepository = $settingCategoryRepository;
    }

    public function getAllApi(Request $request)
    {
        try {
            $settingCategories = $this->settingCategoryRepository->getAllApi($request);

            $resource = GetAllResource::collection($settingCategories);

            return response()->json([
                'total' => $settingCategories->total(),
                'current_page' => $settingCategories->currentPage(),
                'per_page' => $settingCategories->perPage(),
                'last_page' => $settingCategories->lastPage(),
                'data' => $resource,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getApi($id)
    {
        try {
            $settingCategory = $this->settingCategoryRepository->getById($id);

            $resource = new GetResource($settingCategory);

            if ($settingCategory == null) {
                return response()->json([
                    'message' => 'Kategori peraturan tidak ditemukan'
                ], 404);
            }

            return response()->json($resource);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}