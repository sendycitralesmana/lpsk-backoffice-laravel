<?php

namespace App\Http\Controllers;

use App\Http\Repository\RoadMapRepository;
use App\Http\Repository\UserRepository;
use App\Models\RoadMapDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoadMapController extends Controller
{
    private $roadmapRepository;
    private $userRepository;

    public function __construct(RoadMapRepository $roadmapRepository, UserRepository $userRepository)
    {
        $this->roadmapRepository = $roadmapRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        // $roadmaps = $this->roadmapRepository->getAll($request); 

        $roadmaps = $this->roadmapRepository->getAll($request); 
        $users = $this->userRepository->getAll();
        $search = $request->search;
        $status = $request->status;
        $user_id = $request->user_id;
        if ($user_id == null) {
            $user = null;
        } else {
            $user = $this->userRepository->getById($user_id);
        }

        return view('backoffice.roadmap.index', compact(['roadmaps', 'user', 'users', 'search', 'status', 'user_id']));
    }

    public function add()
    {
        return view('backoffice.roadmap.add');
    }

    public function detail($id)
    {
        $roadmap = $this->roadmapRepository->getById($id);
        return view('backoffice.roadmap.detail', compact(['roadmap']));
    }

    public function edit($id)
    {
        $roadmap = $this->roadmapRepository->getById($id);
        return view('backoffice.roadmap.edit', compact(['roadmap']));
    }

    public function previewDocument($id, $document_id)
    {
        try {
            $roadmapDocument = RoadMapDocuments::find($document_id);
            $file = Storage::disk('s3')->get($roadmapDocument->url);
            return response($file)->header('Content-Type', 'application/pdf');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function create(Request $request)
    {
        try {
            $roadmap = $this->roadmapRepository->store($request);
            // return redirect()->back()->with('success', 'Kategori peta jalan telah ditambahkan');
            return redirect('/backoffice/roadmap')->with('success', 'Kategori peta jalan telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $roadmap = $this->roadmapRepository->update($request, $id);
            // return redirect()->back()->with('success', 'Kategori peta jalan telah diperbarui');
            return redirect('/backoffice/roadmap')->with('success', 'Kategori peta jalan telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function delete($id)
    {
        try {
            $roadmap = $this->roadmapRepository->delete($id);
            return redirect()->back()->with('success', 'Kategori peta jalan telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function createImage(Request $request, $id)
    {
        try {
            $roadmap = $this->roadmapRepository->storeImage($request, $id);
            return redirect()->back()->with('successImage', 'Gambar telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteAllImage($id)
    {
        try {
            $roadmap = $this->roadmapRepository->deleteAllImage($id);
            return redirect()->back()->with('successImage', 'Semua gambar telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteImage($id, $image_id)
    {
        try {
            $roadmap = $this->roadmapRepository->deleteImage($id, $image_id);
            return redirect()->back()->with('successImage', 'Gambar telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function updateImage(Request $request, $id, $image_id)
    {
        try {
            $roadmap = $this->roadmapRepository->updateImage($request, $id, $image_id);
            return redirect()->back()->with('successImage', 'Gambar telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function createDocument(Request $request, $id)
    {
        try {
            $roadmap = $this->roadmapRepository->storeDocument($request, $id);
            return redirect()->back()->with('successDocument', 'Dokumen telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteAllDocument($id)
    {
        try {
            $roadmap = $this->roadmapRepository->deleteAllDocument($id);
            return redirect()->back()->with('successDocument', 'Semua dokumen telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteDocument($id, $document_id)
    {
        try {
            $roadmap = $this->roadmapRepository->deleteDocument($id, $document_id);
            return redirect()->back()->with('successDocument', 'Dokumen telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function updateDocument(Request $request, $id, $document_id)
    {
        try {
            $roadmap = $this->roadmapRepository->updateDocument($request, $id, $document_id);
            return redirect()->back()->with('successDocument', 'Dokumen telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function createVideo(Request $request, $id)
    {
        try {
            $roadmap = $this->roadmapRepository->storeVideo($request, $id);
            return redirect()->back()->with('successVideo', 'Video telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteAllVideo($id)
    {
        try {
            $roadmap = $this->roadmapRepository->deleteAllVideo($id);
            return redirect()->back()->with('successVideo', 'Semua video telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function deleteVideo($id, $video_id)
    {
        try {
            $roadmap = $this->roadmapRepository->deleteVideo($id, $video_id);
            return redirect()->back()->with('successVideo', 'Video telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function updateVideo(Request $request, $id, $video_id)
    {
        try {
            $roadmap = $this->roadmapRepository->updateVideo($request, $id, $video_id);
            return redirect()->back()->with('successVideo', 'Video telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
