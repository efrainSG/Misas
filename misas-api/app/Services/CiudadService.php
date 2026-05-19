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

    public function create(array $data)
    {
        $ciudadId = DB::table('Ciudades')->insertGetId([
            'Nombre' => $data['nombre'],
        ]);

        return $this->getById($ciudadId);
    }

    public function update(int $id, array $data)
    {
        $exists = DB::table('Ciudades')
            ->where('Id', $id)
            ->exists();

        if (!$exists) {
            return null;
        }

        DB::table('Ciudades')
            ->where('Id', $id)
            ->update(['Nombre' => $data['nombre']]);

            return $this->getById($id);
    }

    public function delete(int $id)
    {
        $allowDelete = DB::table('Colonias')
            ->where('CiudadId', $id)
            ->count() === 0;
        if (!$allowDelete) {
            return response()->json(['message' => 'No se puede eliminar la ciudad porque hay colonias asociadas'], 400);
        }

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