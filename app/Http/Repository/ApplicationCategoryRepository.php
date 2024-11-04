<?php

namespace App\Http\Repository;

use App\Models\ApplicationCategory;

class ApplicationCategoryRepository
{
    // api
    public function getAllApi($request)
    {
        try {
            $applicationCategories = ApplicationCategory::orderBy('created_at', 'desc');

            if ($request->name) {
                $applicationCategories->where('name', 'like', '%' . $request->name . '%');
            }

            $per_page = $request->per_page;
            if ($per_page) {
                $applicationCategories->paginate($per_page);
            } else {
                $per_page = 10;
            }

            $applicationCategories = $applicationCategories->paginate($per_page);

            return $applicationCategories;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAll()
    {
        try {
            return ApplicationCategory::orderBy('created_at', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return ApplicationCategory::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($data)
    {
        try {
            $applicationCategory = new ApplicationCategory();
            $applicationCategory->name = $data->name;
            $applicationCategory->save();
            return $applicationCategory;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($data, $id)
    {
        try {
            $applicationCategories = ApplicationCategory::where('id', '!=', $id)->get();
            $applicationCategory = ApplicationCategory::find($id);
            $applicationCategory->name = $data->name;

            foreach ($applicationCategories as $key => $value) {
                if ($value->name == $applicationCategory->name) {
                    return redirect()->back()->with('error', 'Kategori ' . $applicationCategory->name . ' sudah ada');
                }
            }
            $applicationCategory->slug = str_replace(' ', '-', strtolower($data->name));
            $applicationCategory->save();
            // redirect()->back()->with('success', 'Kategori aplikasi telah diperbarui');
            return redirect()->back()->with('success', 'Kategori aplikasi telah diperbarui');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $applicationCategory = ApplicationCategory::find($id);
            $applicationCategory->delete();
            return $applicationCategory;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}