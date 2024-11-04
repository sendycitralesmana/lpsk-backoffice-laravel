<?php 

namespace App\Http\Repository;

use App\Models\Publication;
use Illuminate\Support\Facades\Storage;

class PublicationRepository
{
    // api
    public function getAllApi($request)
    {
        try {
            $publication = Publication::orderBy('created_at', 'desc');

            if ($request->document_name) {
                $publication->where('document_name', 'like', '%' . $request->document_name . '%');
            }

            $per_page = $request->per_page;
            if ($per_page) {
                $publication->paginate($per_page);
            } else {
                $per_page = 10;
            }

            $publication = $publication->paginate($per_page);

            return $publication;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAll()
    {
        try {
            return Publication::orderBy('created_at', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return Publication::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($data)
    {
        try {
            $publication = new Publication();
            $publication->publication_category_id = $data->publication_category_id;
            if ($data->file('document_url')) {
                $filename = $data->file('document_url')->getClientOriginalName();
                $publication->document_name = $filename;
                $file = $data->file('document_url');
                $path = Storage::disk('s3')->put('publication', $file);
                $publication->document_url = $path;
            }
            $publication->status = "DIAJUKAN";
            $publication->save();
            return $publication;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($data, $id)
    {
        try {
            $publications = Publication::where('id', '!=', $id)->get();
            $publication = Publication::find($id);
            $publication->publication_category_id = $data->publication_category_id;
            // foreach ($publications as $publication) {
            //     if ($publication->title == $data->title) {
            //         return redirect()->back()->with('error', 'Judul ' . $data->title . ' telah digunakan');
            //     }
            // }
            if ($data->file('document_url')) {
                if ($publication->document_url) {
                    Storage::disk('s3')->delete($publication->document_url);
                }
                $filename = $data->file('document_url')->getClientOriginalName();
                $publication->document_name = $filename;
                $file = $data->file('document_url');
                $path = Storage::disk('s3')->put('publication', $file);
                $publication->document_url = $path;
            }
            $publication->slug = str_replace(' ', '-', strtolower($data->document_name));
            $publication->status = $data->status;
            $publication->save();
            return $publication;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $publication = Publication::find($id);
            if ($publication->document_url) {
                Storage::disk('s3')->delete($publication->document_url);
            }
            $publication->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}