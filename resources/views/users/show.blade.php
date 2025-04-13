@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">Perfil de Usuário</h2>
                        <p class="mt-1 text-sm text-gray-600">Detalhes do usuário {{ $user->name }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('users.edit', $user) }}" class="px-4 py-2 bg-amber-500 text-white rounded hover:bg-amber-600 transition">Editar</a>
                        <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Voltar</a>
                    </div>
                </div>
                
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-8">
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Nome</dt>
                            <dd class="mt-1 text-lg text-gray-900">{{ $user->name }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-lg text-gray-900">{{ $user->email }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Data de Cadastro</dt>
                            <dd class="mt-1 text-lg text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Funções</dt>
                            <dd class="mt-1">
                                <div class="flex flex-wrap gap-2">
                                    @forelse ($user->roles as $role)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @empty
                                        <span class="text-gray-500">Nenhuma função atribuída</span>
                                    @endforelse
                                </div>
                            </dd>
                        </div>
                    </dl>
                </div>
                
                <!-- Tickets criados pelo usuário -->
                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Chamados Criados</h3>
                    
                    @php
                        $tickets = $user->tickets()->latest()->take(5)->get();
                    @endphp
                    
                    @if($tickets->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($tickets as $ticket)
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-3 px-4 text-sm text-gray-500">#{{ $ticket->id }}</td>
                                            <td class="py-3 px-4 text-sm text-gray-900">{{ $ticket->title }}</td>
                                            <td class="py-3 px-4 text-sm">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $ticket->status === 'open' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $ticket->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $ticket->status === 'resolved' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $ticket->status === 'closed' ? 'bg-gray-100 text-gray-800' : '' }}">
                                                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-sm text-gray-500">{{ $ticket->created_at->format('d/m/Y') }}</td>
                                            <td class="py-3 px-4 text-sm text-gray-500">
                                                <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 text-right">
                            <a href="{{ route('tickets.index') }}" class="text-sm text-blue-600 hover:text-blue-900">Ver todos os chamados</a>
                        </div>
                    @else
                        <p class="text-gray-500 italic">Este usuário ainda não criou nenhum chamado.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 