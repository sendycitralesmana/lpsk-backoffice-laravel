<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Repository\ReportRepository;
use App\Http\Requests\Report\CreateRequest;
use App\Http\Resources\Report\GetAllResource;
use App\Http\Resources\Report\GetResource;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    
    private $reportRepository;

    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function getAllApi(Request $request)
    {
        try {
            $reports = $this->reportRepository->getAllApi($request);

            $resource = GetAllResource::collection($reports);

            return response()->json([
                'total' => $reports->total(),
                'current_page' => $reports->currentPage(),
                'per_page' => $reports->perPage(),
                'last_page' => $reports->lastPage(),
                'data' => $resource,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getApi($id)
    {
        try {
            $report = $this->reportRepository->getById($id);

            $resource = new GetResource($report);

            if ($report == null) {
                return response()->json([
                    'message' => 'Kategori peta jalan tidak ditemukan'
                ], 404);
            }

            return response()->json($resource);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function storeApi(CreateRequest $request)
    {
        try {
            $report = $this->reportRepository->store($request);

            return response()->json($report);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
