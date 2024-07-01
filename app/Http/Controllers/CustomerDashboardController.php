<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $client = $user->client;

        if ($client) {
            // Si el usuario tiene un cliente asociado, mostrar los datos
            return view('user.dashboard', ['client' => $client]);
        } else {
            // Si el usuario no tiene un cliente asociado, mostrar el formulario
            return view('clients.create');
        }
    }
}
