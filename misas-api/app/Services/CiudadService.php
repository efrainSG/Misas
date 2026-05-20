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
            return [
                'message' => 'Ciudad no encontrada',
                'success' => false,
                'status' => 404
            ];
        }

        $updated = DB::table('Ciudades')
            ->where('Id', $id)
            ->update(['Nombre' => $data['nombre']]);

        if($updated) {
            return [
                'message' => 'Ciudad actualizada',
                'success' => true,
                'data' => $this->getById($id),
                'status' => 200
            ];
        } else {
            return [
                'message' => 'Ciudad no encontrada',
                'success' => false,
                'status' => 404
            ];
        }
    }

    public function delete(int $id)
    {
        $allowDelete = DB::table('Colonias')
            ->where('CiudadId', $id)
            ->count() === 0;
        if (!$allowDelete) {
            return [
                'message' => 'No se puede eliminar la ciudad porque hay colonias asociadas',
                'success' => false,
                'status' => 400
            ];
        }

        $deleted = DB::table('Ciudades')
            ->where('Id', $id)
            ->delete();

        if ($deleted) {
            return [
                'message' => 'Ciudad eliminada exitosamente',
                'success' => true,
                'status' => 200
            ];
        } else {
            return [
                'message' => 'Ciudad no encontrada',
                'success' => false,
                'status' => 404
            ];
        }
    }
}