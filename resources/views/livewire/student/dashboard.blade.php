<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Projeto;
use Illuminate\Support\Facades\Auth;

new #[Layout('layouts.app')] class extends Component {
    public function with(): array
    {
        $user = Auth::user();
        
        return [
            'projetos' => $user->projetos()->orderBy('created_at', 'desc')->get(),
            'stats' => [
                'total' => $user->projetos()->count(),
                'aprovados' => $user->projetos()->where('status', 'aprovado')->count(),
                'pendentes' => $user->projetos()->where('status', 'pendente')->count(),
                'rejeitados' => $user->projetos()->where('status', 'rejeitado')->count(),
            ],
            'user' => $user,
        ];
    }
    
    public function deleteProject($projectId)
    {
        $project = Auth::user()->projetos()->find($projectId);
        
        if ($project) {
            $project->delete();
            session()->flash('message', 'Projeto eliminado com sucesso.');
        }
    }
}; ?>

<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Olá, {{ $user->name }}! 👋</h1>
                <p class="text-gray-600 mt-1">Bem-vindo ao teu painel de estudante.</p>
            </div>
            <a href="{{ route('submit-project') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                <i class="fas fa-plus mr-2"></i>
                Novo Projeto
            </a>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4">
                        <i class="fas fa-folder-open text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Projetos</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-green-100 text-green-600 mr-4">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Aprovados</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['aprovados'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-yellow-100 text-yellow-600 mr-4">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pendentes</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['pendentes'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-red-100 text-red-600 mr-4">
                        <i class="fas fa-times-circle text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Rejeitados</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['rejeitados'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects List -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Os teus Projetos</h3>
            </div>
            
            @if(session()->has('message'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-6 mt-4 relative" role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif

            <div class="overflow-x-auto">
                @if($projetos->isEmpty())
                    <div class="p-12 text-center text-gray-500">
                        <div class="mb-4 text-gray-300">
                            <i class="fas fa-folder-open text-6xl"></i>
                        </div>
                        <p class="text-lg font-medium">Ainda não tens projetos.</p>
                        <p class="mb-6">Começa por adicionar o teu primeiro projeto!</p>
                        <a href="{{ route('submit-project') }}" class="text-blue-600 hover:text-blue-700 font-medium hover:underline">
                            Criar projeto agora &rarr;
                        </a>
                    </div>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Projeto</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Disciplina</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($projetos as $projeto)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($projeto->imagem_capa)
                                                <img class="h-10 w-10 rounded-lg object-cover mr-3" src="{{ Storage::url($projeto->imagem_capa) }}" alt="">
                                            @else
                                                <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center mr-3 text-gray-500">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @endif
                                            <div class="text-sm font-medium text-gray-900">{{ $projeto->titulo }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="w-2 h-2 rounded-full mr-2" style="background-color: {{ $projeto->disciplina->cor ?? '#ccc' }}"></span>
                                            <span class="text-sm text-gray-500">{{ $projeto->disciplina->nome ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'aprovado' => 'bg-green-100 text-green-800',
                                                'pendente' => 'bg-yellow-100 text-yellow-800',
                                                'rejeitado' => 'bg-red-100 text-red-800',
                                            ];
                                            $statusLabels = [
                                                'aprovado' => 'Aprovado',
                                                'pendente' => 'Pendente',
                                                'rejeitado' => 'Rejeitado',
                                            ];
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$projeto->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $statusLabels[$projeto->status] ?? ucfirst($projeto->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $projeto->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="#" class="text-blue-600 hover:text-blue-900 mr-3" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="text-indigo-600 hover:text-indigo-900 mr-3" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button wire:click="deleteProject({{ $projeto->id }})" wire:confirm="Tens a certeza que queres eliminar este projeto?" class="text-red-600 hover:text-red-900" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
