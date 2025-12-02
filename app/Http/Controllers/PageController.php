<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function howItWorks()
    {
        return view('pages.how-it-works');
    }
    
    public function faq()
    {
        $faqs = \App\Models\Faq::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get()
            ->groupBy('category');
        
        return view('pages.faq', compact('faqs'));
    }
    
    public function contact()
    {
        $contactInfo = \App\Models\ContactInfo::first();
        return view('pages.contact', compact('contactInfo'));
    }
    
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        
        // Enregistrer le message de contact
        \App\Models\ContactMessage::create($validated);
        
        // TODO: Envoyer un email de notification
        
        return redirect()->route('contact')->with('success', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.');
    }
}

