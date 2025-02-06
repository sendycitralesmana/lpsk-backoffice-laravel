<?php 

namespace App\Http\Repository;

use App\Models\Publication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublicationRepository
{
    // api
    public function getAllApi($request)
    {
        try {
            $publication = Publication::orderBy('created_at', 'desc')->where('status', 'DINAIKAN');

            if ($request->search) {
                $publication->where('title', 'like', '%' . $request->search . '%');
            }

            if ($request->category_id) {
                $publication->where('publication_category_id', $request->category_id);
            }

            if ($request->category_slug) {   
                $publication->whereHas('publicationCategory', function ($query) use ($request) {
                    $query->where('slug', $request->category_slug);
                });
            }

            if ($request->cover) {
                $publication->where('cover', $request->cover);
                // $publication->where('cover', 'like', '%' . $request->cover . '%');
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

    public function bukuTerbaru()
    {
        try {
            $books = Publication::whereHas('publicationCategory', function ($query) {
                $query->where('slug', 'buku');
            })->orderBy('created_at', 'desc')->where('status', 'DINAIKAN')->limit(4)->get();

            return $books;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function laporanTerbaru()
    {
        try {
            $reports = Publication::whereHas('publicationCategory', function ($query) {
                $query->where('slug', 'laporan');
            })->orderBy('created_at', 'desc')->where('status', 'DINAIKAN')->limit(4)->get();

            return $reports;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function jurnalTerbaru()
    {
        try {
            $journals = Publication::whereHas('publicationCategory', function ($query) {
                $query->where('slug', 'jurnal');
            })->orderBy('created_at', 'desc')->where('status', 'DINAIKAN')->limit(4)->get();

            return $journals;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function buletinTerbaru()
    {
        try {
            $bulletins = Publication::whereHas('publicationCategory', function ($query) {
                $query->where('slug', 'buletin');
            })->orderBy('created_at', 'desc')->where('status', 'DINAIKAN')->limit(4)->get();

            return $bulletins;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAll($data)
    {
        try {

            $publications = Publication::orderBy('created_at', 'desc');

            if ($data->search) {
                $publications->where('title', 'like', '%' . $data->search . '%');
            }

            if ($data->category_id) {
                $publications->where('publication_category_id', $data->category_id);
            }

            if (Auth::user()->role_id == 1) {
                return $publications->paginate(12);
            }   else {
                return $publications->where('user_id', Auth::user()->id)->paginate(12);
            }

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
            $publication->id = Str::uuid();
            $publication->slug = null;
            $publication->title = $data->title;
            $publication->content = $data->description;
            $publication->publication_category_id = $data->publication_category_id;
            $publication->user_id = Auth::user()->id;
            if ($data->file('document_url')) {
                $filename = $data->file('document_url')->getClientOriginalName();
                $publication->document_name = $filename;
                $file = $data->file('document_url');
                $path = Storage::disk('s3')->put('/publication', $file);
                $publication->document_url = '/' . $path;
            }
            if ($data->file('cover')) {
                $file = $data->file('cover');
                $path = Storage::disk('s3')->put('/publication', $file);
                $publication->cover = '/' . $path;
            }
            if (Auth::user()->role_id == 1) {
                $publication->status = "DINAIKAN";
            } else {
                $publication->status = "DIAJUKAN";
            }
            // dd($publication);
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
            $publication->title = $data->title;
            $publication->content = $data->description;
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
                $path = Storage::disk('s3')->put('/publication', $file);
                $publication->document_url = '/' . $path;
            }
            if ($data->file('cover')) {
                if ($publication->cover) {
                    Storage::disk('s3')->delete($publication->cover);
                }
                $file = $data->file('cover');
                $path = Storage::disk('s3')->put('/publication', $file);
                $publication->cover = '/' . $path;
            }
            // $publication->slug = str_replace(' ', '-', strtolower($data->document_name));
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
            if ($publication->cover) {
                Storage::disk('s3')->delete($publication->cover);
            }
            $publication->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}