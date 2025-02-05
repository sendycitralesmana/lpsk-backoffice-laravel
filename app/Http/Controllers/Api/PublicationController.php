<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\PublicationRepository;
use App\Http\Resources\Publication\GetAllResource;
use App\Http\Resources\Publication\GetResource;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    private $publicationRepository;

    public function __construct(PublicationRepository $publicationRepository)
    {
        $this->publicationRepository = $publicationRepository;
    }

    public function getAllApi(Request $request)
    {
        try {
            $publicationCategories = $this->publicationRepository->getAllApi($request);

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

    public function getBukuTerbaruApi()
    {
        try {
            $books = $this->publicationRepository->bukuTerbaru();

            return response()->json([
               'books' => $books
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getLaporanTerbaruApi()
    {
        try {
            $reports = $this->publicationRepository->laporanTerbaru();

            return response()->json([
               'reports' => $reports
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getJurnalTerbaruApi()
    {
        try {
            $journals = $this->publicationRepository->jurnalTerbaru();

            return response()->json([
                'journals' => $journals
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getBuletinTerbaruApi()
    {
        try {
            $bulletins = $this->publicationRepository->buletinTerbaru();

            return response()->json([
                'bulletins' => $bulletins
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getApi($id)
    {
        try {
            $publication = $this->publicationRepository->getById($id);

            $resource = new GetResource($publication);

            if ($publication == null) {
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
