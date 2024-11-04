<?php

namespace App\Http\Repository;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use App\Mail\Auth\VerifyMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserRepository
{

    public function getAll()
    {
        try {
            return User::get();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function customGetAll($request)
    {
        try {
            $qUsers = User::query();
            $sRole = $request->searchRole;
            
            if ($sRole) {
                $qUsers->where('role_id', $sRole);
                $rolee = Role::where('id', $sRole)->first();
            } else {
                $rolee = '';
            }

            $users = $qUsers->get();
            $roles = Role::where('id', '!=', 1)->get();

            return [
                'users' => $users,
                'roles' => $roles,
                'sRole' => $sRole,
                'rolee' => $rolee
            ];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getById($id)
    {
        try {
            return User::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store($request)
    {
        try {
            $password = $request->password;

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(40);
            $user->role_id = $request->role;
            $user->save();

            Mail::to($user->email)->send(new VerifyMail($user, $password));

            return $user;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateRole($request, $id)
    {
        try {
            $user = User::find($id);
            $user->role_id = $request->role;
            $user->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateData($request, $id)
    {
        try {
            $user = User::find($id);
            $user->name = $request->name;
            $user->gender = $request->gender;
            $user->religion = $request->religion;
            $user->place_birth = $request->place_birth;
            $user->date_birth = $request->date_birth;
            $user->address = $request->address;
            $user->no_hp = $request->no_hp;
            if ($request->file('foto')) {
                if ($user->foto) {
                    Storage::disk('s3')->delete($user->foto);
                }
                $file = $request->file('foto');
                $path = Storage::disk('s3')->put('user', $file);
                $user->foto = $path;
            }
            $user->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updatePassword($request, $id)
    {
        try {
            $user = User::find($id);
            $user->password = Hash::make($request->password_baru);
            $user->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $user = User::find($id);
            $user->delete();
            return $user;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}