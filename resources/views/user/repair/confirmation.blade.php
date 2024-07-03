<x-guest-layout>
    <div class="py-12 flex justify-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-center">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif

                    <p class="text-lg mb-4">Estos son los datos de tu reserva:</p>
                    <ul class="text-left">
                        <li><strong>Producto:</strong> {{ $repair->product }}</li>
                        <li><strong>Detalle del problema:</strong> {{ $repair->repair_detail }}</li>
                        <li><strong>Fecha y Hora:</strong> {{ $repair->repair_date }}</li>
                    </ul>

                    <div class="mt-4">
                        <a href="{{ route('repair.edit', $repair->id) }}"
                           class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">
                            {{ __('Editar') }}
                        </a>

                        <form action="{{ route('repair.cancel', $repair->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline"
                                    onclick="return confirm('{{ __('¿Estás seguro de que deseas cancelar esta hora?') }}')">
                                {{ __('Cancelar') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
