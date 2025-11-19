<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Equipment;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with('equipment')->latest()->paginate(10);
        return view('rentals.index', compact('rentals'));
    }

    public function create()
    {
        $equipments = Equipment::all();
        return view('rentals.create', compact('equipments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'equipment_id' => 'required|exists:equipments,id',
            'customer_name' => 'required|string',
            'start_date' => 'required|date',
            'price_per_day' => 'nullable|numeric',
        ]);

        $data = $request->all();

        // Calcula total si existe fecha fin
        if ($request->end_date) {
            $days = (strtotime($request->end_date) - strtotime($request->start_date)) / 86400;
            $data['price_total'] = $days * $request->price_per_day;
        }

        Rental::create($data);

        return redirect()->route('rentals.index')->with('success', 'Renta creada correctamente.');
    }

    public function show(Rental $rental)
    {
        $rental->load('equipment');
        return view('rentals.show', compact('rental'));
    }

    public function edit(Rental $rental)
    {
        $equipments = Equipment::all();
        return view('rentals.edit', compact('rental', 'equipments'));
    }

    public function update(Request $request, Rental $rental)
    {
        $request->validate([
            'equipment_id' => 'required|exists:equipments,id',
            'customer_name' => 'required|string',
            'start_date' => 'required|date',
            'price_per_day' => 'nullable|numeric',
        ]);

        $data = $request->all();

        if ($request->end_date) {
            $days = (strtotime($request->end_date) - strtotime($request->start_date)) / 86400;
            $data['price_total'] = $days * $request->price_per_day;
        }

        $rental->update($data);

        return redirect()->route('rentals.index')->with('success', 'Renta actualizada.');
    }

    public function destroy(Rental $rental)
    {
        $rental->delete();
        return redirect()->route('rentals.index')->with('success', 'Renta eliminada.');
    }
}
