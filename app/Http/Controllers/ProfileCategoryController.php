<?php

namespace App\Http\Controllers;

use App\Http\Repository\ProfileCategoryRepository;
use Illuminate\Http\Request;

class ProfileCategoryController extends Controller
{
    private $profileCategoryRepository;

    public function __construct(ProfileCategoryRepository $profileCategoryRepository)
    {
        $this->profileCategoryRepository = $profileCategoryRepository;
    }

    public function index()
    {
        $profileCategories = $this->profileCategoryRepository->getAll();
        return view('backoffice.category-data.profile.index', compact('profileCategories'));
    }

    public function create(Request $request)
    {
        try {
            $profileCategory = $this->profileCategoryRepository->store($request);
            return redirect()->back()->with('success', 'Kategori profil telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $profileCategory = $this->profileCategoryRepository->update($request, $id);
            return redirect()->back()->with('success', 'Kategori profil telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function delete($id)
    {
        try {
            $profileCategory = $this->profileCategoryRepository->delete($id);
            return redirect()->back()->with('success', 'Kategori profil telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
