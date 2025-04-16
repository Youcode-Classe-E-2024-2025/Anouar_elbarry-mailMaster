<?php

namespace App\Http\Controllers;

use App\Services\CampaignService;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class CampaignController extends Controller
{
    protected $campaignService;

    public function __construct(CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
    }

    /**
     * Create a new campaign
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'list_id' => 'required|exists:lists,id',
            'status' => 'in:draft,scheduled',
            'scheduled_at' => 'nullable|date'
        ]);
    
        $campaign = Campaign::create($validatedData);
    
        return response()->json([
            'message' => 'Campaign created successfully',
            'campaign' => $campaign
        ], 201);
    }
    
    public function sendTest(Request $request)
    {
        $validatedData = $request->validate([
            'subject' => 'required|string',
            'content' => 'required|string'
        ]);
    
        // Send test email to the authenticated user or a predefined test email
        Mail::raw($validatedData['content'], function ($message) use ($validatedData) {
            $message->to(auth()->user()->email)
                    ->subject('Test: ' . $validatedData['subject']);
        });
    
        return response()->json([
            'message' => 'Test email sent successfully'
        ]);
    }
    /**
     * Get all campaigns
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $campaigns = $this->campaignService->getAllCampaigns();

        return response()->json([
            'campaigns' => $campaigns
        ]);
    }
}