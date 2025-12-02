<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{
    public function edit()
    {
        $contactInfo = ContactInfo::getInstance();
        return view('dashboard.admin.contact-info.edit', compact('contactInfo'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'map_embed_code' => 'nullable|string',
            'opening_hours' => 'nullable|string',
            'social_links' => 'nullable|array',
        ]);

        $contactInfo = ContactInfo::getInstance();
        $contactInfo->update($validated);

        return redirect()->route('admin.contact-info.edit')->with('success', 'Informations de contact mises à jour avec succès.');
    }
}
