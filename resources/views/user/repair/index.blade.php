<x-user-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Horas Agendadas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="w-full bg-white shadow-md rounded mb-4">
                        <thead class="bg-gray-300 font-bold">
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Fecha y Hora') }}</th>
                            <th>{{ __('Producto') }}</th>
                            <th>{{ __('Categoría') }}</th>
                            <th>{{ __('Detalle del Problema') }}</th>
                            <th>{{ __('Aceptado') }}</th>
                            <th>{{ __('Acciones') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($repairs as $repair)
                            <tr class="text-center {{ $loop->index % 2 == 1 ? 'bg-gray-100' : '' }}">
                                <th scope="row" class="py-5">{{ $repair->id }}</th>
                                <td>{{ \Carbon\Carbon::parse($repair->repair_date)->format('Y-m-d H:i') }}</td>
                                <td>{{ $repair->product }}</td>
                                <td>{{ $repair->category }}</td>
                                <td>{{ $repair->repair_detail }}</td>
                                <td>{{ $repair->repair_accepted ? __('Sí') : __('No') }}</td>
                                <td>
                                    <a type="button"
                                       class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline"
                                       href="{{ route('repair.edit', $repair->id) }}">
                                        {{ __('Editar') }}
                                    </a>
                                    <form action="{{ route('repair.destroy', $repair->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline"
                                                onclick="return confirm('{{ __('¿Estás seguro de que deseas cancelar esta hora?') }}')">
                                            {{ __('Cancelar') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <th>#</th>
                                <td colspan="6">{{ __('No tienes horas agendadas.') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    {{ $repairs->links() }}
                </div>
            </div>
        </div>
    </div>
</x-user-layout>
