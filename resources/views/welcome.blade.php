<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'HelpHub') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="antialiased bg-gray-50">
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-gray-800">
                    {{ config('app.name', 'HelpHub') }}
                </a>
                <div>
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium mr-4">
                            Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cadastre-se
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <section class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
            <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl md:text-6xl">
                Sistema de Chamados Integrado
            </h1>
            <p class="mt-6 max-w-2xl mx-auto text-xl">
                Uma plataforma completa para gerenciamento de chamados, suporte técnico e atendimento ao cliente.
            </p>
            <div class="mt-10">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-white hover:bg-indigo-50 shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Acessar Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-white hover:bg-indigo-50 shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Comece Agora
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-16">
                Principais Funcionalidades
            </h2>
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <!-- Feature 1 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:transform hover:-translate-y-2">
                    <div class="p-6">
                        <div class="w-12 h-12 flex items-center justify-center rounded-md bg-indigo-100 text-indigo-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" />
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                                <line x1="12" y1="22.08" x2="12" y2="12" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Gestão de Chamados</h3>
                        <p class="text-gray-600">Abra, acompanhe e resolva chamados de forma eficiente com nossa interface intuitiva.</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:transform hover:-translate-y-2">
                    <div class="p-6">
                        <div class="w-12 h-12 flex items-center justify-center rounded-md bg-indigo-100 text-indigo-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M16 16s-1.5-2-4-2-4 2-4 2" />
                                <line x1="9" y1="9" x2="9.01" y2="9" />
                                <line x1="15" y1="9" x2="15.01" y2="9" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Avaliação de Satisfação</h3>
                        <p class="text-gray-600">Colete feedback dos usuários para melhorar continuamente seu atendimento.</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:transform hover:-translate-y-2">
                    <div class="p-6">
                        <div class="w-12 h-12 flex items-center justify-center rounded-md bg-indigo-100 text-indigo-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z" />
                                <line x1="4" y1="22" x2="4" y2="15" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Relatórios Detalhados</h3>
                        <p class="text-gray-600">Visualize estatísticas e métricas para tomar decisões baseadas em dados.</p>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:transform hover:-translate-y-2">
                    <div class="p-6">
                        <div class="w-12 h-12 flex items-center justify-center rounded-md bg-indigo-100 text-indigo-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2" />
                                <line x1="8" y1="21" x2="16" y2="21" />
                                <line x1="12" y1="17" x2="12" y2="21" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Acesso Multiplataforma</h3>
                        <p class="text-gray-600">Acesse o sistema de qualquer dispositivo, em qualquer lugar e a qualquer momento.</p>
                    </div>
                </div>

                <!-- Feature 5 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:transform hover:-translate-y-2">
                    <div class="p-6">
                        <div class="w-12 h-12 flex items-center justify-center rounded-md bg-indigo-100 text-indigo-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Gerenciamento de Usuários</h3>
                        <p class="text-gray-600">Controle de acesso com diferentes níveis de permissão para sua equipe.</p>
                    </div>
                </div>

                <!-- Feature 6 -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:transform hover:-translate-y-2">
                    <div class="p-6">
                        <div class="w-12 h-12 flex items-center justify-center rounded-md bg-indigo-100 text-indigo-600 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Dashboard Analítico</h3>
                        <p class="text-gray-600">Acompanhe o desempenho da sua equipe e monitore indicadores-chave em tempo real.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-indigo-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-8">
                Pronto para começar?
            </h2>
            <p class="text-xl text-gray-600 mb-10 max-w-3xl mx-auto">
                Simplifique seu processo de atendimento e melhore a satisfação de seus clientes com nossa plataforma de gerenciamento de chamados.
            </p>
            <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Criar uma conta
            </a>
        </div>
    </section>

    <footer class="bg-gray-800 text-gray-300">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p>© {{ date('Y') }} {{ config('app.name', 'HelpHub') }}. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html>
