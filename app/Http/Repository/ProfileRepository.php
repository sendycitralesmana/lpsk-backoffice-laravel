<?php

namespace App\Http\Repository;

use App\Models\Profile;
use App\Models\ProfileCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileRepository
{
    // api
    public function getAllApi($request)
    {
        try {
            $profile = Profile::orderBy('created_at', 'asc');

            if ($request->search) {
                $profile->where('name', 'like', '%' . $request->search . '%');
            }

            if ($request->category_id) {
                $profile->where('profile_category_id', $request->category_id);
            }

            if ($request->category_slug) {   
                $profile->whereHas('profileCategory', function ($query) use ($request) {
                    $query->where('slug', $request->category_slug);
                });
            }

            $per_page = $request->per_page;
            if ($per_page) {
                $profile->paginate($per_page);
            } else {
                $per_page = 10;
            }

            $profile = $profile->paginate($per_page);

            return $profile;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAll($data)
    {
        try {

            $profile = Profile::orderBy('created_at', 'asc');

            if ($data->search) {
                $profile->where('name', 'like', '%' . $data->search . '%');
            }

            if ($data->category_id) {
                $profile->where('profile_category_id', $data->category_id);
            }

            return $profile->paginate(12);

            // return Profile::orderBy('created_at', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return Profile::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($data)
    {
        try {
            $pejabat = ProfileCategory::where('name', 'Pejabat')->first();

            $profile = new Profile();
            $profile->id = Str::uuid();
            $profile->slug = null;
            // $profile->profile_category_id = $data->profile_category_id;
            $profile->profile_category_id = $pejabat->id;
            $profile->name = $data->name;
            $profile->description = $data->description;
            if ($data->file('foto')) {
                $file = $data->file('foto');
                $path = Storage::disk('s3')->put('/profile', $file);
                $profile->foto = '/' . $path;
            }
            $profile->save();
            return $profile;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update($data, $id)
    {
        try {
            $profiles = Profile::where('id', '!=', $id)->get();
            $profile = Profile::find($id);
            // $profile->profile_category_id = $data->profile_category_id;
            $profile->name = $data->name;
            $profile->description = $data->description;
            // foreach ($profiles as $profile) {
            //     if ($profile->title == $data->title) {
            //         return redirect()->back()->with('error', 'Judul ' . $data->title . ' telah digunakan');
            //     }
            // }
            if ($data->file('foto')) {
                if ($profile->foto) {
                    Storage::disk('s3')->delete($profile->foto);
                }
                $file = $data->file('foto');
                $path = Storage::disk('s3')->put('/profile', $file);
                $profile->foto = '/' . $path;
            }
            // $profile->slug = str_replace(' ', '-', strtolower($data->name));
            $profile->save();
            return $profile;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $profile = Profile::find($id);
            if ($profile->foto) {
                Storage::disk('s3')->delete($profile->foto);
            }
            $profile->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}