<?php

namespace App\Http\Controllers;

use App\Http\Repository\PublicationCategoryRepository;
use Illuminate\Http\Request;

class PublicationCategoryController extends Controller
{
    private $publicationCategoryRepository;

    public function __construct(PublicationCategoryRepository $publicationCategoryRepository)
    {
        $this->publicationCategoryRepository = $publicationCategoryRepository;
    }

    public function index()
    {
        $publicationCategories = $this->publicationCategoryRepository->getAll();
        return view('backoffice.category-data.publication.index', compact('publicationCategories'));
    }

    public function create(Request $request)
    {
        try {
            $publicationCategory = $this->publicationCategoryRepository->store($request);
            return redirect()->back()->with('success', 'Kategori profil telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $publicationCategory = $this->publicationCategoryRepository->update($request, $id);
            return redirect()->back()->with('success', 'Kategori profil telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function delete($id)
    {
        try {
            $publicationCategory = $this->publicationCategoryRepository->delete($id);
            return redirect()->back()->with('success', 'Kategori profil telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
