<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function create()
    {
        return view('clients.create');
    }

    public function edit()
    {
        $client = auth()->user()->client;
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        if ($user->client) {
            $client = $user->client;
            $client->update([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'phone' => $request->input('phone'),
            ]);
        } else {
            // En caso de que no exista, crear el cliente
            $client = Client::create([
                'user_id' => $user->id,
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'phone' => $request->input('phone'),
            ]);
        }

        return redirect()->route('customer.dashboard');
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        // Crear el cliente asociado al usuario actual
        $client = Client::create([
            'user_id' => $user->id,
            'name' => $validatedData['name'],
            'address' => $validatedData['address'],
            'city' => $validatedData['city'],
            'phone' => $validatedData['phone'],
        ]);

        // Redirigir de vuelta al dashboard del cliente
        return redirect()->route('customer.dashboard');
    }
}
