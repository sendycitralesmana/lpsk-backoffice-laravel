<?php

namespace App\Http\Repository;

use App\Models\NewsCategory;
use Illuminate\Support\Str;

class NewsCategoryRepository
{
    // api
    public function getAllApi($request)
    {
        try {
            $news = NewsCategory::orderBy('created_at', 'desc');

            if ($request->search) {
                $news->where('name', 'like', '%' . $request->search . '%');
            }

            if ($request->slug) {
                $news->where('slug', 'like', '%' . $request->slug . '%');
            }

            $per_page = $request->per_page;
            if ($per_page) {
                $news->paginate($per_page);
            } else {
                $per_page = 10;
            }

            $news = $news->paginate($per_page);

            return $news;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAll()
    {
        try {
            return NewsCategory::orderBy('created_at', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return NewsCategory::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($data)
    {
        try {
            $newsCategory = new NewsCategory();
            $newsCategory->id = Str::uuid();
            $newsCategory->name = $data->name;
            $newsCategory->slug = $data->slug;
            $newsCategory->save();
            return $newsCategory;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($data, $id)
    {
        try {
            $newsCategories = NewsCategory::where('id', '!=', $id)->get();
            $newsCategory = NewsCategory::find($id);
            $newsCategory->name = $data->name;
            $newsCategory->slug = $data->slug;
            $newsCategory->save();

            return $newsCategory;
            // foreach ($newsCategories as $key => $value) {
            //     if ($value->name == $newsCategory->name) {
            //         return redirect()->back()->with('error', 'Kategori ' . $newsCategory->name . ' sudah ada');
            //     }
            // }
            // $newsCategory->slug = str_replace(' ', '-', strtolower($data->name));
            // $newsCategory->save();
            // return redirect()->back()->with('success', 'Kategori berita telah diperbarui');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $newsCategory = NewsCategory::find($id);
            $newsCategory->delete();
            return $newsCategory;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}