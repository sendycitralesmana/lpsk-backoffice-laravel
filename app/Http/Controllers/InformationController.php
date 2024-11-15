<?php

namespace App\Http\Controllers;

use App\Http\Repository\InformationCategoryRepository;
use App\Http\Repository\InformationRepository;
use App\Http\Repository\UserRepository;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    
    private $informationRepository;
    private $informationCategoryRepository;
    private $userRepository;

    public function __construct(InformationRepository $informationRepository, InformationCategoryRepository $informationCategoryRepository, UserRepository $userRepository)
    {
        $this->informationRepository = $informationRepository;
        $this->informationCategoryRepository = $informationCategoryRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $informationCategories = $this->informationCategoryRepository->getAll();
        $informations = $this->informationRepository->getAll($request); 
        $users = $this->userRepository->getAll();
        $search = $request->search;
        $category_id = $request->category_id;
        if ($category_id == null) {
            $informationCategory = null;
        } else {
            $informationCategory = $this->informationCategoryRepository->getById($category_id);
        }
        $status = $request->status;
        $user_id = $request->user_id;
        if ($user_id == null) {
            $user = null;
        } else {
            $user = $this->userRepository->getById($user_id);
        }
        return view('backoffice.information.index', compact(['informationCategories', 'informations', 'informationCategory', 'user', 'users', 'search', 'category_id', 'status', 'user_id']));
    }

    public function add()
    {
        $informationCategories = $this->informationCategoryRepository->getAll();
        return view('backoffice.information.add', compact('informationCategories'));
    }

    public function edit($id)
    {
        $information = $this->informationRepository->getById($id);
        $informationCategories = $this->informationCategoryRepository->getAll();
        return view('backoffice.information.edit', compact(['information', 'informationCategories']));
    }

    public function detail($id)
    {
        $information = $this->informationRepository->getById($id);
        $informationCategories = $this->informationCategoryRepository->getAll();
        return view('backoffice.information.detail', compact(['information', 'informationCategories']));
    }

    public function create(Request $request)
    {
        try {
            $information = $this->informationRepository->store($request);
            // return redirect()->back()->with('success', 'Kategori informasi telah ditambahkan');
            return redirect('/backoffice/information')->with('success', 'Informasi telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $information = $this->informationRepository->update($request, $id);
            // return redirect()->back()->with('success', 'Kategori informasi telah diperbarui');
            return redirect('/backoffice/information')->with('success', 'Informasi telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function delete($id)
    {
        try {
            $information = $this->informationRepository->delete($id);
            return redirect()->back()->with('success', 'Informasi telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function createImage(Request $request, $id)
    {
        try {
            $information = $this->informationRepository->storeImage($request, $id);
            return redirect()->back()->with('successImage', 'Gambar telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteAllImage($id)
    {
        try {
            $information = $this->informationRepository->deleteAllImage($id);
            return redirect()->back()->with('successImage', 'Semua gambar telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteImage($id, $image_id)
    {
        try {
            $information = $this->informationRepository->deleteImage($id, $image_id);
            return redirect()->back()->with('successImage', 'Gambar telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function updateImage(Request $request, $id, $image_id)
    {
        try {
            $information = $this->informationRepository->updateImage($request, $id, $image_id);
            return redirect()->back()->with('successImage', 'Gambar telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function createDocument(Request $request, $id)
    {
        try {
            $information = $this->informationRepository->storeDocument($request, $id);
            return redirect()->back()->with('successDocument', 'Dokumen telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteAllDocument($id)
    {
        try {
            $information = $this->informationRepository->deleteAllDocument($id);
            return redirect()->back()->with('successDocument', 'Semua dokumen telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteDocument($id, $document_id)
    {
        try {
            $information = $this->informationRepository->deleteDocument($id, $document_id);
            return redirect()->back()->with('successDocument', 'Dokumen telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function updateDocument(Request $request, $id, $document_id)
    {
        try {
            $information = $this->informationRepository->updateDocument($request, $id, $document_id);
            return redirect()->back()->with('successDocument', 'Dokumen telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function createVideo(Request $request, $id)
    {
        try {
            $information = $this->informationRepository->storeVideo($request, $id);
            return redirect()->back()->with('successVideo', 'Video telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteAllVideo($id)
    {
        try {
            $information = $this->informationRepository->deleteAllVideo($id);
            return redirect()->back()->with('successVideo', 'Semua video telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteVideo($id, $video_id)
    {
        try {
            $information = $this->informationRepository->deleteVideo($id, $video_id);
            return redirect()->back()->with('successVideo', 'Video telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function updateVideo(Request $request, $id, $video_id)
    {
        try {
            $information = $this->informationRepository->updateVideo($request, $id, $video_id);
            return redirect()->back()->with('successVideo', 'Video telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

}
