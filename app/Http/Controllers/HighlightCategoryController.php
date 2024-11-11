<?php

namespace App\Http\Controllers;

use App\Http\Repository\HighlightCategoryRepository;
use Illuminate\Http\Request;

class HighlightCategoryController extends Controller
{
    private $highlightCategoryRepository;

    public function __construct(HighlightCategoryRepository $highlightCategoryRepository)
    {
        $this->highlightCategoryRepository = $highlightCategoryRepository;
    }

    public function index()
    {
        $highlightCategories = $this->highlightCategoryRepository->getAll();
        return view('backoffice.category-data.highlight.index', compact('highlightCategories'));
    }

    public function create(Request $request)
    {
        try {
            $highlightCategory = $this->highlightCategoryRepository->store($request);
            return redirect()->back()->with('success', 'Kategori sorot telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $highlightCategory = $this->highlightCategoryRepository->update($request, $id);
            return redirect()->back()->with('success', 'Kategori sorot telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function delete($id)
    {
        try {
            $highlightCategory = $this->highlightCategoryRepository->delete($id);
            return redirect()->back()->with('success', 'Kategori sorot telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
