<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\HighlightRepository;
use App\Http\Resources\Highlight\GetAllResource;
use App\Http\Resources\Highlight\GetResource;
use Illuminate\Http\Request;

class HighlightController extends Controller
{
    private $highlightRepository;

    public function __construct(HighlightRepository $highlightRepository)
    {
        $this->highlightRepository = $highlightRepository;
    }

    public function getAllApi(Request $request)
    {
        try {
            $highlightCategories = $this->highlightRepository->getAllApi($request);

            $resource = GetAllResource::collection($highlightCategories);

            return response()->json([
                // 'total' => $highlightCategories->total(),
                // 'current_page' => $highlightCategories->currentPage(),
                // 'per_page' => $highlightCategories->perPage(),
                // 'last_page' => $highlightCategories->lastPage(),
                'data' => $resource,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getApi($id)
    {
        try {
            $highlight = $this->highlightRepository->getById($id);

            $resource = new GetResource($highlight);

            if ($highlight == null) {
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
