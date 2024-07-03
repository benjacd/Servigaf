<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Horas Agendadas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Filtro por Estado de Aceptación -->
                    <form method="GET" action="{{ route('repairs.index') }}" class="mb-4">
                        <div class="flex flex-wrap">
                            <div class="w-full md:w-1/3 px-3 mb-4 md:mb-0">
                                <label for="filter_status" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">{{ __('Estado de aceptación') }}</label>
                                <select id="filter_status" name="filter_status" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="">{{ __('Todos') }}</option>
                                    <option value="accepted" {{ request('filter_status') == 'accepted' ? 'selected' : '' }}>{{ __('Aceptadas') }}</option>
                                    <option value="not_accepted" {{ request('filter_status') == 'not_accepted' ? 'selected' : '' }}>{{ __('No Aceptadas') }}</option>
                                </select>
                            </div>
                            <div class="w-full md:w-1/3 px-3 flex items-end">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    {{ __('Filtrar por Estado') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Filtro por Rango de Fechas -->
                    <form method="GET" action="{{ route('repairs.index') }}" class="mb-4">
                        <div class="flex flex-wrap">
                            <div class="w-full md:w-1/3 px-3 mb-4 md:mb-0">
                                <label for="start_date" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">{{ __('Fecha Inicio') }}</label>
                                <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="appearance-none block w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div class="w-full md:w-1/3 px-3 mb-4 md:mb-0">
                                <label for="end_date" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">{{ __('Fecha Fin') }}</label>
                                <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="appearance-none block w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div class="w-full md:w-1/3 px-3 flex items-end">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    {{ __('Filtrar por Fecha') }}
                                </button>
                            </div>
                        </div>
                    </form>

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
                                    <form action="{{ route('repairs.destroy', $repair->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline"
                                                onclick="return confirm('{{ __('¿Estás seguro de que deseas cancelar esta hora?') }}')">
                                            {{ __('Cancelar') }}
                                        </button>
                                    </form>
                                    <form action="{{ route('repairs.update', $repair->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="repair_accepted" value="{{ $repair->repair_accepted ? 0 : 1 }}">
                                        <button type="submit" class="text-sm bg-green-500 hover:bg-green-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">
                                            {{ $repair->repair_accepted ? __('Rechazar') : __('Aceptar') }}
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
</x-app-layout>
