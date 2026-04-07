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
            ->where('Nombre', 'like', '%' . $nombre . '%')
            ->get();

        return $ciudad;
    }

    public function createCiudad(array $data)
    {
        $ciudadId = DB::table('Ciudades')->insertGetId([
            'Nombre' => $data['nombre'],
        ]);

        return $this->getById($ciudadId);
    }

    public function updateCiudad(int $id, array $data)
    {
        $updated = DB::table('Ciudades')
            ->where('Id', $id)
            ->update(['Nombre' => $data['nombre']]);

        if ($updated) {
            return $this->getById($id);
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