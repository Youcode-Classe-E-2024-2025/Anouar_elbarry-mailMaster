<?php

namespace App\Http\Controllers;

use App\Models\Mail;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MailController extends Controller
{
    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * Send test email
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sendTest(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'subject' => 'required|string',
            'content' => 'required|string',
            'email' => 'required|email'
        ]);

        $result = $this->mailService->sendTestEmail(
            [
                'subject' => $validatedData['subject'],
                'content' => $validatedData['content']
            ],
            $validatedData['email']
        );

        return response()->json([
            'message' => $result 
                ? 'Test email sent successfully' 
                : 'Failed to send test email'
        ], $result ? 200 : 500);
    }

    /**
     * Track email opens
     *
     * @param string $mailId
     * @return \Illuminate\Http\Response
     */
    public function trackOpen(string $mailId)
    {
        $mail = Mail::findOrFail($mailId);
        $mail->update(['opened_at' => now()]);

        // Transparent 1x1 pixel gif
        $pixel = base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
        return response($pixel, 200, [
            'Content-Type' => 'image/gif'
        ]);
    }
}