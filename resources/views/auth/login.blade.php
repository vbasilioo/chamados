@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                {{ __('Acesse sua conta') }}
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                {{ __('Entre com seus dados para continuar') }}
            </p>
        </div>
        
        <div class="mt-8 bg-white py-8 px-4 shadow-md rounded-md sm:px-10">
            <form class="space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        {{ __('Email') }}
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" 
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 
                            focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                            @error('email') border-red-500 @enderror"
                            value="{{ old('email') }}" required autocomplete="email" autofocus>
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
                            required autocomplete="current-password">
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" 
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" 
                            {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="ml-2 block text-sm text-gray-900">
                            {{ __('Lembrar de mim') }}
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                                {{ __('Esqueceu sua senha?') }}
                            </a>
                        </div>
                    @endif
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Entrar') }}
                    </button>
                </div>
            </form>
            
            @if (Route::has('register'))
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        {{ __('Não tem uma conta?') }}
                        <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            {{ __('Registre-se') }}
                        </a>
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
