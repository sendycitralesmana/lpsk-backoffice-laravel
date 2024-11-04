<?php

namespace App\Http\Repository;

use App\Models\Profile;
use Illuminate\Support\Facades\Storage;

class ProfileRepository
{
    // api
    public function getAllApi($request)
    {
        try {
            $profile = Profile::orderBy('created_at', 'desc');

            if ($request->name) {
                $profile->where('name', 'like', '%' . $request->name . '%');
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

    public function getAll()
    {
        try {
            return Profile::orderBy('created_at', 'desc')->get();
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
            $profile = new Profile();
            $profile->profile_category_id = $data->profile_category_id;
            $profile->name = $data->name;
            $profile->description = $data->description;
            if ($data->file('foto')) {
                $file = $data->file('foto');
                $path = Storage::disk('s3')->put('profile', $file);
                $profile->foto = $path;
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
            $profile->profile_category_id = $data->profile_category_id;
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
                $path = Storage::disk('s3')->put('profile', $file);
                $profile->foto = $path;
            }
            $profile->slug = str_replace(' ', '-', strtolower($data->name));
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