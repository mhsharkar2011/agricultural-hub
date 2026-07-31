<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\Guide;
use App\Models\Inquiry;
use App\Models\PestStrategy;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();

        return Inertia::render('Dashboard', [
            'stats' => [
                'guides' => Guide::count(),
                'crops' => Crop::count(),
                'pestStrategies' => PestStrategy::count(),
                'inquiries' => Inquiry::count(),
            ],
            'recentActivities' => Inquiry::latest()->take(5)->get(),
            'user' => $user,
        ]);
    }
}
