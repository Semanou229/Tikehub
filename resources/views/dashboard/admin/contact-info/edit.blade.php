@extends('layouts.admin')

@section('title', 'Informations de Contact')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Informations de Contact</h1>
        <p class="text-gray-600 mt-2">Gérez les informations de contact affichées sur la page de contact</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.contact-info.update') }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $contactInfo->email) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
            </div>

            <div>
                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Téléphone</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $contactInfo->phone) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
            </div>

            <div class="md:col-span-2">
                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Adresse</label>
                <input type="text" name="address" id="address" value="{{ old('address', $contactInfo->address) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
            </div>

            <div>
                <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">Ville</label>
                <input type="text" name="city" id="city" value="{{ old('city', $contactInfo->city) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
            </div>

            <div>
                <label for="postal_code" class="block text-sm font-semibold text-gray-700 mb-2">Code postal</label>
                <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $contactInfo->postal_code) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
            </div>

            <div>
                <label for="country" class="block text-sm font-semibold text-gray-700 mb-2">Pays</label>
                <input type="text" name="country" id="country" value="{{ old('country', $contactInfo->country) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
            </div>

            <div class="md:col-span-2">
                <label for="opening_hours" class="block text-sm font-semibold text-gray-700 mb-2">Heures d'ouverture</label>
                <textarea name="opening_hours" id="opening_hours" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">{{ old('opening_hours', $contactInfo->opening_hours) }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label for="map_embed_code" class="block text-sm font-semibold text-gray-700 mb-2">Code d'intégration Google Maps (iframe)</label>
                <textarea name="map_embed_code" id="map_embed_code" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none font-mono text-sm">{{ old('map_embed_code', $contactInfo->map_embed_code) }}</textarea>
                <p class="text-sm text-gray-500 mt-1">Collez ici le code iframe de Google Maps</p>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Liens réseaux sociaux</label>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="social_facebook" class="block text-xs text-gray-600 mb-1">Facebook</label>
                        <input type="url" name="social_links[facebook]" id="social_facebook" value="{{ old('social_links.facebook', $contactInfo->social_links['facebook'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                    </div>
                    <div>
                        <label for="social_twitter" class="block text-xs text-gray-600 mb-1">Twitter</label>
                        <input type="url" name="social_links[twitter]" id="social_twitter" value="{{ old('social_links.twitter', $contactInfo->social_links['twitter'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                    </div>
                    <div>
                        <label for="social_instagram" class="block text-xs text-gray-600 mb-1">Instagram</label>
                        <input type="url" name="social_links[instagram]" id="social_instagram" value="{{ old('social_links.instagram', $contactInfo->social_links['instagram'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                    </div>
                    <div>
                        <label for="social_linkedin" class="block text-xs text-gray-600 mb-1">LinkedIn</label>
                        <input type="url" name="social_links[linkedin]" id="social_linkedin" value="{{ old('social_links.linkedin', $contactInfo->social_links['linkedin'] ?? '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="bg-red-600 text-white px-8 py-3 rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-save mr-2"></i>Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection

