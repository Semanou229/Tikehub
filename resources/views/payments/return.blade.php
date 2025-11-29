@extends('layouts.app')

@section('title', 'Paiement - Tikehub')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6 text-center">
        @if($payment->status === 'completed')
            <div class="mb-4">
                <i class="fas fa-check-circle text-green-500 text-6xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-green-600 mb-4">Paiement réussi !</h1>
            <p class="text-gray-600 mb-6">Votre paiement a été effectué avec succès.</p>
            <a href="{{ route('dashboard') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 inline-block">
                Voir mes billets
            </a>
        @elseif($payment->status === 'failed')
            <div class="mb-4">
                <i class="fas fa-times-circle text-red-500 text-6xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-red-600 mb-4">Paiement échoué</h1>
            <p class="text-gray-600 mb-6">Votre paiement n'a pas pu être effectué.</p>
            <a href="{{ route('home') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 inline-block">
                Retour à l'accueil
            </a>
        @else
            <div class="mb-4">
                <i class="fas fa-clock text-yellow-500 text-6xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-yellow-600 mb-4">Paiement en cours</h1>
            <p class="text-gray-600 mb-6">Votre paiement est en cours de traitement.</p>
        @endif
    </div>
</div>
@endsection


