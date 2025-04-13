@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800">Usuários</h2>
                        <p class="mt-1 text-sm text-gray-600">Gerenciar usuários do sistema</p>
                    </div>
                    <a href="{{ route('users.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Novo Usuário</a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Funções</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data de Cadastro</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm text-gray-500">#{{ $user->id }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-900">{{ $user->name }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-500">{{ $user->email }}</td>
                                    <td class="py-3 px-4 text-sm">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($user->roles as $role)
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ ucfirst($role->name) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-500">{{ $user->created_at->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-500 flex space-x-2">
                                        <a href="{{ route('users.show', $user) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                                        <a href="{{ route('users.edit', $user) }}" class="text-amber-600 hover:text-amber-900">Editar</a>
                                        <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 bg-transparent p-0 border-0">
                                                Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 