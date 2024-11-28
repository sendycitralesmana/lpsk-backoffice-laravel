<?php

namespace App\Http\Repository;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceRepository
{
    // api
    public function getAllApi($request)
    {
        try {
            $service = Service::orderBy('created_at', 'desc')->where('status', 'DINAIKAN');

            if ($request->search) {
                $service->where('document_name', 'like', '%' . $request->search . '%');
            }

            if ($request->category_id) {
                $service->where('service_category_id', $request->category_id);
            }

            if ($request->category_slug) {   
                $service->whereHas('serviceCategory', function ($query) use ($request) {
                    $query->where('slug', $request->category_slug);
                });
            }

            $per_page = $request->per_page;
            if ($per_page) {
                $service->paginate($per_page);
            } else {
                $per_page = 10;
            }

            $service = $service->paginate($per_page);

            return $service;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAll()
    {
        try {
            return Service::orderBy('created_at', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return Service::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($data)
    {
        try {
            $service = new Service();
            $service->id = Str::uuid();
            $service->slug = null;
            $service->service_category_id = $data->service_category_id;
            if ($data->file('document_url')) {
                $filename = $data->file('document_url')->getClientOriginalName();
                $service->document_name = $filename;
                $file = $data->file('document_url');
                $path = Storage::disk('s3')->put('service', $file);
                $service->document_url = '/' . $path;
            }
            if (Auth::user()->role_id == 1) {
                $service->status = "DINAIKAN";
            } else {
                $service->status = "DIAJUKAN";
            }
            $service->save();
            return $service;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($data, $id)
    {
        try {
            $services = Service::where('id', '!=', $id)->get();
            $service = Service::find($id);
            $service->service_category_id = $data->service_category_id;
            // foreach ($services as $service) {
            //     if ($service->title == $data->title) {
            //         return redirect()->back()->with('error', 'Judul ' . $data->title . ' telah digunakan');
            //     }
            // }
            if ($data->file('document_url')) {
                if ($service->document_url) {
                    Storage::disk('s3')->delete($service->document_url);
                }
                $filename = $data->file('document_url')->getClientOriginalName();
                $service->document_name = $filename;
                $file = $data->file('document_url');
                $path = Storage::disk('s3')->put('service', $file);
                $service->document_url = '/' . $path;
            }
            // $service->slug = str_replace(' ', '-', strtolower($data->document_name));
            $service->status = $data->status;
            $service->save();
            return $service;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $service = Service::find($id);
            if ($service->document_url) {
                Storage::disk('s3')->delete($service->document_url);
            }
            $service->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}