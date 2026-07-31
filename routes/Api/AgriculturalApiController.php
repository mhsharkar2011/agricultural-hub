<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Crop;
use App\Models\Guide;
use App\Models\Inquiry;
use App\Models\PestStrategy;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AgriculturalApiController extends Controller
{
    /**
     * Get all farming guides
     */
    public function getGuides(): JsonResponse
    {
        try {
            $guides = Guide::orderBy('created_at', 'desc')->get();
            return response()->json([
                'success' => true,
                'data' => $guides
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch guides',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all crops
     */
    public function getCrops(): JsonResponse
    {
        try {
            $crops = Crop::orderBy('name')->get();
            return response()->json([
                'success' => true,
                'data' => $crops
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch crops',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all pest control strategies
     */
    public function getPestStrategies(): JsonResponse
    {
        try {
            $strategies = PestStrategy::orderBy('title')->get();
            return response()->json([
                'success' => true,
                'data' => $strategies
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch pest strategies',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new inquiry
     */
    public function storeInquiry(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
            'phone' => 'nullable|string|max:20'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $inquiry = Inquiry::create($validator->validated());

            return response()->json([
                'success' => true,
                'message' => 'Inquiry submitted successfully!',
                'data' => $inquiry
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit inquiry',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store contact form submission
     */
    public function storeContact(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // You can send email, store in database, etc.
            // For now, just return success

            return response()->json([
                'success' => true,
                'message' => 'Thank you for contacting us! We will get back to you soon.',
                'data' => $request->only(['name', 'email', 'message'])
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all inquiries (protected)
     */
    public function getInquiries(): JsonResponse
    {
        try {
            $inquiries = Inquiry::orderBy('created_at', 'desc')->get();
            return response()->json([
                'success' => true,
                'data' => $inquiries
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch inquiries',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single inquiry (protected)
     */
    public function showInquiry($id): JsonResponse
    {
        try {
            $inquiry = Inquiry::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $inquiry
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Inquiry not found'
            ], 404);
        }
    }
}
