<x-guest-layout>
    <div class="flex py-12 flex-col sm:flex-row xl:px-64">
        <!-- Columna para la imagen -->
        <div class="flex-none w-full sm:w-1/3">
            <img src="{{ asset('images/repair_image.jpg') }}" alt="Repair Image" class="w-full h-full">
        </div>

        <!-- Columna para el formulario -->
        <div class="flex-grow sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Mensaje de bienvenida -->
                    <p class="text-lg mb-4">Bienvenido de nuevo, {{ $client->name }}. Agenda tu hora de reparación.</p>

                    <form action="{{ route('repair.store') }}" method="POST">
                        @csrf

                        <div class="mt-3">
                            <x-label for="product" :value="__('Producto')"/>
                            <x-input name="product" id="product" class="block w-full"
                                     type="text" :value="old('product')" required
                                     placeholder="Ej: Lavadora"/>
                        </div>

                        <div class="mt-3">
                            <x-label for="category" :value="__('Categoría')"/>
                            <select name="category" id="category" class="block w-full">
                                <option value="cocina">Cocina</option>
                                <option value="calefaccion">Calefacción</option>
                                <option value="lavado">Lavado</option>
                                <option value="refrigeracion">Refrigeración</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>

                        <div class="mt-3">
                            <x-label for="repair_detail" :value="__('Detalle problema')"/>
                            <x-input name="repair_detail" id="repair_detail" class="block w-full"
                                     type="text" :value="old('repair_detail')" required
                                     placeholder="Ej: No centrifuga"/>
                        </div>

                        <div class="mt-3">
                            <x-label for="repair_date" :value="__('Fecha y Hora de Reparación')"/>
                            <x-input name="repair_date" id="repair_date" class="block w-full"
                                     type="text" :value="old('repair_date')" required
                                     placeholder="Selecciona la fecha y hora"/>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-3">{{ __('Agendar Hora') }}</x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

<!-- Incluir Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Incluir Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Convertir las fechas reservadas a un formato de fecha adecuado para Flatpickr
    var reservedDates = @json($reservedDates).map(date => new Date(date));

    flatpickr("#repair_date", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "today",
        minuteIncrement: 60,
        defaultHour: 9,
        minTime: "09:00",
        maxTime: "18:00",
        disable: [
            function(date) {
                // disable weekends
                if (date.getDay() === 0 || date.getDay() === 6) {
                    return true;
                }

                // disable reserved dates
                return reservedDates.some(reservedDate => reservedDate.getTime() === date.getTime());
            }
        ]
    });
</script>
