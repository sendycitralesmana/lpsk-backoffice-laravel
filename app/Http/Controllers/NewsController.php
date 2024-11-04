<?php

namespace App\Http\Controllers;

use App\Http\Repository\NewsCategoryRepository;
use App\Http\Repository\NewsRepository;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    private $newsRepository;
    private $newsCategoryRepository;

    public function __construct(NewsRepository $newsRepository, NewsCategoryRepository $newsCategoryRepository)
    {
        $this->newsRepository = $newsRepository;
        $this->newsCategoryRepository = $newsCategoryRepository;
    }

    public function index()
    {
        $newsCategories = $this->newsCategoryRepository->getAll();
        $newss = $this->newsRepository->getAll(); 
        return view('backoffice.news.index', compact(['newsCategories', 'newss']));
    }

    public function detail($id)
    {
        $news = $this->newsRepository->getById($id);
        $newsCategories = $this->newsCategoryRepository->getAll();
        return view('backoffice.news.detail', compact(['news', 'newsCategories']));
    }

    public function create(Request $request)
    {
        try {
            $news = $this->newsRepository->store($request);
            return redirect()->back()->with('success', 'Kategori berita telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $news = $this->newsRepository->update($request, $id);
            return redirect()->back()->with('success', 'Kategori berita telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function delete($id)
    {
        try {
            $news = $this->newsRepository->delete($id);
            return redirect()->back()->with('success', 'Kategori berita telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function createImage(Request $request, $id)
    {
        try {
            $news = $this->newsRepository->storeImage($request, $id);
            return redirect()->back()->with('successImage', 'Gambar telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteAllImage($id)
    {
        try {
            $news = $this->newsRepository->deleteAllImage($id);
            return redirect()->back()->with('successImage', 'Semua gambar telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteImage($id, $image_id)
    {
        try {
            $news = $this->newsRepository->deleteImage($id, $image_id);
            return redirect()->back()->with('successImage', 'Gambar telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function updateImage(Request $request, $id, $image_id)
    {
        try {
            $news = $this->newsRepository->updateImage($request, $id, $image_id);
            return redirect()->back()->with('successImage', 'Gambar telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function createDocument(Request $request, $id)
    {
        try {
            $news = $this->newsRepository->storeDocument($request, $id);
            return redirect()->back()->with('successDocument', 'Dokumen telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteAllDocument($id)
    {
        try {
            $news = $this->newsRepository->deleteAllDocument($id);
            return redirect()->back()->with('successDocument', 'Semua dokumen telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteDocument($id, $document_id)
    {
        try {
            $news = $this->newsRepository->deleteDocument($id, $document_id);
            return redirect()->back()->with('successDocument', 'Dokumen telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function updateDocument(Request $request, $id, $document_id)
    {
        try {
            $news = $this->newsRepository->updateDocument($request, $id, $document_id);
            return redirect()->back()->with('successDocument', 'Dokumen telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function createVideo(Request $request, $id)
    {
        try {
            $news = $this->newsRepository->storeVideo($request, $id);
            return redirect()->back()->with('successVideo', 'Video telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteAllVideo($id)
    {
        try {
            $news = $this->newsRepository->deleteAllVideo($id);
            return redirect()->back()->with('successVideo', 'Semua video telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteVideo($id, $video_id)
    {
        try {
            $news = $this->newsRepository->deleteVideo($id, $video_id);
            return redirect()->back()->with('successVideo', 'Video telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function updateVideo(Request $request, $id, $video_id)
    {
        try {
            $news = $this->newsRepository->updateVideo($request, $id, $video_id);
            return redirect()->back()->with('successVideo', 'Video telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }
    
}
