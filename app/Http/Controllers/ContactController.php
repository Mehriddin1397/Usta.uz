<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;

class ContactController extends Controller
{
    /**
     * Show the contact form.
     */
    public function show()
    {
        return view('contact');
    }

    /**
     * Handle contact form submission.
     */
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|in:general,technical,master,payment,complaint,suggestion',
            'message' => 'required|string|max:2000',
        ]);

        $contactData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'user_id' => auth()->id(),
            'created_at' => now(),
        ];

        // Store in database (you can create a contacts table if needed)
        // Contact::create($contactData);

        // Send email to admin
        try {
            Mail::to('admin@usta.uz')->send(new ContactMessage($contactData));
            
            return redirect()->back()->with('success', 'Xabaringiz muvaffaqiyatli yuborildi! Tez orada javob beramiz.');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Contact form email failed: ' . $e->getMessage());
            
            return redirect()->back()->with('success', 'Xabaringiz qabul qilindi! Tez orada javob beramiz.');
        }
    }

    /**
     * Get subject name in Uzbek.
     */
    public static function getSubjectName($subject)
    {
        $subjects = [
            'general' => 'Umumiy savol',
            'technical' => 'Texnik muammo',
            'master' => 'Usta bilan bog\'liq',
            'payment' => 'To\'lov masalasi',
            'complaint' => 'Shikoyat',
            'suggestion' => 'Taklif',
        ];

        return $subjects[$subject] ?? $subject;
    }
}
