@extends('layouts.app')

@section('title', 'FAQ - Questions Fréquentes - Tikehub')

@section('content')
<!-- Hero Section -->
<section class="py-16 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl sm:text-5xl font-bold mb-4">Questions Fréquentes</h1>
        <p class="text-xl text-indigo-100 max-w-2xl mx-auto">
            Trouvez rapidement les réponses à vos questions sur Tikehub
        </p>
    </div>
</section>

<!-- FAQ Content -->
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($faqs->isEmpty())
            <div class="text-center py-12">
                <i class="fas fa-question-circle text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-600 text-lg">Aucune FAQ disponible pour le moment.</p>
            </div>
        @else
            @foreach($faqs as $category => $categoryFaqs)
                @if($category)
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 pb-2 border-b-2 border-indigo-500">
                            {{ $category }}
                        </h2>
                    </div>
                @endif

                <div class="space-y-4 mb-8">
                    @foreach($categoryFaqs as $faq)
                        <div class="faq-item bg-white border-2 border-gray-200 rounded-lg overflow-hidden hover:border-indigo-500 transition-all duration-300">
                            <button class="faq-question w-full text-left p-6 flex items-center justify-between focus:outline-none group" onclick="toggleFaq(this)">
                                <span class="text-lg font-semibold text-gray-800 group-hover:text-indigo-600 transition">{{ $faq->question }}</span>
                                <i class="fas fa-chevron-down text-indigo-600 transform transition-transform duration-300"></i>
                            </button>
                            <div class="faq-answer hidden p-6 pt-0 text-gray-600 leading-relaxed">
                                {!! nl2br(e($faq->answer)) !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif

        <!-- Contact CTA -->
        <div class="mt-12 bg-indigo-50 rounded-2xl p-8 text-center">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Vous ne trouvez pas votre réponse ?</h3>
            <p class="text-gray-600 mb-6">Notre équipe est là pour vous aider. Contactez-nous !</p>
            <a href="{{ route('contact') }}" class="inline-block bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">
                <i class="fas fa-envelope mr-2"></i>Nous contacter
            </a>
        </div>
    </div>
</section>

@push('scripts')
<script>
function toggleFaq(button) {
    const faqItem = button.closest('.faq-item');
    const answer = faqItem.querySelector('.faq-answer');
    const icon = button.querySelector('i');
    
    // Fermer toutes les autres FAQs
    document.querySelectorAll('.faq-item').forEach(item => {
        if (item !== faqItem) {
            item.querySelector('.faq-answer').classList.add('hidden');
            item.querySelector('.faq-question i').classList.remove('rotate-180');
        }
    });
    
    // Toggle la FAQ actuelle
    answer.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
}
</script>
@endpush

@endsection

