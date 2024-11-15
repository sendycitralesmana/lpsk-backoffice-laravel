<?php

namespace App\Http\Controllers;

use App\Http\Repository\SettingCategoryRepository;
use App\Http\Repository\SettingRepository;
use App\Http\Repository\UserRepository;
use App\Models\SettingDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    private $settingRepository;
    private $settingCategoryRepository;
    private $userRepository;

    public function __construct(SettingRepository $settingRepository, SettingCategoryRepository $settingCategoryRepository, UserRepository $userRepository)
    {
        $this->settingRepository = $settingRepository;
        $this->settingCategoryRepository = $settingCategoryRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $settingCategories = $this->settingCategoryRepository->getAll();
        $settings = $this->settingRepository->getAll($request); 
        $users = $this->userRepository->getAll();
        $search = $request->search;
        $category_id = $request->category_id;
        if ($category_id == null) {
            $settingCategory = null;
        } else {
            $settingCategory = $this->settingCategoryRepository->getById($category_id);
        }
        $status = $request->status;
        $user_id = $request->user_id;
        if ($user_id == null) {
            $user = null;
        } else {
            $user = $this->userRepository->getById($user_id);
        }
        return view('backoffice.setting.index', compact(['settingCategories', 'settings', 'settingCategory', 'user',  'users', 'search', 'category_id', 'status', 'user_id']));
    }

    public function add()
    {
        $settingCategories = $this->settingCategoryRepository->getAll();
        return view('backoffice.setting.add', compact('settingCategories'));
    }

    public function edit($id)
    {
        $setting = $this->settingRepository->getById($id);
        $settingCategories = $this->settingCategoryRepository->getAll();
        return view('backoffice.setting.edit', compact(['setting', 'settingCategories']));
    }

    public function detail(Request $request, $id)
    {
        $setting = $this->settingRepository->getById($id);
        $settingCategories = $this->settingCategoryRepository->getAll();
        return view('backoffice.setting.detail', compact(['setting', 'settingCategories']));
    }

    public function create(Request $request)
    {
        
        try {
            $setting = $this->settingRepository->store($request);
            return redirect('/backoffice/setting')->with('success', 'Peraturan telah ditambahkan');
            // return redirect()->back()->with('success', 'Peraturan telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $setting = $this->settingRepository->update($request, $id);
            return redirect('/backoffice/setting')->with('success', 'Peraturan telah diperbarui');
            // return redirect()->back()->with('success', 'Peraturan telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function delete($id)
    {
        try {
            $setting = $this->settingRepository->delete($id);
            return redirect()->back()->with('success', 'Peraturan telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function createImage(Request $request, $id)
    {
        try {
            $setting = $this->settingRepository->storeImage($request, $id);
            return redirect()->back()->with('successImage', 'Gambar telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteAllImage($id)
    {
        try {
            $setting = $this->settingRepository->deleteAllImage($id);
            return redirect()->back()->with('successImage', 'Semua gambar telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteImage($id, $image_id)
    {
        try {
            $setting = $this->settingRepository->deleteImage($id, $image_id);
            return redirect()->back()->with('successImage', 'Gambar telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function updateImage(Request $request, $id, $image_id)
    {
        try {
            $setting = $this->settingRepository->updateImage($request, $id, $image_id);
            return redirect()->back()->with('successImage', 'Gambar telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function createDocument(Request $request, $id)
    {
        try {
            $setting = $this->settingRepository->storeDocument($request, $id);
            return redirect()->back()->with('successDocument', 'Dokumen telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function previewDocument($id, $document_id)
    {
        try {
            $settingDocument = SettingDocument::find($document_id);
            $file = Storage::disk('s3')->get($settingDocument->url);
            return response($file)->header('Content-Type', 'application/pdf');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteAllDocument($id)
    {
        try {
            $setting = $this->settingRepository->deleteAllDocument($id);
            return redirect()->back()->with('successDocument', 'Semua dokumen telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteDocument($id, $document_id)
    {
        try {
            $setting = $this->settingRepository->deleteDocument($id, $document_id);
            return redirect()->back()->with('successDocument', 'Dokumen telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function updateDocument(Request $request, $id, $document_id)
    {
        try {
            $setting = $this->settingRepository->updateDocument($request, $id, $document_id);
            return redirect()->back()->with('successDocument', 'Dokumen telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function createVideo(Request $request, $id)
    {
        try {
            $setting = $this->settingRepository->storeVideo($request, $id);
            return redirect()->back()->with('successVideo', 'Video telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteAllVideo($id)
    {
        try {
            $setting = $this->settingRepository->deleteAllVideo($id);
            return redirect()->back()->with('successVideo', 'Semua video telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteVideo($id, $video_id)
    {
        try {
            $setting = $this->settingRepository->deleteVideo($id, $video_id);
            return redirect()->back()->with('successVideo', 'Video telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function updateVideo(Request $request, $id, $video_id)
    {
        try {
            $setting = $this->settingRepository->updateVideo($request, $id, $video_id);
            return redirect()->back()->with('successVideo', 'Video telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }
    
}
