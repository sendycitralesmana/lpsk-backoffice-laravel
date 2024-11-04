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

    public function index()
    {
        $profileCategories = $this->profileCategoryRepository->getAll();
        $profiles = $this->profileRepository->getAll(); 
        return view('backoffice.profile.index', compact(['profileCategories', 'profiles']));
    }

    public function create(Request $request)
    {
        try {
            $profile = $this->profileRepository->store($request);
            return redirect()->back()->with('success', 'Kategori profil telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $profile = $this->profileRepository->update($request, $id);
            return redirect()->back()->with('success', 'Kategori profil telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function delete($id)
    {
        try {
            $profile = $this->profileRepository->delete($id);
            return redirect()->back()->with('success', 'Kategori profil telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
