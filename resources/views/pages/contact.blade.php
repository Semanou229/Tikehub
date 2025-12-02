@extends('layouts.app')

@section('title', 'Contactez-nous - Tikehub')

@section('content')
<!-- Hero Section -->
<section class="py-16 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl sm:text-5xl font-bold mb-4">Contactez-nous</h1>
        <p class="text-xl text-indigo-100 max-w-2xl mx-auto">
            Nous sommes là pour répondre à toutes vos questions
        </p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div>
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Envoyez-nous un message</h2>
                
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nom complet *</label>
                        <input type="text" name="name" id="name" required
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none transition"
                               value="{{ old('name') }}">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" id="email" required
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none transition"
                               value="{{ old('email') }}">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">Sujet *</label>
                        <input type="text" name="subject" id="subject" required
                               class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none transition"
                               value="{{ old('subject') }}">
                        @error('subject')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Message *</label>
                        <textarea name="message" id="message" rows="6" required
                                  class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none transition">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white px-6 py-4 rounded-lg font-semibold text-lg hover:bg-indigo-700 transition duration-300 shadow-lg">
                        <i class="fas fa-paper-plane mr-2"></i>Envoyer le message
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div>
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Nos coordonnées</h2>
                
                @if($contactInfo)
                    <div class="space-y-6">
                        @if($contactInfo->email)
                            <div class="flex items-start">
                                <div class="bg-indigo-100 w-12 h-12 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-envelope text-indigo-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Email</h3>
                                    <a href="mailto:{{ $contactInfo->email }}" class="text-indigo-600 hover:text-indigo-800">
                                        {{ $contactInfo->email }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if($contactInfo->phone)
                            <div class="flex items-start">
                                <div class="bg-purple-100 w-12 h-12 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-phone text-purple-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Téléphone</h3>
                                    <a href="tel:{{ $contactInfo->phone }}" class="text-indigo-600 hover:text-indigo-800">
                                        {{ $contactInfo->phone }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if($contactInfo->address)
                            <div class="flex items-start">
                                <div class="bg-green-100 w-12 h-12 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Adresse</h3>
                                    <p class="text-gray-600">
                                        {{ $contactInfo->address }}<br>
                                        @if($contactInfo->city)
                                            {{ $contactInfo->city }}
                                            @if($contactInfo->postal_code), {{ $contactInfo->postal_code }}@endif
                                        @endif
                                        @if($contactInfo->country)<br>{{ $contactInfo->country }}@endif
                                    </p>
                                </div>
                            </div>
                        @endif

                        @if($contactInfo->opening_hours)
                            <div class="flex items-start">
                                <div class="bg-yellow-100 w-12 h-12 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Heures d'ouverture</h3>
                                    <p class="text-gray-600 whitespace-pre-line">{{ $contactInfo->opening_hours }}</p>
                                </div>
                            </div>
                        @endif

                        @if($contactInfo->social_links && is_array($contactInfo->social_links))
                            <div class="flex items-start">
                                <div class="bg-pink-100 w-12 h-12 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                                    <i class="fas fa-share-alt text-pink-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-3">Réseaux sociaux</h3>
                                    <div class="flex gap-4">
                                        @if(isset($contactInfo->social_links['facebook']))
                                            <a href="{{ $contactInfo->social_links['facebook'] }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-2xl">
                                                <i class="fab fa-facebook"></i>
                                            </a>
                                        @endif
                                        @if(isset($contactInfo->social_links['twitter']))
                                            <a href="{{ $contactInfo->social_links['twitter'] }}" target="_blank" class="text-blue-400 hover:text-blue-600 text-2xl">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        @endif
                                        @if(isset($contactInfo->social_links['instagram']))
                                            <a href="{{ $contactInfo->social_links['instagram'] }}" target="_blank" class="text-pink-600 hover:text-pink-800 text-2xl">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        @endif
                                        @if(isset($contactInfo->social_links['linkedin']))
                                            <a href="{{ $contactInfo->social_links['linkedin'] }}" target="_blank" class="text-blue-700 hover:text-blue-900 text-2xl">
                                                <i class="fab fa-linkedin"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="bg-gray-50 rounded-lg p-6">
                        <p class="text-gray-600">Les informations de contact seront bientôt disponibles.</p>
                    </div>
                @endif

                @if($contactInfo && $contactInfo->map_embed_code)
                    <div class="mt-8">
                        <h3 class="font-semibold text-gray-800 mb-4">Notre localisation</h3>
                        <div class="rounded-lg overflow-hidden shadow-lg">
                            {!! $contactInfo->map_embed_code !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection

