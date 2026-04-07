<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ColoniaService
{

    public function getAll()
    {
        $colonias = DB::table('Colonias')
            ->select('Id', 'Nombre', 'CiudadId')
            ->get();

        return $colonias;
    }

    public function getById(int $id)
    {
        $colonia = DB::table('Colonias')
            ->select('Id', 'Nombre', 'CiudadId')
            ->where('Id', $id)
            ->first();

        return $colonia;
    }

    public function getByNombre(string $nombre)
    {
        $colonia = DB::table('Colonias')
            ->select('Id', 'Nombre', 'CiudadId')
            ->where('Nombre', 'like', '%' . $nombre . '%')
            ->first();

        return $colonia;
    }

    public function getByCiudadId(int $ciudadId)
    {
        $colonias = DB::table('Colonias')
            ->select('Id', 'Nombre', 'CiudadId')
            ->where('CiudadId', $ciudadId)
            ->get();

        return $colonias;
    }

    public function createColonia(array $data)
    {
            $coloniaId = DB::table('Colonias')->insertGetId([
            'Nombre' => $data['nombre'],
            'CiudadId' => $data['ciudadId'],
        ]);

        return $this->getById($coloniaId);
    }

    public function updateColonia(int $id, array $data)
    {
        $updateData = [];
        if (isset($data['nombre'])) {
            $updateData['Nombre'] = $data['nombre'];
        }
        if (isset($data['ciudadId'])) {
            $updateData['CiudadId'] = $data['ciudadId'];
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