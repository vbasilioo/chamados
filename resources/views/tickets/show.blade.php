@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Chamado #{{ $ticket->id }}</h2>
                    <div class="space-x-2">
                        @if($ticket->assigned_to === null && Auth::user()->hasAnyRole(['operador', 'admin']))
                        <form action="{{ route('tickets.accept', $ticket) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Aceitar Chamado
                            </button>
                        </form>
                        @endif
                        @if($ticket->status->value !== 'closed' && $ticket->status->value !== 'resolved' && 
                            (Auth::user()->hasAnyRole(['operador', 'admin']) || $ticket->assigned_to === Auth::id()))
                        <form action="{{ route('tickets.close', $ticket) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                Finalizar Chamado
                            </button>
                        </form>
                        @endif
                        @can('update', $ticket)
                        <a href="{{ route('tickets.edit', $ticket) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Editar
                        </a>
                        @endcan
                        <a href="{{ route('tickets.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Voltar
                        </a>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Informações do Chamado</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Título</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $ticket->title }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Descrição</dt>
                                    <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $ticket->description }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Categoria</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $ticket->category->name }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold mb-4">Status e Atribuição</h3>
                            <dl class="grid grid-cols-1 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ticket->status->value === 'open' ? 'bg-green-100 text-green-800' : ($ticket->status->value === 'closed' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ $ticket->status->label() }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Prioridade</dt>
                                    <dd class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ticket->priority->color() }}">
                                            {{ $ticket->priority->label() }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Criado por</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $ticket->user->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Atribuído para</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $ticket->assignedUser?->name ?? 'Não atribuído' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Criado em</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $ticket->created_at->format('d/m/Y H:i') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Última atualização</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $ticket->updated_at->format('d/m/Y H:i') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                @if($ticket->comments->isNotEmpty())
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Comentários</h3>
                    <div class="space-y-4">
                        @foreach($ticket->comments as $comment)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $comment->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $comment->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="mt-2 text-sm text-gray-700 whitespace-pre-line">
                                {{ $comment->content }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Adicionar Comentário</h3>
                    <form action="{{ route('tickets.comments.store', $ticket) }}" method="POST">
                        @csrf
                        <div>
                            <textarea name="content" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Digite seu comentário..." required></textarea>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Enviar Comentário
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 