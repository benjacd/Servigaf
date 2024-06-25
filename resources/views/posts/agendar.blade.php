<x-guest-layout>
    <div class="flex py-12 flex-col sm:flex-row xl:px-64 ">
        <div class="flex-grow sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>
                                        <x-alerts.error :message="$error" />
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('client.store') }}" method="POST">
                        @csrf
                        <div class="mt-3">
                            <x-label for="name" :value="__('Nombre')"/>
                            <x-input name="name" id="name"
                                     class="block w-full"
                                     type="text"
                                     :value="old('name')"
                                     required
                                     placeholder="Ej: Carlos Bandera Rebolledo"
                            />
                        </div>

                        <div class="mt-3">
                            <x-label for="email" :value="__('Email')"/>
                            <x-input name="email" id="email"
                                     class="block w-full"
                                     type="email"
                                     :value="old('email')"
                                     required
                                     placeholder="Ej: correo@prueba.cl"
                            />
                        </div>

                        <div class="mt-3">
                            <x-label for="phone" :value="__('Telefono de Contacto')"/>
                            <x-input name="phone" id="phone"
                                     class="block w-full"
                                     type="text"
                                     :value="old('phone')"
                                     placeholder="Ej: 9 63468578"
                            />
                        </div>

                        <div class="mt-3">
                            <x-label for="product" :value="__('Producto')"/>
                            <x-input name="product" id="product"
                                     class="block w-full"
                                     type="text"
                                     :value="old('product')"
                                     required
                                     placeholder="Ej: Lavadora"
                            />
                        </div>

                        <div class="mt-3">
                            <x-label for="repair_detail" :value="__('Detalle problema')"/>
                            <x-input name="repair_detail" id="repair_detail"
                                     class="block w-full"
                                     type="text"
                                     :value="old('repair_detail')"
                                     required
                                     placeholder="Ej: No centrifuga"
                            />
                        </div>

                        <div class="mt-3">
                            <x-label for="repair_date" :value="__('Fecha y Hora de Reparación')"/>
                            <x-input name="repair_date" id="repair_date"
                                     class="block w-full"
                                     type="text"
                                     :value="old('repair_date')"
                                     required
                                     placeholder="Selecciona la fecha y hora"
                            />
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
                return (date.getDay() === 0 || date.getDay() === 6);
            }
        ]
    });
</script>
