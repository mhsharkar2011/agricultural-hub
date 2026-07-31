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

class AgriculturalController extends Controller
{
    /**
     * Show the home page
     */
    public function index(): Response
    {
        return Inertia::render('Home', [
            'guides' => Guide::latest()->take(6)->get(),
            'crops' => Crop::take(6)->get(),
            'pestStrategies' => PestStrategy::take(6)->get(),
            'auth' => [
                'user' => Auth::user(),
            ],
        ]);
    }

    /**
     * Show all guides
     */
    public function guides(): Response
    {
        return Inertia::render('Guides', [
            'guides' => Guide::latest()->paginate(12),
        ]);
    }

    /**
     * Show a single guide
     */
    public function showGuide($id): Response
    {
        return Inertia::render('GuideDetail', [
            'guide' => Guide::with('user')->findOrFail($id),
        ]);
    }

    /**
     * Show all crops
     */
    public function crops(): Response
    {
        return Inertia::render('Crops', [
            'crops' => Crop::orderBy('name')->paginate(12),
        ]);
    }

    /**
     * Show a single crop
     */
    public function showCrop($id): Response
    {
        return Inertia::render('CropDetail', [
            'crop' => Crop::findOrFail($id),
        ]);
    }

    /**
     * Show pest control page
     */
    public function pestControl(): Response
    {
        return Inertia::render('PestControl', [
            'strategies' => PestStrategy::paginate(12),
        ]);
    }

    /**
     * Show a single pest strategy
     */
    public function showPestStrategy($id): Response
    {
        return Inertia::render('PestStrategyDetail', [
            'strategy' => PestStrategy::findOrFail($id),
        ]);
    }

    /**
     * Show contact page
     */
    public function contact(): Response
    {
        return Inertia::render('Contact');
    }

    /**
     * Handle contact form submission
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10',
            'subject' => 'nullable|string|max:255',
        ]);

        Inquiry::create($validated);

        return redirect()->back()->with('success', 'Thank you for your message!');
    }

    /**
     * Show settings page
     */
    public function settings(): Response
    {
        return Inertia::render('Settings');
    }

    /**
     * API endpoints
     */
    public function getGuides()
    {
        return response()->json(Guide::all());
    }

    public function getCrops()
    {
        return response()->json(Crop::all());
    }

    public function getPestStrategies()
    {
        return response()->json(PestStrategy::all());
    }

    public function storeInquiry(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10',
            'phone' => 'nullable|string|max:20',
        ]);

        $inquiry = Inquiry::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Inquiry submitted successfully!',
            'data' => $inquiry
        ], 201);
    }
}
