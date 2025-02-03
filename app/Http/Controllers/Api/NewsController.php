<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\NewsRepository;
use App\Http\Resources\News\GetAllResource;
use App\Http\Resources\News\GetResource;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    private $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function getAllApi(Request $request)
    {
        try {
            $news = $this->newsRepository->getAllApi($request);

            $resource = GetAllResource::collection($news);

            return response()->json([
                'total' => $news->total(),
                'current_page' => $news->currentPage(),
                'per_page' => $news->perPage(),
                'last_page' => $news->lastPage(),
                'data' => $resource,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // getLatestApi
    public function getLatestArtikelApi()
    {
        try {
            $news = $this->newsRepository->getLatestArtikelApi();

            return response()->json([
                'artikel' => $news
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getLatestInformasiApi()
    {
        try {
            $news = $this->newsRepository->getLatestInformasiApi();

            return response()->json([
                'informasi' => $news
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getApi($id)
    {
        try {
            $news = $this->newsRepository->getById($id);

            $resource = new GetResource($news);

            if ($news == null) {
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
