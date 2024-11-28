<?php

namespace App\Http\Repository;

use App\Models\InformationCategory;
use Illuminate\Support\Str;

class InformationCategoryRepository
{
    // api
    public function getAllApi($request)
    {
        try {
            $informationCategories = InformationCategory::orderBy('created_at', 'desc');

            if ($request->search) {
                $informationCategories->where('name', 'like', '%' . $request->search . '%');
            }

            if ($request->slug) {
                $informationCategories->where('slug', 'like', '%' . $request->slug . '%');
            }

            $per_page = $request->per_page;
            if ($per_page) {
                $informationCategories->paginate($per_page);
            } else {
                $per_page = 10;
            }

            $informationCategories = $informationCategories->paginate($per_page);

            return $informationCategories;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAll()
    {
        try {
            return InformationCategory::orderBy('created_at', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return InformationCategory::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($data)
    {
        try {
            $informationCategory = new InformationCategory();
            $informationCategory->id = Str::uuid();
            $informationCategory->slug = $data->slug;
            $informationCategory->name = $data->name;
            $informationCategory->save();
            return $informationCategory;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($data, $id)
    {
        try {
            $informationCategories = InformationCategory::where('id', '!=', $id)->get();
            $informationCategory = InformationCategory::find($id);
            $informationCategory->name = $data->name;
            $informationCategory->slug = $data->slug;
            $informationCategory->save();

            return $informationCategory;
            // foreach ($informationCategories as $key => $value) {
            //     if ($value->name == $informationCategory->name) {
            //         return redirect()->back()->with('error', 'Kategori ' . $informationCategory->name . ' sudah ada');
            //     }
            // }
            // $informationCategory->slug = str_replace(' ', '-', strtolower($data->name));
            // $informationCategory->save();
            // return redirect()->back()->with('success', 'Kategori informasi telah diperbarui');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $informationCategory = InformationCategory::find($id);
            $informationCategory->delete();
            return $informationCategory;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}