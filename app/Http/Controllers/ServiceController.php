<?php

namespace App\Http\Controllers;

use App\Http\Repository\ServiceCategoryRepository;
use App\Http\Repository\ServiceRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    private $serviceRepository;
    private $serviceCategoryRepository;

    public function __construct(ServiceRepository $serviceRepository, ServiceCategoryRepository $serviceCategoryRepository)
    {
        $this->serviceRepository = $serviceRepository;
        $this->serviceCategoryRepository = $serviceCategoryRepository;
    }

    public function index()
    {
        $serviceCategories = $this->serviceCategoryRepository->getAll();
        $services = $this->serviceRepository->getAll(); 
        return view('backoffice.service.index', compact(['serviceCategories', 'services']));
    }

    public function create(Request $request)
    {
        try {
            $service = $this->serviceRepository->store($request);
            return redirect()->back()->with('success', 'Layanan telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $service = $this->serviceRepository->update($request, $id);
            return redirect()->back()->with('success', 'Layanan telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function delete($id)
    {
        try {
            $service = $this->serviceRepository->delete($id);
            return redirect()->back()->with('success', 'Layanan telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function preview($id)
    {
        try {
            $service = $this->serviceRepository->getById($id);
            $file = Storage::disk('s3')->get($service->document_url);
            return response($file)->header('Content-Type', 'application/pdf');
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
