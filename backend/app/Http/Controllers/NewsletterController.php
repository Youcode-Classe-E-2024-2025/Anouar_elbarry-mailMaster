<?php

namespace App\Http\Controllers;

use App\Services\NewsletterService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NewsletterController extends Controller
{
    protected $newsletterService;

    public function __construct(NewsletterService $newsletterService)
    {
        $this->newsletterService = $newsletterService;
    }

    /**
     * Subscribe an email to the newsletter
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function subscribe(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email'
        ]);

        try {
            $subscriber = $this->newsletterService->subscribe($validatedData['email']);
            return response()->json([
                'message' => 'Successfully subscribed to newsletter',
                'subscriber' => $subscriber
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Subscription failed',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Unsubscribe an email from the newsletter
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function unsubscribe(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'email' => 'required|email'
        ]);

        try {
            $this->newsletterService->unsubscribe($validatedData['email']);
            return response()->json([
                'message' => 'Successfully unsubscribed from newsletter'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Unsubscription failed',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Send a newsletter campaign
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sendCampaign(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'subject' => 'required|string',
            'content' => 'required|string'
        ]);

        try {
            $campaign = $this->newsletterService->sendCampaign(
                $validatedData['subject'], 
                $validatedData['content']
            );
            return response()->json([
                'message' => 'Newsletter campaign sent successfully',
                'campaign' => $campaign
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Campaign sending failed',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}