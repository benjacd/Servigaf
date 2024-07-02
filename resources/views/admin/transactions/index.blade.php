<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transacciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('transactions.index') }}" method="GET" class="mb-4">
                        <div class="flex">
                            <div class="mr-4">
                                <label for="start_date">Desde:</label>
                                <input type="date" id="start_date" name="start_date" class="form-input">
                            </div>
                            <div>
                                <label for="end_date">Hasta:</label>
                                <input type="date" id="end_date" name="end_date" class="form-input">
                            </div>
                            <div class="ml-4">
                                <button type="submit" class="btn btn-primary">Filtrar</button>
                            </div>
                        </div>
                    </form>

                    <table class="w-full bg-white shadow-md rounded mb-4">
                        <thead class="bg-gray-300 font-bold">
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Fecha creación') }}</th>
                                <th>{{ __('Cliente') }}</th>
                                <th>{{ __('Valor transacción') }}</th>
                                <th>{{ __('Pagado') }}</th>
                                <th>{{ __('Enviado') }}</th>
                                <th>{{ __('Acciones') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                                <tr class="text-center {{ $loop->index % 2 == 1 ? 'bg-gray-100' : '' }}">
                                    <th scope="row" class="py-5">{{ $transaction->id }}</th>
                                    <td>{{ $transaction->created_at }}</td>
                                    <td>{{ $transaction->client->name }}</td>
                                    <td>{{ $transaction->final_price }}</td>
                                    <td>{{ $transaction->was_payed ? 'Sí' : 'No' }}</td>
                                    <td>
                                        @if($transaction->was_received)
                                            Sí
                                            <form method="POST" action="{{ route('transactions.markAsNotSent', $transaction) }}" style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="ml-2 text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">
                                                    Marcar como No Enviado
                                                </button>
                                            </form>
                                        @else
                                            No
                                            <form method="POST" action="{{ route('transactions.markAsSent', $transaction) }}" style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="ml-2 text-sm bg-green-500 hover:bg-green-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">
                                                    Marcar como Enviado
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>
                                        <a type="button" class="mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline" href="{{ route('transactions.show', $transaction) }}">
                                            {{ __('Ver transacción') }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <th>#</th>
                                    <td>...</td>
                                    <td>...</td>
                                    <td>...</td>
                                    <td>...</td>
                                    <td>...</td>
                                    <td>...</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
