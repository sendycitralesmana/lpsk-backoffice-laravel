<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\SettingRepository;
use App\Http\Resources\Setting\GetAllResource;
use App\Http\Resources\Setting\GetResource;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function getAllApi(Request $request)
    {
        try {
            $setting = $this->settingRepository->getAllApi($request);

            $resource = GetAllResource::collection($setting);

            return response()->json([
                'total' => $setting->total(),
                'current_page' => $setting->currentPage(),
                'per_page' => $setting->perPage(),
                'last_page' => $setting->lastPage(),
                'data' => $resource,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getApi($id)
    {
        try {
            $setting = $this->settingRepository->getById($id);

            $resource = new GetResource($setting);

            if ($setting == null) {
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