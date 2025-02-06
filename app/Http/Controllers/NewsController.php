<?php

namespace App\Http\Controllers;

use App\Http\Repository\NewsCategoryRepository;
use App\Http\Repository\NewsRepository;
use App\Http\Repository\UserRepository;
use App\Models\NewsDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    private $newsRepository;
    private $newsCategoryRepository;
    private $userRepository;

    public function __construct(NewsRepository $newsRepository, NewsCategoryRepository $newsCategoryRepository, UserRepository $userRepository)
    {
        $this->newsRepository = $newsRepository;
        $this->newsCategoryRepository = $newsCategoryRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $newsCategories = $this->newsCategoryRepository->getAll();
        $newss = $this->newsRepository->getAll($request); 
        $users = $this->userRepository->getAll();
        $search = $request->search;
        $category_id = $request->category_id;
        if ($category_id == null) {
            $newsCategory = null;
        } else {
            $newsCategory = $this->newsCategoryRepository->getById($category_id);
        }
        $status = $request->status;
        $user_id = $request->user_id;
        if ($user_id == null) {
            $user = null;
        } else {
            $user = $this->userRepository->getById($user_id);
        }
        return view('backoffice.news.index', compact(['newsCategories', 'newss', 'newsCategory', 'user',  'users', 'search', 'category_id', 'status', 'user_id']));
    }

    public function add()
    {
        $newsCategories = $this->newsCategoryRepository->getAll();
        return view('backoffice.news.add', compact('newsCategories'));
    }

    public function edit($id)
    {
        $news = $this->newsRepository->getById($id);
        $newsCategories = $this->newsCategoryRepository->getAll();
        return view('backoffice.news.edit', compact(['news', 'newsCategories']));
    }

    public function detail(Request $request, $id)
    {
        $news = $this->newsRepository->getById($id);
        $newsCategories = $this->newsCategoryRepository->getAll();
        return view('backoffice.news.detail', compact(['news', 'newsCategories']));
    }

    public function create(Request $request)
    {
        
        try {
            $news = $this->newsRepository->store($request);
            return redirect('/backoffice/news')->with('success', 'Berita telah ditambahkan');
            // return redirect()->back()->with('success', 'Berita telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // dd($request->all());

            $news = $this->newsRepository->update($request, $id);
            return redirect('/backoffice/news')->with('success', 'Berita telah diperbarui');
            // return redirect()->back()->with('success', 'Berita telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function delete($id)
    {
        try {
            $news = $this->newsRepository->delete($id);
            // return redirect()->back()->with('success', 'Berita telah dihapus');
            return redirect('/backoffice/news')->with('success', 'Berita telah dihapus');
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

    public function previewDocument($id, $document_id)
    {
        try {
            $newsDocument = NewsDocument::find($document_id);
            $file = Storage::disk('s3')->get($newsDocument->url);
            return response($file)->header('Content-Type', 'application/pdf');
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
