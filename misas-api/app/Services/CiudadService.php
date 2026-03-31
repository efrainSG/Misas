<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class CiudadService {
        public function getAll()
    {
        $ciudades = DB::table('Ciudades')
            ->select('Id', 'Nombre')
            ->get();

        return $ciudades;
    }

    public function getById(int $id)
    {
        $ciudad = DB::table('Ciudades')
            ->select('Id', 'Nombre')
            ->where('Id', $id)
            ->first();

        return $ciudad;
    }

    public function getByNombre(string $nombre)
    {
        $ciudad = DB::table('Ciudades')
            ->select('Id', 'Nombre')
            ->where('Nombre', $nombre)
            ->first();

        return $ciudad;
    }

    public function createCiudad(Request $request)
    {
        $validatedData = $request->validate([
            'Nombre' => 'required|string|max:255',
        ]);

        $ciudadId = DB::table('Ciudades')->insertGetId([
            'Nombre' => $validatedData['Nombre'],
        ]);

        return response()->json(['message' => 'Ciudad creada exitosamente', 'Id' => $ciudadId], 201);
    }

    public function updateCiudad(int $id, Request $request)
    {
        $validatedData = $request->validate([
            'Nombre' => 'required|string|max:255',
        ]);

        $updated = DB::table('Ciudades')
            ->where('Id', $id)
            ->update(['Nombre' => $validatedData['Nombre']]);

        if ($updated) {
            return response()->json(['message' => 'Ciudad actualizada exitosamente']);
        } else {
            return response()->json(['message' => 'Ciudad no encontrada'], 404);
        }
    }

    public function deleteCiudad(int $id)
    {
        $deleted = DB::table('Ciudades')
            ->where('Id', $id)
            ->delete();

        if ($deleted) {
            return response()->json(['message' => 'Ciudad eliminada exitosamente']);
        } else {
            return response()->json(['message' => 'Ciudad no encontrada'], 404);
        }
    }
}