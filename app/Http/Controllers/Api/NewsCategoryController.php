<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\NewsCategoryRepository;
use App\Http\Resources\NewsCategory\GetAllResource;
use App\Http\Resources\NewsCategory\GetResource;
use Illuminate\Http\Request;

class NewsCategoryController extends Controller
{
    private $newsCategoryRepository;

    public function __construct(NewsCategoryRepository $newsCategoryRepository)
    {
        $this->newsCategoryRepository = $newsCategoryRepository;
    }

    public function getAllApi(Request $request)
    {
        try {
            $newsCategories = $this->newsCategoryRepository->getAllApi($request);

            $resource = GetAllResource::collection($newsCategories);

            return response()->json([
                'total' => $newsCategories->total(),
                'current_page' => $newsCategories->currentPage(),
                'per_page' => $newsCategories->perPage(),
                'last_page' => $newsCategories->lastPage(),
                'data' => $resource,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getApi($id)
    {
        try {
            $newsCategory = $this->newsCategoryRepository->getById($id);

            $resource = new GetResource($newsCategory);

            if ($newsCategory == null) {
                return response()->json([
                    'message' => 'Kategori berita tidak ditemukan'
                ], 404);
            }

            return response()->json($resource);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
