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

    public function getAllDescriptive()
    {
        $colonias = DB::table('Colonias as C')
            ->join('Ciudades as Ci', 'Ci.Id', '=', 'C.CiudadId')
            ->select('C.Id', 'C.Nombre', 'C.CiudadId', 'Ci.Nombre as CiudadNombre')
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

    public function create(array $data)
    {
            $coloniaId = DB::table('Colonias')->insertGetId([
            'Nombre' => $data['nombre'],
            'CiudadId' => $data['ciudadid'],
        ]);

        return $this->getById($coloniaId);
    }

    public function update(int $id, array $data)
    {
        $updateData = [];
        if (isset($data['nombre'])) {
            $updateData['Nombre'] = $data['nombre'];
        }
        if (isset($data['ciudadid'])) {
            $updateData['CiudadId'] = $data['ciudadid'];
        }

        if (empty($updateData)) {
            return [
                'message' => 'No se proporcionaron datos para actualizar',
                'success' => false,
                'status' => 400
            ];
        }

        $updated = DB::table('Colonias')
            ->where('Id', $id)
            ->update($updateData);

        if ($updated) {
            return [
                'message' => 'Colonia actualizada',
                'success' => true,
                'data' => $this->getById($id),
                'status' => 200
            ];
        } else {
            return [
                'message' => 'Colonia no encontrada o sin cambios',
                'success' => false,
                'status' => 404
            ]   ;
        }
    }

    public function delete(int $id)
    {
        $deleted = DB::table('Colonias')
            ->where('Id', $id)
            ->delete();

        if ($deleted) {
            return [
                'message' => 'Colonia eliminada',
                'success' => true,
                'status' => 200
            ];
        } else {
            return [
                'message' => 'Colonia no encontrada',
                'success' => false,
                'status' => 404
            ];
        }
    }
}