<?php

namespace App\Http\Controllers;

use App\Http\Repository\ApplicationCategoryRepository;
use App\Http\Repository\ApplicationRepository;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    private $applicationRepository;
    private $applicationCategoryRepository;

    public function __construct(ApplicationRepository $applicationRepository, ApplicationCategoryRepository $applicationCategoryRepository)
    {
        $this->applicationRepository = $applicationRepository;
        $this->applicationCategoryRepository = $applicationCategoryRepository;
    }

    public function index()
    {
        $applicationCategories = $this->applicationCategoryRepository->getAll();
        $applications = $this->applicationRepository->getAll(); 
        return view('backoffice.application.index', compact(['applicationCategories', 'applications']));
    }

    public function create(Request $request)
    {
        try {
            $application = $this->applicationRepository->store($request);
            return redirect()->back()->with('success', 'Aplikasi telah ditambahkan');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $application = $this->applicationRepository->update($request, $id);
            return redirect()->back()->with('success', 'Aplikasi telah diperbarui');
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function delete($id)
    {
        try {
            $application = $this->applicationRepository->delete($id);
            return redirect()->back()->with('success', 'Aplikasi telah dihapus');
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
