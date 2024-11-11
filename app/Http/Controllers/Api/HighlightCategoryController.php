<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\HighlightCategoryRepository;
use App\Http\Resources\HighlightCategory\GetAllResource;
use App\Http\Resources\HighlightCategory\GetResource;
use Illuminate\Http\Request;

class HighlightCategoryController extends Controller
{
    private $highlightCategoryRepository;

    public function __construct(HighlightCategoryRepository $highlightCategoryRepository)
    {
        $this->highlightCategoryRepository = $highlightCategoryRepository;
    }

    public function getAllApi(Request $request)
    {
        try {
            $highlightCategories = $this->highlightCategoryRepository->getAllApi($request);

            $resource = GetAllResource::collection($highlightCategories);

            return response()->json([
                'total' => $highlightCategories->total(),
                'current_page' => $highlightCategories->currentPage(),
                'per_page' => $highlightCategories->perPage(),
                'last_page' => $highlightCategories->lastPage(),
                'data' => $resource,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getApi($id)
    {
        try {
            $highlightCategory = $this->highlightCategoryRepository->getById($id);

            $resource = new GetResource($highlightCategory);

            if ($highlightCategory == null) {
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
