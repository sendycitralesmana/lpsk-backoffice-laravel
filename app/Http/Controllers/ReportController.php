<?php

namespace App\Http\Controllers;

use App\Http\Repository\ReportRepository;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private $reportRepository;

    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function index()
    {
        $reports = $this->reportRepository->getAll(); 
        return view('backoffice.report.index', compact([ 'reports']));
    }

    public function create(Request $request)
    {
        try {
            $report = $this->reportRepository->store($request);
            return redirect()->back()->with('success', 'Kategori laporan telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function delete($id)
    {
        try {
            $report = $this->reportRepository->delete($id);
            return redirect()->back()->with('success', 'Kategori laporan telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
