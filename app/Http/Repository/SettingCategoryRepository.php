<?php

namespace App\Http\Repository;

use App\Models\SettingCategory;
use Illuminate\Support\Str;

class SettingCategoryRepository
{
    // api
    public function getAllApi($request)
    {
        try {
            $setting = SettingCategory::orderBy('created_at', 'desc');

            if ($request->search) {
                $setting->where('name', 'like', '%' . $request->search . '%');
            }

            if ($request->slug) {
                $setting->where('slug', 'like', '%' . $request->slug . '%');
            }

            $per_page = $request->per_page;
            if ($per_page) {
                $setting->paginate($per_page);
            } else {
                $per_page = 10;
            }

            $setting = $setting->paginate($per_page);

            return $setting;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAll()
    {
        try {
            return SettingCategory::orderBy('created_at', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return SettingCategory::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($data)
    {
        try {
            $settingCategory = new settingCategory();
            $settingCategory->id = Str::uuid();
            $settingCategory->name = $data->name;
            $settingCategory->slug = $data->slug;
            $settingCategory->save();
            return $settingCategory;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($data, $id)
    {
        try {
            $settingCategories = SettingCategory::where('id', '!=', $id)->get();
            $settingCategory = SettingCategory::find($id);
            $settingCategory->name = $data->name;
            $settingCategory->slug = $data->slug;
            $settingCategory->save();

            return $settingCategory;
            // foreach ($settingCategories as $key => $value) {
            //     if ($value->name == $settingCategory->name) {
            //         return redirect()->back()->with('error', 'Kategori ' . $settingCategory->name . ' sudah ada');
            //     }
            // }
            // $settingCategory->slug = str_replace(' ', '-', strtolower($data->name));
            // $settingCategory->save();
            // return redirect()->back()->with('success', 'Kategori berita telah diperbarui');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $settingCategory = SettingCategory::find($id);
            $settingCategory->delete();
            return $settingCategory;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}