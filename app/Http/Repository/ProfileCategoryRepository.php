<?php

namespace App\Http\Repository;

use App\Models\ProfileCategory;
use Illuminate\Support\Str;

class ProfileCategoryRepository
{
    // api
    public function getAllApi($request)
    {
        try {
            $profileCategories = ProfileCategory::orderBy('created_at', 'desc');

            if ($request->search) {
                $profileCategories->where('name', 'like', '%' . $request->search . '%');
            }
            
            if ($request->slug) {
                $profileCategories->where('slug', 'like', '%' . $request->slug . '%');
            }

            $per_page = $request->per_page;
            if ($per_page) {
                $profileCategories->paginate($per_page);
            } else {
                $per_page = 10;
            }

            $profileCategories = $profileCategories->paginate($per_page);

            return $profileCategories;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAll()
    {
        try {
            return ProfileCategory::orderBy('created_at', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return ProfileCategory::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($data)
    {
        try {
            $profileCategory = new ProfileCategory();
            $profileCategory->id = Str::uuid();
            $profileCategory->slug = $data->slug;
            $profileCategory->name = $data->name;
            $profileCategory->save();
            return $profileCategory;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($data, $id)
    {
        try {
            $serviceCategories = ProfileCategory::where('id', '!=', $id)->get();
            $profileCategory = ProfileCategory::find($id);
            $profileCategory->name = $data->name;    
            $profileCategory->slug = $data->slug;
            $profileCategory->save();

            return $profileCategory;
            // foreach ($serviceCategories as $key => $value) {
            //     if ($value->name == $profileCategory->name) {
            //         return redirect()->back()->with('error', 'Kategori ' . $profileCategory->name . ' sudah ada');
            //     }
            // }
            // $profileCategory->slug = str_replace(' ', '-', strtolower($data->name));
            // $profileCategory->save();
            // return redirect()->back()->with('success', 'Kategori profil telah diperbarui');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $profileCategory = ProfileCategory::find($id);
            $profileCategory->delete();
            return $profileCategory;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}