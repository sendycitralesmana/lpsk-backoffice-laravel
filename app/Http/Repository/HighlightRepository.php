<?php

namespace App\Http\Repository;

use App\Models\Highlight;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HighlightRepository
{
    // api
    public function getAllApi($request)
    {
        try {
            $highlight = Highlight::orderBy('created_at', 'desc');

            if ($request->search) {
                $highlight->where('title', 'like', '%' . $request->search . '%');
            }

            if ($request->slug) {
                $highlight->where('slug', 'like', '%' . $request->slug . '%');
            }

            if ($request->category_id) {
                $highlight->where('highlight_category_id', $request->category_id);
            }

            if ($request->category_slug) {   
                $highlight->whereHas('highlightCategory', function ($query) use ($request) {
                    $query->where('slug', $request->category_slug);
                });
            }


            // $per_page = $request->per_page;
            // if ($per_page) {
            //     $highlight->paginate($per_page);
            // } else {
            //     $per_page = 10;
            // }

            // $highlight = $highlight->paginate($per_page);

            $highlight = $highlight->get();

            return $highlight;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAll()
    {
        try {
            return Highlight::orderBy('created_at', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return Highlight::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($data)
    {
        try {
            $highlight = new Highlight();
            $highlight->id = Str::uuid();
            $highlight->highlight_category_id = $data->highlight_category_id;
            $highlight->news_id = $data->news_id;
            $highlight->save();
            return $highlight;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($data, $id)
    {
        try {
            $highlight = Highlight::find($id);
            $highlight->highlight_category_id = $data->highlight_category_id;
            $highlight->news_id = $data->news_id;
            $highlight->save();
            return $highlight;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $highlight = Highlight::find($id);
            $highlight->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}