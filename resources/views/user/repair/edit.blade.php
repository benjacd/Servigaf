<x-user-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Hora Agendada') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('repair.update', $repair->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="product" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Producto') }}:</label>
                            <input type="text" name="product" id="product" value="{{ $repair->product }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label for="category" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Categoría') }}:</label>
                            <input type="text" name="category" id="category" value="{{ $repair->category }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label for="repair_detail" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Detalle del Problema') }}:</label>
                            <textarea name="repair_detail" id="repair_detail" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ $repair->repair_detail }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="repair_date" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Fecha y Hora') }}:</label>
                            <input type="datetime-local" name="repair_date" id="repair_date" value="{{ $repair->repair_date->format('Y-m-d\TH:i') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                {{ __('Guardar Cambios') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>
