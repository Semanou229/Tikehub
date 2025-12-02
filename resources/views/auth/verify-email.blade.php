@extends('layouts.app')

@section('title', 'Vérification de votre email - Tikehub')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-xl p-6 sm:p-8">
            <div class="text-center mb-6">
                <div class="inline-block bg-gradient-to-br from-indigo-600 to-purple-600 p-3 rounded-lg mb-4">
                    <i class="fas fa-envelope-open text-white text-3xl"></i>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">Vérifiez votre email</h2>
                <p class="text-sm sm:text-base text-gray-600">
                    @if(session('success'))
                        {{ session('success') }}
                    @else
                        Nous avons envoyé un lien de vérification à votre adresse email.
                    @endif
                </p>
            </div>

            <div class="bg-indigo-50 border-l-4 border-indigo-500 p-4 mb-6 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-indigo-500 text-xl"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-indigo-700">
                            <strong>Important :</strong> Vérifiez votre boîte de réception (et vos spams) pour trouver l'email de vérification. 
                            Le lien expirera dans 60 minutes.
                        </p>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="space-y-4">
                <p class="text-sm text-gray-600 text-center">
                    Vous n'avez pas reçu l'email ? Vérifiez votre dossier spam ou demandez un nouveau lien.
                </p>

                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-3 px-4 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-base min-h-[48px] flex items-center justify-center">
                        <i class="fas fa-paper-plane mr-2"></i>
                        <span>Renvoyer l'email de vérification</span>
                    </button>
                </form>

                <div class="text-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 hover:text-indigo-600 font-medium">
                            Se déconnecter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

