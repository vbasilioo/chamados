@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">Chamados</h2>
                        <p class="mt-1 text-sm text-gray-600">Lista de todos os chamados</p>
                    </div>
                    <a href="{{ route('tickets.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Novo Chamado</a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Filtros -->
                <div class="mb-6">
                    <form action="{{ route('tickets.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
                        <div class="flex-1 min-w-[200px]">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Título ou descrição" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>
                        <div class="flex-1 min-w-[150px]">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Todos</option>
                                <option value="aberto" {{ request('status') == 'aberto' ? 'selected' : '' }}>Aberto</option>
                                <option value="em_andamento" {{ request('status') == 'em_andamento' ? 'selected' : '' }}>Em andamento</option>
                                <option value="resolvido" {{ request('status') == 'resolvido' ? 'selected' : '' }}>Resolvido</option>
                                <option value="fechado" {{ request('status') == 'fechado' ? 'selected' : '' }}>Fechado</option>
                            </select>
                        </div>
                        <div class="flex-1 min-w-[150px]">
                            <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Prioridade</label>
                            <select name="priority" id="priority" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Todas</option>
                                <option value="baixa" {{ request('priority') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                                <option value="media" {{ request('priority') == 'media' ? 'selected' : '' }}>Média</option>
                                <option value="alta" {{ request('priority') == 'alta' ? 'selected' : '' }}>Alta</option>
                                <option value="critica" {{ request('priority') == 'critica' ? 'selected' : '' }}>Crítica</option>
                            </select>
                        </div>
                        <div class="flex-1 min-w-[150px]">
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                            <select name="category_id" id="category_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Todas</option>
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="flex items-end space-x-2">
                            <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition mt-6">Filtrar</button>
                            <a href="{{ route('tickets.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition mt-6">Limpar</a>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioridade</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Solicitante</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsável</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Criado em</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($tickets as $ticket)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm text-gray-500">#{{ $ticket->id }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-900">{{ $ticket->title }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-500">{{ optional($ticket->category)->name ?? 'Não definida' }}</td>
                                    <td class="py-3 px-4 text-sm">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($ticket->status == 'aberto') bg-green-100 text-green-800
                                            @elseif($ticket->status == 'em_andamento') bg-blue-100 text-blue-800
                                            @elseif($ticket->status == 'resolvido') bg-purple-100 text-purple-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-sm">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($ticket->priority == 'baixa') bg-gray-100 text-gray-800
                                            @elseif($ticket->priority == 'media') bg-yellow-100 text-yellow-800
                                            @elseif($ticket->priority == 'alta') bg-orange-100 text-orange-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($ticket->priority) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-500">{{ $ticket->user->name }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-500">
                                        {{ optional($ticket->assignedUser)->name ?? 'Não atribuído' }}
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-500">{{ $ticket->created_at->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-500 flex space-x-2">
                                        <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                                        <a href="{{ route('tickets.edit', $ticket) }}" class="text-amber-600 hover:text-amber-900">Editar</a>
                                        <form method="POST" action="{{ route('tickets.destroy', $ticket) }}" onsubmit="return confirm('Tem certeza que deseja excluir este chamado?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 bg-transparent p-0 border-0">
                                                Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="py-3 px-4 text-center text-gray-500">Nenhum chamado encontrado</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <div class="mt-4">
                    {{ $tickets->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 