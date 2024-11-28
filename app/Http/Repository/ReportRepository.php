<?php

namespace App\Http\Repository;

use App\Models\Report;
use Illuminate\Support\Str;

class ReportRepository
{
    // api
    public function getAllApi($request)
    {
        try {
            $reports = Report::orderBy('created_at', 'desc');

            if ($request->search) {
                $reports->where('name', 'like', '%' . $request->search . '%');
            }

            $per_page = $request->per_page;
            if ($per_page) {
                $reports->paginate($per_page);
            } else {
                $per_page = 10;
            }

            $reports = $reports->paginate($per_page);

            return $reports;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAll()
    {
        try {
            return Report::orderBy('created_at', 'desc')->get();
        } catch (\Throwable $th) {
            throw $th;
        }    
    }

    public function getById($id)
    {
        try {
            return Report::find($id);
        } catch (\Throwable $th) {
            throw $th;
        }    
    }

    public function store($data)
    {
        try {
            $report = new Report();
            $report->id = Str::uuid();
            $report->name = $data->name;
            $report->identity = $data->identity;
            $report->email = $data->email;
            $report->gender = $data->gender;
            $report->description = $data->description;
            $report->address = $data->address;
            $report->phone = $data->phone;
            $report->fax = $data->fax;
            $report->save();

            return $report;
        } catch (\Throwable $th) {
            throw $th;
        }    
    }

    public function delete($id)
    {
        try {
            $report = Report::find($id);
            $report->delete();
            return $report;
        } catch (\Throwable $th) {
            throw $th;
        }    
    }

}   