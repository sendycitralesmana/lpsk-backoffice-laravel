<?php

namespace App\Http\Repository;

use App\Models\PublicationCategory;

class PublicationCategoryRepository
{
    // api
    public function getAllApi($request)
    {
        try {
            $publicationCategories = PublicationCategory::orderBy('created_at', 'desc');

            if ($request->name) {
                $publicationCategories->where('name', 'like', '%' . $request->name . '%');
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

            foreach ($publicationCategories as $key => $value) {
                if ($value->name == $publicationCategory->name) {
                    return redirect()->back()->with('error', 'Kategori ' . $publicationCategory->name . ' sudah ada');
                }
            }
            $publicationCategory->slug = str_replace(' ', '-', strtolower($data->name));
            $publicationCategory->save();
            return redirect()->back()->with('success', 'Kategori publikasi telah diperbarui');
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