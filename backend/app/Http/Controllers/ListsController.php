<?php

namespace App\Http\Controllers;

use App\Models\Lists;
use App\Models\NewsletterSubscriber;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ListsController extends Controller
{
    /**
     * Get all lists
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $lists = Lists::withCount('subscribers')->get();
        
        return response()->json([
            'lists' => $lists
        ]);
    }

    /**
     * Create a new list
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_default' => 'boolean'
        ]);

        $validatedData['user_id'] = auth()->id();

        $list = Lists::create($validatedData);

        return response()->json([
            'message' => 'List created successfully',
            'list' => $list
        ], 201);
    }

    /**
     * Add subscribers to a list
     *
     * @param Request $request
     * @param Lists $list
     * @return JsonResponse
     */
    public function addSubscribers(Request $request, Lists $list): JsonResponse
    {
        $validatedData = $request->validate([
            'subscribers' => 'required|array',
            'subscribers.*' => 'exists:subscribers,id'
        ]);

        $subscribersAdded = 0;
        foreach ($validatedData['subscribers'] as $subscriberId) {
            // Find the subscriber and ensure it's a single model, not a collection
            $subscriber = NewsletterSubscriber::findOrFail($subscriberId);
            
            // Check if the subscriber is not already in the list
            if (!$list->subscribers()->where('newsletter_subscriber_id', $subscriberId)->exists()) {
                $list->subscribers()->attach($subscriber);
                $subscribersAdded++;
            }
        }

        return response()->json([
            'message' => "$subscribersAdded subscribers added to the list",
            'list' => $list->load('subscribers')
        ]);
    }
}