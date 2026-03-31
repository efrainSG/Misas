<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ColoniaService
{

    public function getAll()
    {
        $colonias = DB::table('Colonias')
            ->select('Id', 'Nombre')
            ->get();

        return $colonias;
    }

    public function getById(int $id)
    {
        $colonia = DB::table('Colonias')
            ->select('Id', 'Nombre')
            ->where('Id', $id)
            ->first();

        return $colonia;
    }

    public function getByNombre(string $nombre)
    {
        $colonia = DB::table('Colonias')
            ->select('Id', 'Nombre')
            ->where('Nombre', $nombre)
            ->first();

        return $colonia;
    }

    public function getByCiudadId(int $ciudadId)
    {
        $colonias = DB::table('Colonias')
            ->select('Id', 'Nombre')
            ->where('CiudadId', $ciudadId)
            ->get();

        return $colonias;
    }

    public function createColonia(Request $request)
    {
        $validatedData = $request->validate([
            'Nombre' => 'required|string|max:255',
            'CiudadId' => 'required|integer',
        ]);

        $coloniaId = DB::table('Colonias')->insertGetId([
            'Nombre' => $validatedData['Nombre'],
            'CiudadId' => $validatedData['CiudadId'],
        ]);

        return $this->getById($coloniaId);
    }

    public function updateColonia(int $id, Request $request)
    {
        $validatedData = $request->validate([
            'Nombre' => 'sometimes|required|string|max:255',
            'CiudadId' => 'sometimes|required|integer',
        ]);

        $updateData = [];
        if (isset($validatedData['Nombre'])) {
            $updateData['Nombre'] = $validatedData['Nombre'];
        }
        if (isset($validatedData['CiudadId'])) {
            $updateData['CiudadId'] = $validatedData['CiudadId'];
        }

        if (empty($updateData)) {
            return response()->json(['message' => 'No se proporcionaron datos para actualizar'], 400);
        }

        $updated = DB::table('Colonias')
            ->where('Id', $id)
            ->update($updateData);

        if ($updated) {
            return response()->json(['message' => 'Colonia actualizada']);
        } else {
            return response()->json(['message' => 'Colonia no encontrada o sin cambios'], 404);
        }
    }

    public function deleteColonia(int $id)
    {
        $deleted = DB::table('Colonias')
            ->where('Id', $id)
            ->delete();

        if ($deleted) {
            return response()->json(['message' => 'Colonia eliminada']);
        } else {
            return response()->json(['message' => 'Colonia no encontrada'], 404);
        }
    }
}