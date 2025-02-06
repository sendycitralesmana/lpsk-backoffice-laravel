<?php

namespace App\Http\Repository;

use App\Models\Application;
use App\Models\ApplicationCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApplicationRepository
{
    // api
    public function getAllApi($request)
    {
        try {
            $application = Application::with('applicationCategory')->orderBy('created_at', 'desc');

            if ($request->search) {
                $application->where('title', 'like', '%' . $request->search . '%');
            }

            if ($request->slug) {
                $application->where('slug', 'like', '%' . $request->slug . '%');
            }

            if ($request->category_id) {
                $application->where('application_category_id', $request->category_id);
            }

            if ($request->category_slug) {   
                $application->whereHas('applicationCategory', function ($query) use ($request) {
                    $query->where('slug', $request->category_slug);
                });
            }


            // $per_page = $request->per_page;
            // if ($per_page) {
            //     $application->paginate($per_page);
            // } else {
            //     $per_page = 10;
            // }

            // $application = $application->paginate($per_page);

            $application = $application->get();

            return $application;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAll()
    {
        try {
            return Application::orderBy('created_at', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return Application::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($data)
    {
        try {
            $application = new Application();
            $application->id = Str::uuid();
            
            $application->application_category_id = $data->application_category_id;
            $application->title = $data->title;
            $application->description = $data->description;
            if ($data->file('cover')) {
                $file = $data->file('cover');
                $path = Storage::disk('s3')->put('/application', $file);
                $application->cover = '/' . $path;
            }
            $application->url =  $data->url;
            $application->save();
            return $application;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($data, $id)
    {
        try {
            $applications = Application::where('id', '!=', $id)->get();
            $application = Application::find($id);
            $application->application_category_id = $data->application_category_id;
            $application->title = $data->title;
            $application->description = $data->description;
            // foreach ($applications as $application) {
            //     if ($application->title == $data->title) {
            //         return redirect()->back()->with('error', 'Judul ' . $data->title . ' telah digunakan');
            //     }
            // }
            if ($data->file('cover')) {
                if ($application->cover) {
                    Storage::disk('s3')->delete($application->cover);
                }
                $file = $data->file('cover');
                $path = Storage::disk('s3')->put('/application', $file);
                $application->cover = '/' . $path;
            }
            $application->url = $data->url;
            $application->slug = str_replace(' ', '-', strtolower($data->title));
            $application->save();
            return $application;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $application = Application::find($id);
            if ($application->cover) {
                Storage::disk('s3')->delete($application->cover);
            }
            $application->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}