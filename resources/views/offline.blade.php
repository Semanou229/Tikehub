@extends('layouts.app')

@section('title', 'Hors ligne - ' . config('app.name'))

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="max-w-md w-full text-center">
        <div class="mb-8">
            <i class="fas fa-wifi-slash text-6xl text-gray-400 mb-4"></i>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Vous êtes hors ligne</h1>
            <p class="text-gray-600 mb-6">
                Il semble que vous n'ayez pas de connexion Internet. Veuillez vérifier votre connexion et réessayer.
            </p>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Que pouvez-vous faire ?</h2>
            <ul class="text-left space-y-3 text-gray-600">
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                    <span>Vérifiez votre connexion Wi-Fi ou mobile</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                    <span>Essayez de recharger la page</span>
                </li>
                <li class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                    <span>Certaines pages peuvent être disponibles hors ligne</span>
                </li>
            </ul>
        </div>
        
        <button onclick="window.location.reload()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-lg transition shadow-md hover:shadow-lg">
            <i class="fas fa-redo mr-2"></i>Réessayer
        </button>
        
        <div class="mt-6">
            <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
                <i class="fas fa-home mr-2"></i>Retour à l'accueil
            </a>
        </div>
    </div>
</div>
@endsection

