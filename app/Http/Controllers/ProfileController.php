<?php

namespace App\Http\Controllers;

use App\Http\Repository\ProfileCategoryRepository;
use App\Http\Repository\ProfileRepository;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private $profileRepository;
    private $profileCategoryRepository;

    public function __construct(ProfileRepository $profileRepository, ProfileCategoryRepository $profileCategoryRepository)
    {
        $this->profileRepository = $profileRepository;
        $this->profileCategoryRepository = $profileCategoryRepository;
    }

    public function index(Request $request)
    {
        $profileCategories = $this->profileCategoryRepository->getAll();
        $profiles = $this->profileRepository->getAll($request); 
        $search = $request->search;
        $category_id = $request->category_id;
        if ($category_id == null) {
            $profileCategori = null;
        } else {
            $profileCategori = $this->profileCategoryRepository->getById($category_id);
        }
        return view('backoffice.profile.index2', compact(['profileCategories', 'profiles', 'profileCategori', 'search', 'category_id']));
    }

    public function create(Request $request)
    {
        try {
            $profile = $this->profileRepository->store($request);
            return redirect()->back()->with('success', 'Profil telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $profile = $this->profileRepository->update($request, $id);
            return redirect()->back()->with('success', 'Profil telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function detail(Request $request, $id)
    {
        $profile = $this->profileRepository->getById($id);
        $profileCategories = $this->profileCategoryRepository->getAll();
        return view('backoffice.profile.detail', compact(['profile', 'profileCategories']));
    }

    public function delete($id)
    {
        try {
            $profile = $this->profileRepository->delete($id);
            return redirect()->back()->with('success', 'Profil telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
