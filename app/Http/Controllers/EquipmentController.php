<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::orderBy('created_at', 'desc')->paginate(15);
        return view('equipments.index', compact('equipments'));
    }

    public function create()
    {
        return view('equipments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100|unique:equipments,sku',
            'description' => 'nullable|string',
            'price_per_day' => 'required|numeric|min:0',
            'status' => 'required|in:available,rented,maintenance,inactive',
            'location' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',

            // 🟦 Validación de imagen
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 🟦 Guardar imagen si viene en el request
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('equipments', 'public');
        }

        Equipment::create($data);

        return redirect()->route('equipments.index')->with('success', 'Equipo creado correctamente.');
    }

    public function show(Equipment $equipment)
    {
        return view('equipments.show', compact('equipment'));
    }

    public function edit(Equipment $equipment)
    {
        return view('equipments.edit', compact('equipment'));
    }

    public function update(Request $request, Equipment $equipment)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100|unique:equipments,sku,' . $equipment->id,
            'description' => 'nullable|string',
            'price_per_day' => 'required|numeric|min:0',
            'status' => 'required|in:available,rented,maintenance,inactive',
            'location' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',

            // 🟦 Validación de imagen (opcional)
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 🟦 Si sube nueva imagen, eliminar la anterior
        if ($request->hasFile('image')) {
            if ($equipment->image && Storage::disk('public')->exists($equipment->image)) {
                Storage::disk('public')->delete($equipment->image);
            }

            $data['image'] = $request->file('image')->store('equipments', 'public');
        }

        $equipment->update($data);

        return redirect()->route('equipments.index')->with('success', 'Equipo actualizado correctamente.');
    }

    public function destroy(Equipment $equipment)
    {
        // 🟦 Borrar imagen cuando se elimina el registro
        if ($equipment->image && Storage::disk('public')->exists($equipment->image)) {
            Storage::disk('public')->delete($equipment->image);
        }

        $equipment->delete();

        return redirect()->route('equipments.index')->with('success', 'Equipo eliminado correctamente.');
    }
}
