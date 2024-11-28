<?php

namespace App\Http\Repository;

use App\Models\PublicationCategory;
use Illuminate\Support\Str;

class PublicationCategoryRepository
{
    // api
    public function getAllApi($request)
    {
        try {
            $publicationCategories = PublicationCategory::orderBy('created_at', 'desc');

            if ($request->search) {
                $publicationCategories->where('name', 'like', '%' . $request->search . '%');
            }

            if ($request->slug) {
                $publicationCategories->where('slug', 'like', '%' . $request->slug . '%');
            }

            $per_page = $request->per_page;
            if ($per_page) {
                $publicationCategories->paginate($per_page);
            } else {
                $per_page = 10;
            }

            $publicationCategories = $publicationCategories->paginate($per_page);

            return $publicationCategories;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAll()
    {
        try {
            return PublicationCategory::orderBy('created_at', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return PublicationCategory::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($data)
    {
        try {
            $publicationCategory = new PublicationCategory();
            $publicationCategory->id = Str::uuid();
            $publicationCategory->slug = $data->slug;
            $publicationCategory->name = $data->name;
            $publicationCategory->save();
            return $publicationCategory;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($data, $id)
    {
        try {
            $publicationCategories = PublicationCategory::where('id', '!=', $id)->get();
            $publicationCategory = PublicationCategory::find($id);
            $publicationCategory->name = $data->name;
            $publicationCategory->slug = $data->slug;
            $publicationCategory->save();

            return $publicationCategory;
            // foreach ($publicationCategories as $key => $value) {
            //     if ($value->name == $publicationCategory->name) {
            //         return redirect()->back()->with('error', 'Kategori ' . $publicationCategory->name . ' sudah ada');
            //     }
            // }
            // $publicationCategory->slug = str_replace(' ', '-', strtolower($data->name));
            // $publicationCategory->save();
            // return redirect()->back()->with('success', 'Kategori publikasi telah diperbarui');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $publicationCategory = PublicationCategory::find($id);
            $publicationCategory->delete();
            return $publicationCategory;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}