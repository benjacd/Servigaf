<x-user-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (Auth::user()->client)
                        {{-- Mostrar los datos del cliente --}}
                        <h1 class="text-2xl font-bold">¡Bienvenido de nuevo, {{ Auth::user()->name }}!</h1>
                        <p>Tus datos de cliente:</p>
                        <ul>
                            <li>Nombre: {{ Auth::user()->client->name }}</li>
                            <li>Dirección: {{ Auth::user()->client->address }}</li>
                            <li>Ciudad: {{ Auth::user()->client->city }}</li>
                            <li>Teléfono: {{ Auth::user()->client->phone }}</li>
                        </ul>
                        {{-- Botón para editar --}}
                        <a href="{{ route('client.edit') }}" class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar datos</a>
                    @else
                        {{-- No se necesita mostrar el mensaje --}}
                        {{-- El controlador ya maneja la redirección al formulario --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-user-layout>
