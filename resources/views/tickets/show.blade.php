@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">Chamado #{{ $ticket->id }}: {{ $ticket->title }}</h2>
                        <p class="mt-1 text-sm text-gray-600">Criado por {{ $ticket->user->name }} em {{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('tickets.edit', $ticket) }}" class="px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600 transition">Editar</a>
                        <a href="{{ route('tickets.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Voltar</a>
                    </div>
                </div>
                
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Status</h3>
                            <p class="mt-1">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $ticket->status === 'open' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $ticket->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $ticket->status === 'resolved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $ticket->status === 'closed' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Prioridade</h3>
                            <p class="mt-1">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $ticket->priority === 'low' ? 'bg-gray-100 text-gray-800' : '' }}
                                {{ $ticket->priority === 'medium' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $ticket->priority === 'high' ? 'bg-orange-100 text-orange-800' : '' }}
                                {{ $ticket->priority === 'urgent' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Categoria</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $ticket->category ?? 'Não especificada' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Atribuído a</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $ticket->assignedUser ? $ticket->assignedUser->name : 'Não atribuído' }}</p>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-2">Descrição</h3>
                        <div class="mt-1 text-sm text-gray-900 bg-white p-4 rounded-md border border-gray-200">
                            {!! nl2br(e($ticket->description)) !!}
                        </div>
                    </div>
                </div>
                
                <!-- Comentários -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Comentários</h3>
                    
                    @if($ticket->comments->count() > 0)
                        <div class="space-y-4">
                            @foreach($ticket->comments as $comment)
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex justify-between items-start">
                                        <div class="text-sm font-medium text-gray-900">{{ $comment->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $comment->created_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                    <div class="mt-2 text-sm text-gray-700">
                                        {!! nl2br(e($comment->comment)) !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 italic">Nenhum comentário ainda.</p>
                    @endif
                    
                    <!-- Formulário de comentário -->
                    <div class="mt-6">
                        <h4 class="text-md font-medium text-gray-900 mb-2">Adicionar comentário</h4>
                        <form action="{{ route('tickets.comments.store', $ticket) }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <textarea name="comment" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required></textarea>
                                @error('comment')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                                    Comentar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 