@extends('layouts.dashboard')

@section('title', 'Pipeline CRM')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Pipeline CRM</h1>
        <p class="text-gray-600 mt-1">Gérez vos relations avec un système Kanban</p>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        @php
            $stageLabels = [
                'prospect' => 'Prospect',
                'confirmed' => 'Confirmé',
                'partner' => 'Partenaire',
                'closed' => 'Clôturé'
            ];
        @endphp
        @foreach(['prospect', 'confirmed', 'partner', 'closed'] as $stage)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-sm text-gray-600 mb-1">{{ $stageLabels[$stage] }}</div>
                <div class="text-3xl font-bold text-blue-600">{{ $stats[$stage] }}</div>
            </div>
        @endforeach
    </div>

    <!-- Kanban Board -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6" id="kanbanBoard">
        @php
            $stageLabels = [
                'prospect' => 'Prospect',
                'confirmed' => 'Confirmé',
                'partner' => 'Partenaire',
                'closed' => 'Clôturé'
            ];
        @endphp
        @foreach(['prospect', 'confirmed', 'partner', 'closed'] as $stage)
            <div class="bg-gray-50 rounded-lg p-4 min-h-[600px]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-gray-800">{{ $stageLabels[$stage] }}</h3>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                        {{ $contactsByStage[$stage]->count() }}
                    </span>
                </div>
                <div class="space-y-3" data-stage="{{ $stage }}" id="stage-{{ $stage }}">
                    @foreach($contactsByStage[$stage] as $contact)
                        <div class="bg-white rounded-lg shadow-sm p-4 cursor-move hover:shadow-md transition contact-card" 
                             data-contact-id="{{ $contact->id }}"
                             draggable="true">
                            <div class="font-semibold text-gray-900 mb-1">{{ $contact->first_name }} {{ $contact->last_name }}</div>
                            @if($contact->company)
                                <div class="text-sm text-gray-600 mb-3">{{ $contact->company }}</div>
                            @endif
                            <div class="flex flex-wrap gap-2">
                                @if($contact->category)
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst($contact->category) }}
                                    </span>
                                @endif
                                @if($contact->tags && $contact->tags->count() > 0)
                                    @foreach($contact->tags->take(2) as $tag)
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-700">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
// Drag and Drop pour le pipeline Kanban
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.contact-card');
    const columns = document.querySelectorAll('[data-stage]');

    cards.forEach(card => {
        card.addEventListener('dragstart', handleDragStart);
        card.addEventListener('dragend', handleDragEnd);
    });

    columns.forEach(column => {
        column.addEventListener('dragover', handleDragOver);
        column.addEventListener('drop', handleDrop);
        column.addEventListener('dragenter', handleDragEnter);
        column.addEventListener('dragleave', handleDragLeave);
    });

    let draggedElement = null;
    let draggedFromStage = null;

    function handleDragStart(e) {
        draggedElement = this;
        draggedFromStage = this.closest('[data-stage]').dataset.stage;
        this.style.opacity = '0.5';
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/html', this.outerHTML);
    }

    function handleDragEnd(e) {
        this.style.opacity = '1';
        // Retirer les classes de style de drop
        columns.forEach(col => {
            col.classList.remove('bg-blue-50', 'border-2', 'border-blue-300');
        });
    }

    function handleDragEnter(e) {
        if (e.preventDefault) {
            e.preventDefault();
        }
        this.classList.add('bg-blue-50', 'border-2', 'border-blue-300');
    }

    function handleDragLeave(e) {
        this.classList.remove('bg-blue-50', 'border-2', 'border-blue-300');
    }

    function handleDragOver(e) {
        if (e.preventDefault) {
            e.preventDefault();
        }
        e.dataTransfer.dropEffect = 'move';
        return false;
    }

    function handleDrop(e) {
        if (e.stopPropagation) {
            e.stopPropagation();
        }

        this.classList.remove('bg-blue-50', 'border-2', 'border-blue-300');

        if (draggedElement !== null) {
            const newStage = this.closest('[data-stage]').dataset.stage;
            const contactId = draggedElement.dataset.contactId;

            if (newStage !== draggedFromStage) {
                // Mettre à jour via AJAX
                fetch(`{{ route('organizer.crm.pipeline.updateStage', '') }}/${contactId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ pipeline_stage: newStage })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Déplacer la carte visuellement
                        this.appendChild(draggedElement);
                        
                        // Mettre à jour les compteurs sans recharger
                        updateCounters();
                        
                        // Afficher un message de succès
                        showNotification('Contact déplacé avec succès', 'success');
                    } else {
                        showNotification('Erreur lors du déplacement', 'error');
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showNotification('Erreur lors de la mise à jour', 'error');
                    location.reload();
                });
            }
        }

        return false;
    }

    function updateCounters() {
        // Mettre à jour les compteurs des colonnes
        const stages = ['prospect', 'confirmed', 'partner', 'closed'];
        stages.forEach(stage => {
            const column = document.querySelector(`#stage-${stage}`);
            const count = column ? column.querySelectorAll('.contact-card').length : 0;
            const badge = document.querySelector(`[data-stage="${stage}"]`).previousElementSibling.querySelector('span');
            if (badge) {
                badge.textContent = count;
            }
        });

        // Mettre à jour les cartes de statistiques en haut
        stages.forEach(stage => {
            const statsCard = Array.from(document.querySelectorAll('.bg-white.rounded-lg.shadow-md')).find(card => {
                return card.textContent.includes(getStageLabel(stage));
            });
            if (statsCard) {
                const column = document.querySelector(`#stage-${stage}`);
                const count = column ? column.querySelectorAll('.contact-card').length : 0;
                const countElement = statsCard.querySelector('.text-3xl');
                if (countElement) {
                    countElement.textContent = count;
                }
            }
        });
    }

    function getStageLabel(stage) {
        const labels = {
            'prospect': 'Prospect',
            'confirmed': 'Confirmé',
            'partner': 'Partenaire',
            'closed': 'Clôturé'
        };
        return labels[stage] || stage;
    }

    function showNotification(message, type) {
        // Créer une notification temporaire
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
});
</script>
@endpush
@endsection

