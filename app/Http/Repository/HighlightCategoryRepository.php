<?php

namespace App\Http\Repository;

use App\Models\HighlightCategory;
use Illuminate\Support\Str;

class HighlightCategoryRepository
{
    // api
    public function getAllApi($request)
    {
        try {
            $highlightCategories = HighlightCategory::orderBy('created_at', 'desc');

            if ($request->search) {
                $highlightCategories->where('name', 'like', '%' . $request->search . '%');
            }

            if ($request->slug) {
                $highlightCategories->where('slug', 'like', '%' . $request->slug . '%');
            }

            $per_page = $request->per_page;
            if ($per_page) {
                $highlightCategories->paginate($per_page);
            } else {
                $per_page = 10;
            }

            $highlightCategories = $highlightCategories->paginate($per_page);

            return $highlightCategories;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAll()
    {
        try {
            return HighlightCategory::orderBy('created_at', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return HighlightCategory::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($data)
    {
        try {
            $highlightCategory = new HighlightCategory();
            $highlightCategory->id = Str::uuid();
            $highlightCategory->slug = $data->slug;
            $highlightCategory->name = $data->name;
            $highlightCategory->save();
            return $highlightCategory;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($data, $id)
    {
        try {
            $serviceCategories = HighlightCategory::where('id', '!=', $id)->get();
            $highlightCategory = HighlightCategory::find($id);
            $highlightCategory->name = $data->name;
            $highlightCategory->slug = $data->slug;
            $highlightCategory->save();

            return $highlightCategory;
            // foreach ($serviceCategories as $key => $value) {
            //     if ($value->name == $highlightCategory->name) {
            //         return redirect()->back()->with('error', 'Kategori ' . $highlightCategory->name . ' sudah ada');
            //     }
            // }
            // $highlightCategory->slug = str_replace(' ', '-', strtolower($data->name));
            // $highlightCategory->save();
            // return redirect()->back()->with('success', 'Kategori sorot telah diperbarui');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $highlightCategory = HighlightCategory::find($id);
            $highlightCategory->delete();
            return $highlightCategory;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}