<?php

namespace App\Http\Controllers;

use App\Http\Repository\NewsCategoryRepository;
use Illuminate\Http\Request;

class NewsCategoryController extends Controller
{
    private $newsCategoryRepository;

    public function __construct(NewsCategoryRepository $newsCategoryRepository)
    {
        $this->newsCategoryRepository = $newsCategoryRepository;
    }

    public function index()
    {
        $newsCategories = $this->newsCategoryRepository->getAll();
        return view('backoffice.category-data.news.index', compact('newsCategories'));
    }

    public function create(Request $request)
    {
        try {
            $newsCategory = $this->newsCategoryRepository->store($request);
            return redirect()->back()->with('success', 'Kategori aplikasi telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $newsCategory = $this->newsCategoryRepository->update($request, $id);
            return redirect()->back()->with('success', 'Kategori aplikasi telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function delete($id)
    {
        try {
            $newsCategory = $this->newsCategoryRepository->delete($id);
            return redirect()->back()->with('success', 'Kategori aplikasi telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
