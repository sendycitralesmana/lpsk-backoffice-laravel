<?php

namespace App\Http\Repository;

use App\Models\ServiceCategory;
use Illuminate\Support\Str;

class ServiceCategoryRepository
{
    // api
    public function getAllApi($request)
    {
        try {
            $serviceCategories = ServiceCategory::orderBy('created_at', 'desc');

            if ($request->search) {
                $serviceCategories->where('name', 'like', '%' . $request->search . '%');
            }

            $per_page = $request->per_page;
            if ($per_page) {
                $serviceCategories->paginate($per_page);
            } else {
                $per_page = 10;
            }

            $serviceCategories = $serviceCategories->paginate($per_page);

            return $serviceCategories;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAll()
    {
        try {
            return ServiceCategory::orderBy('created_at', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return ServiceCategory::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($data)
    {
        try {
            $serviceCategory = new ServiceCategory();
            $serviceCategory->id = Str::uuid();
            $serviceCategory->slug = $data->slug;
            $serviceCategory->name = $data->name;
            $serviceCategory->save();
            return $serviceCategory;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($data, $id)
    {
        try {
            $serviceCategories = ServiceCategory::where('id', '!=', $id)->get();
            $serviceCategory = ServiceCategory::find($id);
            $serviceCategory->name = $data->name;
            $serviceCategory->slug = $data->slug;
            $serviceCategory->save();

            return $serviceCategory;
            // foreach ($serviceCategories as $key => $value) {
            //     if ($value->name == $serviceCategory->name) {
            //         return redirect()->back()->with('error', 'Kategori ' . $serviceCategory->name . ' sudah ada');
            //     }
            // }
            // $serviceCategory->slug = str_replace(' ', '-', strtolower($data->name));
            // $serviceCategory->save();
            // return redirect()->back()->with('success', 'Kategori layanan telah diperbarui');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $serviceCategory = ServiceCategory::find($id);
            $serviceCategory->delete();
            return $serviceCategory;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}