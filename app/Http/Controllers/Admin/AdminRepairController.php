<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Repair;
use Illuminate\Http\Request;

class AdminRepairController extends Controller
{
    public function index(Request $request)
    {
        $query = Repair::query();

        if ($request->has('filter_status')) {
            if ($request->filter_status == 'accepted') {
                $query->where('repair_accepted', true);
            } elseif ($request->filter_status == 'not_accepted') {
                $query->where('repair_accepted', false);
            }
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('repair_date', [$request->start_date, $request->end_date]);
        }

        $repairs = $query->orderByDesc('repair_date')->paginate(10);

        return view('admin.repair.index', compact('repairs'));
    }

    public function update(Request $request, Repair $repair)
    {
        $repair->update($request->only(['repair_accepted']));

        return redirect()->route('repairs.index')->with('message', 'Estado de la hora agendada actualizado.');
    }

    public function destroy(Repair $repair)
    {
        $repair->delete();

        return redirect()->route('repairs.index')->with('message', 'La hora agendada ha sido cancelada.');
    }
}

