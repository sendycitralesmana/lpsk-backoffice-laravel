<?php

namespace App\Http\Controllers;

use App\Http\Repository\PublicationCategoryRepository;
use App\Http\Repository\PublicationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            return redirect()->back()->with('success', 'Publikasi telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $publication = $this->publicationRepository->update($request, $id);
            return redirect()->back()->with('success', 'Publikasi telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function delete($id)
    {
        try {
            $publication = $this->publicationRepository->delete($id);
            return redirect()->back()->with('success', 'Publikasi telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function preview($id)
    {
        try {
            $publication = $this->publicationRepository->getById($id);
            $file = Storage::disk('s3')->get($publication->document_url);
            return response($file)->header('Content-Type', 'application/pdf');
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
