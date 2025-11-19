<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTA DE EQUIPOS
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $equipments = Equipment::orderBy('created_at', 'desc')->paginate(15);
        return view('equipments.index', compact('equipments'));
    }

    /*
    |--------------------------------------------------------------------------
    | FORMULARIO DE CREACIÓN
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('equipments.create');
    }

    /*
    |--------------------------------------------------------------------------
    | GUARDAR EQUIPO
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'sku'           => 'nullable|string|max:100|unique:equipments,sku',
            'description'   => 'nullable|string',
            'price_per_day' => 'required|numeric|min:0',
            'status'        => 'nullable|in:available,rented,maintenance,inactive',
            'location'      => 'nullable|string|max:255',
            'stock'         => 'required|integer|min:0',

            // Imagen
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Asegurar que el status concuerda con el stock
        if ($data['stock'] == 0) {
            $data['status'] = 'rented';
        } else {
            $data['status'] = 'available';
        }

        // Imagen
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('equipments', 'public');
        }

        $data['user_id'] = Auth::id();

        Equipment::create($data);

        return redirect()->route('equipments.index')
            ->with('success', 'Equipo creado correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | MOSTRAR EQUIPO
    |--------------------------------------------------------------------------
    */
    public function show(Equipment $equipment)
    {
        return view('equipments.show', compact('equipment'));
    }

    /*
    |--------------------------------------------------------------------------
    | FORMULARIO DE EDICIÓN
    |--------------------------------------------------------------------------
    */
    public function edit(Equipment $equipment)
    {
        if (!$equipment->isOwnedBy(Auth::user())) {
            abort(403, 'No tienes permiso para editar este equipo.');
        }

        return view('equipments.edit', compact('equipment'));
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR EQUIPO
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Equipment $equipment)
    {
        if (!$equipment->isOwnedBy(Auth::user())) {
            abort(403, 'No tienes permiso para editar este equipo.');
        }

        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'sku'           => 'nullable|string|max:100|unique:equipments,sku,' . $equipment->id,
            'description'   => 'nullable|string',
            'price_per_day' => 'required|numeric|min:0',
            'status'        => 'nullable|in:available,rented,maintenance,inactive',
            'location'      => 'nullable|string|max:255',
            'stock'         => 'required|integer|min:0',

            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Ajustar estatus según stock
        if ($data['stock'] == 0) {
            $data['status'] = 'rented';
        } else {
            if ($equipment->rentals()->where('status', 'active')->exists()) {
                $data['status'] = 'rented';
            } else {
                $data['status'] = 'available';
            }
        }

        // Imagen
        if ($request->hasFile('image')) {

            if ($equipment->image && Storage::disk('public')->exists($equipment->image)) {
                Storage::disk('public')->delete($equipment->image);
            }

            $data['image'] = $request->file('image')->store('equipments', 'public');
        }

        $equipment->update($data);

        return redirect()->route('equipments.index')
            ->with('success', 'Equipo actualizado correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | ELIMINAR EQUIPO
    |--------------------------------------------------------------------------
    */
    public function destroy(Equipment $equipment)
    {
        if (!$equipment->isOwnedBy(Auth::user())) {
            abort(403, 'No tienes permiso para eliminar este equipo.');
        }

        if ($equipment->rentals()->whereIn('status', ['active', 'booked'])->exists()) {
            return back()->with('error', 'No puedes eliminar un equipo que tiene rentas activas.');
        }

        if ($equipment->image && Storage::disk('public')->exists($equipment->image)) {
            Storage::disk('public')->delete($equipment->image);
        }

        $equipment->delete();

        return redirect()->route('equipments.index')
            ->with('success', 'Equipo eliminado correctamente.');
    }
}
