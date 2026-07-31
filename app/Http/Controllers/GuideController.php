<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GuideController extends Controller
{
    /**
     * Display a listing of guides.
     */
    public function index(): Response
    {
        $guides = Guide::with('user')
            ->when(request('search'), function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->when(request('category'), function ($query, $category) {
                $query->where('category', $category);
            })
            ->when(request('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->orderBy(request('sort', 'created_at'), request('direction', 'desc'))
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('Guides/Index', [
            'guides' => $guides,
            'filters' => request()->only(['search', 'category', 'status', 'sort', 'direction']),
            'categories' => Guide::distinct()->pluck('category')->filter()->values(),
        ]);
    }

    /**
     * Show the form for creating a new guide.
     */
    public function create(): Response
    {
        return Inertia::render('Guides/Create');
    }

    /**
     * Store a newly created guide.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'content' => 'required|string',
            'category' => 'nullable|string|max:100',
            'image_url' => 'nullable|url|max:255',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ]);

        $guide = Guide::create([
            ...$validated,
            'user_id' => Auth::id(),
            'slug' => Str::slug($validated['title']),
        ]);

        return redirect()->route('guides.index')
            ->with('success', 'Guide created successfully!');
    }

    /**
     * Display the specified guide.
     */
    public function show(Guide $guide): Response
    {
        // Increment views
        $guide->increment('views');

        return Inertia::render('Guides/Show', [
            'guide' => $guide->load('user'),
            'relatedGuides' => Guide::where('category', $guide->category)
                ->where('id', '!=', $guide->id)
                ->published()
                ->take(4)
                ->get(),
        ]);
    }

    /**
     * Show the form for editing the specified guide.
     */
    public function edit(Guide $guide): Response
    {
        // Check if user is authorized
        if ($guide->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        return Inertia::render('Guides/Edit', [
            'guide' => $guide,
        ]);
    }

    /**
     * Update the specified guide.
     */
    public function update(Request $request, Guide $guide)
    {
        // Check if user is authorized
        if ($guide->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'content' => 'required|string',
            'category' => 'nullable|string|max:100',
            'image_url' => 'nullable|url|max:255',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ]);

        $guide->update($validated);

        return redirect()->route('guides.index')
            ->with('success', 'Guide updated successfully!');
    }

    /**
     * Remove the specified guide.
     */
    public function destroy(Guide $guide)
    {
        // Check if user is authorized
        if ($guide->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $guide->delete();

        return redirect()->route('guides.index')
            ->with('success', 'Guide deleted successfully!');
    }

    /**
     * Bulk status update
     */
    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:guides,id',
            'status' => 'required|in:draft,published,archived',
        ]);

        Guide::whereIn('id', $validated['ids'])->update([
            'status' => $validated['status'],
        ]);

        return redirect()->back()
            ->with('success', 'Guides updated successfully!');
    }
}
