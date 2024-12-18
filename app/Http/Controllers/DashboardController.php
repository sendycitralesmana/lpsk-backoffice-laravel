<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Information;
use App\Models\News;
use App\Models\Profile;
use App\Models\Publication;
use App\Models\RoadMap;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $applications = Application::get();
        $services = Service::get();
        $profiles = Profile::get();
        $roadmaps = RoadMap::get();
        $settings = Setting::get();
        $publications = Publication::get();
        $news = News::get();
        $informations = Information::get();

        return view('backoffice.dashboard.index', compact('applications', 'services', 'profiles', 'roadmaps', 'settings', 'publications', 'news', 'informations'));
    }
}
