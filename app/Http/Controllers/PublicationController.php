<?php

namespace App\Http\Controllers;

use App\Http\Repository\PublicationCategoryRepository;
use App\Http\Repository\PublicationRepository;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    private $publicationRepository;
    private $publicationCategoryRepository;

    public function __construct(PublicationRepository $publicationRepository, PublicationCategoryRepository $publicationCategoryRepository)
    {
        $this->publicationRepository = $publicationRepository;
        $this->publicationCategoryRepository = $publicationCategoryRepository;
    }

    public function index()
    {
        $publicationCategories = $this->publicationCategoryRepository->getAll();
        $publications = $this->publicationRepository->getAll(); 
        return view('backoffice.publication.index', compact(['publicationCategories', 'publications']));
    }

    public function create(Request $request)
    {
        try {
            $publication = $this->publicationRepository->store($request);
            return redirect()->back()->with('success', 'Kategori layanan telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $publication = $this->publicationRepository->update($request, $id);
            return redirect()->back()->with('success', 'Kategori layanan telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function delete($id)
    {
        try {
            $publication = $this->publicationRepository->delete($id);
            return redirect()->back()->with('success', 'Kategori layanan telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
