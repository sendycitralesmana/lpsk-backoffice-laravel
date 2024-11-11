<?php

namespace App\Http\Controllers;

use App\Http\Repository\ServiceCategoryRepository;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    private $serviceCategoryRepository;

    public function __construct(ServiceCategoryRepository $serviceCategoryRepository)
    {
        $this->serviceCategoryRepository = $serviceCategoryRepository;
    }

    public function index()
    {
        $serviceCategories = $this->serviceCategoryRepository->getAll();
        return view('backoffice.category-data.service.index', compact('serviceCategories'));
    }

    public function create(Request $request)
    {
        try {
            $serviceCategory = $this->serviceCategoryRepository->store($request);
            return redirect()->back()->with('success', 'Kategori aplikasi telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $serviceCategory = $this->serviceCategoryRepository->update($request, $id);
            return redirect()->back()->with('success', 'Kategori aplikasi telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function delete($id)
    {
        try {
            $serviceCategory = $this->serviceCategoryRepository->delete($id);
            return redirect()->back()->with('success', 'Kategori aplikasi telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
