<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RepairController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Store method called', $request->all());

        $request->validate([
            'product' => 'required|string',
            'repair_detail' => 'required|string',
            'repair_date' => 'required|date',
            'category' => 'required|string',
        ]);

        $user = auth()->user();
        $clientId = $user->client->id;

        $repair = Repair::create([
            'client_id' => $clientId,
            'product' => $request->product,
            'category' => $request->category,
            'repair_detail' => $request->repair_detail,
            'repair_date' => $request->repair_date,
        ]);

        return view('user.repair.confirmation', compact('repair'))
            ->with('message', '¡Tu hora ha sido agendada correctamente!');
    }

    public function index(Request $request)
    {
        Log::info('Index method called');

        $user = auth()->user();
        $client = $user->client;

        $repairs = Repair::where('client_id', $client->id)
                         ->orderByDesc('repair_date')
                         ->paginate(10);

        return view('user.repair.index', compact('repairs'));
    }

    public function show(Repair $repair)
    {
        Log::info('Show method called', ['repair' => $repair]);

        return view('user.repair.confirmation', compact('repair'));
    }

    public function edit(Repair $repair)
    {
        Log::info('Edit method called', ['repair' => $repair]);


        $repair->repair_date = \Carbon\Carbon::parse($repair->repair_date);

        return view('user.repair.edit', compact('repair'));
    }

    public function update(Request $request, Repair $repair)
    {
        Log::info('Update method called', ['repair' => $repair]);

        $request->validate([
            'product' => 'required|string',
            'repair_detail' => 'required|string',
            'repair_date' => 'required|date',
            'category' => 'required|string',
        ]);

        $repair->update([
            'product' => $request->product,
            'category' => $request->category,
            'repair_detail' => $request->repair_detail,
            'repair_date' => $request->repair_date,
        ]);

        return redirect()->route('repair.index')
            ->with('message', '¡La hora agendada ha sido actualizada correctamente!');
    }

    public function destroy(Repair $repair)
    {
        Log::info('Destroy method called', ['repair' => $repair]);

        $repair->delete();

        return redirect()->route('repair.index')
            ->with('message', 'La hora agendada ha sido cancelada.');
    }
    public function cancel(Repair $repair)
    {
        Log::info('Cancel method called', ['repair' => $repair]);

        $repair->delete();

        return redirect()->route('customer.dashboard')
            ->with('message', 'La hora agendada ha sido cancelada.');
    }

}
