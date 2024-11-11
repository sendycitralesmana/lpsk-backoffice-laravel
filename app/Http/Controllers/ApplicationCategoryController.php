<?php

namespace App\Http\Controllers;

use App\Http\Repository\ApplicationCategoryRepository;
use Illuminate\Http\Request;

class ApplicationCategoryController extends Controller
{
    
    private $applicationCategoryRepository;

    public function __construct(ApplicationCategoryRepository $applicationCategoryRepository)
    {
        $this->applicationCategoryRepository = $applicationCategoryRepository;
    }

    public function index()
    {
        $applicationCategories = $this->applicationCategoryRepository->getAll();
        return view('backoffice.category-data.application.index', compact('applicationCategories'));
    }

    public function create(Request $request)
    {
        try {
            $applicationCategory = $this->applicationCategoryRepository->store($request);
            return redirect()->back()->with('success', 'Kategori aplikasi telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $applicationCategory = $this->applicationCategoryRepository->update($request, $id);
            return redirect()->back()->with('success', 'Kategori aplikasi telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function delete($id)
    {
        try {
            $applicationCategory = $this->applicationCategoryRepository->delete($id);
            return redirect()->back()->with('success', 'Kategori aplikasi telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

}
