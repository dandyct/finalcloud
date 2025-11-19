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
        // Solo equipos con stock disponible
        $equipments = Equipment::where('stock', '>', 0)->get();

        return view('rentals.create', compact('equipments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'equipment_id' => 'required|exists:equipments,id',
            'customer_name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'notes' => 'nullable|string'
        ]);

        $equipment = Equipment::findOrFail($request->equipment_id);

        // Evitar renta sin stock
        if ($equipment->stock <= 0) {
            return back()->withErrors(['equipment_id' => 'Este equipo no tiene stock disponible.']);
        }

        // Calcular precio por día automáticamente si no lo envían
        $pricePerDay = $equipment->price_per_day;

        // Calcular total si existe fecha fin
        $priceTotal = null;
        if ($request->end_date) {
            $days = (strtotime($request->end_date) - strtotime($request->start_date)) / 86400;
            $days = max(1, $days);
            $priceTotal = $days * $pricePerDay;
        }

        // Crear renta
        $rental = Rental::create([
            'equipment_id' => $equipment->id,
            'customer_name' => $request->customer_name,
            'customer_contact' => $request->customer_contact,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'notes' => $request->notes,
            'price_total' => $priceTotal,
            'status' => 'active'
        ]);

        // -----------------------------------------------------
        // ACTUALIZAR EQUIPO
        // -----------------------------------------------------
        $equipment->stock -= 1;

        if ($equipment->stock === 0) {
            $equipment->status = 'rented';
        }

        $equipment->save();

        return redirect()->route('rentals.index')
            ->with('success', 'Renta creada correctamente.');
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
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_completed' => 'nullable'
        ]);

        $oldEquipment = Equipment::find($rental->equipment_id);
        $newEquipment = Equipment::find($request->equipment_id);

        // Reintegrar stock si se cambia de equipo en la renta
        if ($request->equipment_id != $rental->equipment_id) {
            $oldEquipment->stock += 1;
            if ($oldEquipment->stock > 0) $oldEquipment->status = 'available';
            $oldEquipment->save();

            // Validar stock del nuevo equipo
            if ($newEquipment->stock <= 0) {
                return back()->withErrors(['equipment_id' => 'Este equipo no tiene stock disponible.']);
            }

            $newEquipment->stock -= 1;
            if ($newEquipment->stock === 0) {
                $newEquipment->status = 'rented';
            }
            $newEquipment->save();
        }

        // Actualizar precio total
        $priceTotal = null;
        if ($request->end_date) {
            $days = (strtotime($request->end_date) - strtotime($request->start_date)) / 86400;
            $days = max(1, $days);
            $priceTotal = $days * $newEquipment->price_per_day;
        }

        // Marcar como completada
        $status = $request->has('is_completed') ? 'completed' : 'active';

        $rental->update([
            'equipment_id' => $request->equipment_id,
            'customer_name' => $request->customer_name,
            'customer_contact' => $request->customer_contact,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'notes' => $request->notes,
            'price_total' => $priceTotal,
            'status' => $status
        ]);

        // Si la renta se completó, regresar stock
        if ($status === 'completed') {
            $newEquipment->stock += 1;
            $newEquipment->status = 'available';
            $newEquipment->save();
        }

        return redirect()->route('rentals.index')
            ->with('success', 'Renta actualizada correctamente.');
    }

    public function destroy(Rental $rental)
    {
        // Regresar stock
        $equipment = Equipment::find($rental->equipment_id);

        if ($equipment) {
            $equipment->stock += 1;
            $equipment->status = 'available';
            $equipment->save();
        }

        $rental->delete();

        return redirect()->route('rentals.index')
            ->with('success', 'Renta eliminada correctam    ente.');
    }
}
