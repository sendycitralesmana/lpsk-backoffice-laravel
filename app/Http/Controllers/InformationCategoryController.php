<?php

namespace App\Http\Controllers;

use App\Http\Repository\InformationCategoryRepository;
use Illuminate\Http\Request;

class InformationCategoryController extends Controller
{
    
    private $informationCategoryRepository;

    public function __construct(InformationCategoryRepository $informationCategoryRepository)
    {
        $this->informationCategoryRepository = $informationCategoryRepository;
    }

    public function index()
    {
        $informationCategories = $this->informationCategoryRepository->getAll();
        return view('backoffice.category-data.information.index', compact('informationCategories'));
    }

    public function create(Request $request)
    {
        try {
            $informationCategory = $this->informationCategoryRepository->store($request);
            return redirect()->back()->with('success', 'Kategori aplikasi telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $informationCategory = $this->informationCategoryRepository->update($request, $id);
            return redirect()->back()->with('success', 'Kategori aplikasi telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function delete($id)
    {
        try {
            $informationCategory = $this->informationCategoryRepository->delete($id);
            return redirect()->back()->with('success', 'Kategori aplikasi telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

}
