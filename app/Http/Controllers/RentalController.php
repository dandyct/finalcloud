<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{
    public function __construct()
    {
        // Requiere autenticación para todas las acciones
        $this->middleware('auth');
    }

    public function index()
    {
        $rentals = Rental::with('equipment')->orderBy('created_at', 'desc')->paginate(15);
        return view('rentals.index', compact('rentals'));
    }

    public function create()
    {
        // Solo mostrar equipos que tengan stock > 0
        $equipments = Equipment::where('stock', '>', 0)->orderBy('name')->get();
        return view('rentals.create', compact('equipments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'equipment_id' => 'required|exists:equipments,id',
            'customer_name' => 'required|string|max:255',
            'customer_contact' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($data, &$rental) {
            $equipment = Equipment::lockForUpdate()->findOrFail($data['equipment_id']);

            if ($equipment->stock <= 0) {
                abort(422, 'El equipo seleccionado no tiene stock disponible.');
            }

            $days = 1;
            if (!empty($data['end_date'])) {
                $start = \Carbon\Carbon::parse($data['start_date']);
                $end = \Carbon\Carbon::parse($data['end_date']);
                $days = $end->diffInDays($start) + 1;
                if ($days < 1) $days = 1;
            }

            $price_per_day = $equipment->price_per_day ?? 0;
            $price_total = bcmul((string)$price_per_day, (string)$days, 2);

            $rental = Rental::create([
                'equipment_id' => $equipment->id,
                'customer_name' => $data['customer_name'],
                'customer_contact' => $data['customer_contact'] ?? null,
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'] ?? null,
                'price_per_day' => $price_per_day,
                'price_total' => $price_total,
                'status' => 'booked',
                'notes' => $data['notes'] ?? null,
            ]);

            // Ajustar stock y estado del equipo
            $equipment->stock = max(0, $equipment->stock - 1);
            if ($equipment->stock === 0) {
                $equipment->status = 'rented';
            }
            $equipment->save();
        });

        return redirect()->route('rentals.index')->with('success', 'Renta creada correctamente.');
    }

    public function show(Rental $rental)
    {
        $rental->load('equipment');
        return view('rentals.show', compact('rental'));
    }

    public function edit(Rental $rental)
    {
        $equipments = Equipment::orderBy('name')->get();
        return view('rentals.edit', compact('rental', 'equipments'));
    }

    public function update(Request $request, Rental $rental)
    {
        $data = $request->validate([
            'equipment_id' => 'required|exists:equipments,id',
            'customer_name' => 'required|string|max:255',
            'customer_contact' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:booked,active,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($data, $rental) {
            // Si cambias de equipo, ajustar stocks respectivamente
            if ($rental->equipment_id != $data['equipment_id']) {
                $oldEquipment = Equipment::lockForUpdate()->findOrFail($rental->equipment_id);
                $newEquipment = Equipment::lockForUpdate()->findOrFail($data['equipment_id']);

                // devolver stock al viejo equipo
                $oldEquipment->stock = $oldEquipment->stock + 1;
                if ($oldEquipment->stock > 0) $oldEquipment->status = 'available';
                $oldEquipment->save();

                if ($newEquipment->stock <= 0) {
                    abort(422, 'El nuevo equipo seleccionado no tiene stock disponible.');
                }

                // disminuir stock del nuevo equipo
                $newEquipment->stock = max(0, $newEquipment->stock - 1);
                if ($newEquipment->stock === 0) $newEquipment->status = 'rented';
                $newEquipment->save();
            }

            // recalcular price_total si cambian fechas o equipo
            $days = 1;
            if (!empty($data['end_date'])) {
                $start = \Carbon\Carbon::parse($data['start_date']);
                $end = \Carbon\Carbon::parse($data['end_date']);
                $days = $end->diffInDays($start) + 1;
                if ($days < 1) $days = 1;
            }

            $price_per_day = Equipment::findOrFail($data['equipment_id'])->price_per_day ?? 0;
            $price_total = bcmul((string)$price_per_day, (string)$days, 2);

            $rental->update([
                'equipment_id' => $data['equipment_id'],
                'customer_name' => $data['customer_name'],
                'customer_contact' => $data['customer_contact'] ?? null,
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'] ?? null,
                'price_per_day' => $price_per_day,
                'price_total' => $price_total,
                'status' => $data['status'],
                'notes' => $data['notes'] ?? null,
            ]);

            // Si se marca completed o cancelled, ajustar stock y estado
            if (in_array($data['status'], ['completed','cancelled'])) {
                $equipment = Equipment::lockForUpdate()->findOrFail($rental->equipment_id);
                $equipment->stock = $equipment->stock + 1;
                if ($equipment->stock > 0) $equipment->status = 'available';
                $equipment->save();
            }
        });

        return redirect()->route('rentals.index')->with('success', 'Renta actualizada correctamente.');
    }

    public function destroy(Rental $rental)
    {
        DB::transaction(function () use ($rental) {
            $equipment = Equipment::lockForUpdate()->find($rental->equipment_id);
            if ($equipment) {
                $equipment->stock = $equipment->stock + 1;
                if ($equipment->stock > 0) $equipment->status = 'available';
                $equipment->save();
            }
            $rental->delete();
        });

        return redirect()->route('rentals.index')->with('success', 'Renta eliminada correctamente.');
    }
}