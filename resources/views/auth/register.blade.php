@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                {{ __('Criar uma nova conta') }}
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                {{ __('Preencha os campos abaixo para se registrar') }}
            </p>
        </div>
        
        <div class="mt-8 bg-white py-8 px-4 shadow-md rounded-md sm:px-10">
            <form class="space-y-6" method="POST" action="{{ route('register') }}">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        {{ __('Nome') }}
                    </label>
                    <div class="mt-1">
                        <input id="name" name="name" type="text" 
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 
                            focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                            @error('name') border-red-500 @enderror"
                            value="{{ old('name') }}" required autocomplete="name" autofocus>
                    </div>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        {{ __('Email') }}
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" 
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 
                            focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                            @error('email') border-red-500 @enderror"
                            value="{{ old('email') }}" required autocomplete="email">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        {{ __('Senha') }}
                    </label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" 
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 
                            focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                            @error('password') border-red-500 @enderror"
                            required autocomplete="new-password">
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password-confirm" class="block text-sm font-medium text-gray-700">
                        {{ __('Confirmar Senha') }}
                    </label>
                    <div class="mt-1">
                        <input id="password-confirm" name="password_confirmation" type="password" 
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 
                            focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required autocomplete="new-password">
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Registrar') }}
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    {{ __('Já tem uma conta?') }}
                    <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        {{ __('Faça login') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
