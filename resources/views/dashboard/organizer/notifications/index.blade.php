@extends('layouts.dashboard')

@section('title', 'Notifications')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Notifications</h1>
            <p class="text-gray-600 mt-2">Restez informé de toutes vos activités</p>
        </div>
        @if($unreadCount > 0)
            <form action="{{ route('organizer.notifications.markAllRead') }}" method="POST">
                @csrf
                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-check-double mr-2"></i>Tout marquer comme lu
                </button>
            </form>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if(count($notifications) > 0)
            <div class="divide-y divide-gray-200">
                @foreach($notifications as $index => $notification)
                    <div class="p-6 hover:bg-gray-50 transition {{ !$notification['read'] ? 'bg-blue-50' : '' }}">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start gap-4 flex-1">
                                <div class="flex-shrink-0">
                                    @if($notification['type'] === 'event')
                                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-{{ $notification['icon'] }} text-indigo-600"></i>
                                        </div>
                                    @elseif($notification['type'] === 'payment')
                                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-{{ $notification['icon'] }} text-green-600"></i>
                                        </div>
                                    @elseif($notification['type'] === 'contest')
                                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-{{ $notification['icon'] }} text-purple-600"></i>
                                        </div>
                                    @else
                                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-{{ $notification['icon'] }} text-gray-600"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-semibold text-gray-900">{{ $notification['title'] }}</h3>
                                        @if(!$notification['read'])
                                            <span class="w-2 h-2 bg-indigo-600 rounded-full"></span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600 mb-2">{{ $notification['message'] }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $notification['time']->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                @if(!$notification['read'])
                                    <form action="{{ route('organizer.notifications.markRead', $index) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-indigo-600 hover:text-indigo-800 p-2 rounded-lg hover:bg-indigo-50" title="Marquer comme lu">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-12 text-center">
                <i class="fas fa-bell-slash text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 mb-2">Aucune notification</p>
                <p class="text-sm text-gray-400">Vous serez notifié lorsque de nouvelles activités se produiront</p>
            </div>
        @endif
    </div>
</div>
@endsection


