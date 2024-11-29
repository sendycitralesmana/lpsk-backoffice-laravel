<?php

namespace App\Http\Controllers;

use App\Http\Repository\HighlightCategoryRepository;
use App\Http\Repository\HighlightRepository;
use App\Http\Repository\NewsRepository;
use Illuminate\Http\Request;

class HighlightController extends Controller
{
    private $highlightRepository;
    private $highlightCategoryRepository;
    private $newsRepository;

    public function __construct(
        HighlightRepository $highlightRepository, 
        HighlightCategoryRepository $highlightCategoryRepository,
        NewsRepository $newsRepository
        )
    {
        $this->highlightRepository = $highlightRepository;
        $this->highlightCategoryRepository = $highlightCategoryRepository;
        $this->newsRepository = $newsRepository;
    }

    public function index(Request $request)
    {
        $highlightCategories = $this->highlightCategoryRepository->getAll();
        $newss = $this->newsRepository->getAllNoPaginate($request);
        $highlights = $this->highlightRepository->getAll(); 
        return view('backoffice.highlight.index', compact(['highlightCategories', 'highlights', 'newss']));
    }

    public function create(Request $request)
    {
        try {
            $highlight = $this->highlightRepository->store($request);
            return redirect()->back()->with('success', 'Sorot telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $highlight = $this->highlightRepository->update($request, $id);
            return redirect()->back()->with('success', 'Sorot telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function delete($id)
    {
        try {
            $highlight = $this->highlightRepository->delete($id);
            return redirect()->back()->with('success', 'Sorot telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
