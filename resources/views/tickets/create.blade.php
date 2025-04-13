@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Novo Chamado</h2>
                    <p class="mt-1 text-sm text-gray-600">Preencha os dados para abrir um novo chamado</p>
                </div>

                <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Título -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('title') border-red-500 @enderror" required>
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Categoria -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                            <select name="category_id" id="category_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('category_id') border-red-500 @enderror" required>
                                <option value="">Selecione uma categoria</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Prioridade -->
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Prioridade</label>
                            <select name="priority" id="priority" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('priority') border-red-500 @enderror" required>
                                <option value="baixa" {{ old('priority') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                                <option value="media" {{ old('priority') == 'media' ? 'selected' : '' }}>Média</option>
                                <option value="alta" {{ old('priority') == 'alta' ? 'selected' : '' }}>Alta</option>
                                <option value="critica" {{ old('priority') == 'critica' ? 'selected' : '' }}>Crítica</option>
                            </select>
                            @error('priority')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Responsável (opcional) -->
                        <div>
                            <label for="assignee_id" class="block text-sm font-medium text-gray-700 mb-1">Responsável (opcional)</label>
                            <select name="assignee_id" id="assignee_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('assignee_id') border-red-500 @enderror">
                                <option value="">Selecione um responsável</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('assignee_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('assignee_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Descrição -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descrição</label>
                        <textarea name="description" id="description" rows="5" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('description') border-red-500 @enderror" required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Anexos -->
                    <div class="mb-6">
                        <label for="attachments" class="block text-sm font-medium text-gray-700 mb-1">Anexos (opcional)</label>
                        <input type="file" name="attachments[]" id="attachments" class="w-full border border-gray-300 rounded-md py-2 px-3 @error('attachments') border-red-500 @enderror" multiple>
                        <p class="text-xs text-gray-500 mt-1">Você pode selecionar múltiplos arquivos (máx. 10MB cada)</p>
                        @error('attachments')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        @error('attachments.*')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('tickets.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">Cancelar</a>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Criar Chamado</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 