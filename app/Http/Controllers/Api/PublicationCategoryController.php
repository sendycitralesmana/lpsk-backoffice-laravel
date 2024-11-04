<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\PublicationCategoryRepository;
use App\Http\Resources\PublicationCategory\GetAllResource;
use App\Http\Resources\PublicationCategory\GetResource;
use Illuminate\Http\Request;

class PublicationCategoryController extends Controller
{
    private $publicationCategoryRepository;

    public function __construct(PublicationCategoryRepository $publicationCategoryRepository)
    {
        $this->publicationCategoryRepository = $publicationCategoryRepository;
    }

    public function getAllApi(Request $request)
    {
        try {
            $publicationCategories = $this->publicationCategoryRepository->getAllApi($request);

            $resource = GetAllResource::collection($publicationCategories);

            return response()->json([
                'total' => $publicationCategories->total(),
                'current_page' => $publicationCategories->currentPage(),
                'per_page' => $publicationCategories->perPage(),
                'last_page' => $publicationCategories->lastPage(),
                'data' => $resource,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getApi($id)
    {
        try {
            $publicationCategory = $this->publicationCategoryRepository->getById($id);

            $resource = new GetResource($publicationCategory);

            if ($publicationCategory == null) {
                return response()->json([
                    'message' => 'Kategori publikasi tidak ditemukan'
                ], 404);
            }

            return response()->json($resource);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
