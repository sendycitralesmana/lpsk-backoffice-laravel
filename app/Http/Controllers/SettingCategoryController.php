<?php

namespace App\Http\Controllers;

use App\Http\Repository\SettingCategoryRepository;
use Illuminate\Http\Request;

class SettingCategoryController extends Controller
{
    private $settingCategoryRepository;

    public function __construct(SettingCategoryRepository $settingCategoryRepository)
    {
        $this->settingCategoryRepository = $settingCategoryRepository;
    }

    public function index()
    {
        $settingCategories = $this->settingCategoryRepository->getAll();
        return view('backoffice.category-data.setting.index', compact('settingCategories'));
    }

    public function create(Request $request)
    {
        try {
            $settingCategory = $this->settingCategoryRepository->store($request);
            return redirect()->back()->with('success', 'Kategori peraturan telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $settingCategory = $this->settingCategoryRepository->update($request, $id);
            return redirect()->back()->with('success', 'Kategori peraturan telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function delete($id)
    {
        try {
            $settingCategory = $this->settingCategoryRepository->delete($id);
            return redirect()->back()->with('success', 'Kategori peraturan telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
