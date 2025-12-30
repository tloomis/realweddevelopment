<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Send contact form email
     */
    public function send(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        try {
            // Send the email
            Mail::to('info@realwebdevelopment.com')
                ->send(new ContactFormMail($validated));

            // Return JSON for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thank you for your message! I will get back to you soon.'
                ]);
            }

            // Redirect back with success message for regular form submissions
            return redirect()->back()->with('success', 'Thank you for your message! I will get back to you soon.');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Contact form error: ' . $e->getMessage());

            // Return JSON for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, there was an error sending your message. Please try again or email directly at info@realwebdevelopment.com.'
                ], 500);
            }

            // Redirect back with error message for regular form submissions
            return redirect()->back()
                ->withErrors(['error' => 'Sorry, there was an error sending your message. Please try again or email directly.'])
                ->withInput();
        }
    }
}
