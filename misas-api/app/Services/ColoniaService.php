<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Http\Responses\ServiceResponse;

class ColoniaService
{

    public function getAll()
    {
        $inicio = microtime(true);

        $colonias = DB::table('Colonias')
            ->select('Id', 'Nombre', 'CiudadId')
            ->get();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Colonias obtenidas',
            data: $colonias,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function getAllDescriptive()
    {
        $inicio = microtime(true);

        $colonias = DB::table('Colonias as C')
            ->join('Ciudades as Ci', 'Ci.Id', '=', 'C.CiudadId')
            ->select('C.Id', 'C.Nombre', 'C.CiudadId', 'Ci.Nombre as CiudadNombre')
            ->get();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Colonias obtenidas',
            data: $colonias,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }
    
    public function getById(int $id)
    {
        $inicio = microtime(true);

        $colonia = DB::table('Colonias')
            ->select('Id', 'Nombre', 'CiudadId')
            ->where('Id', $id)
            ->first();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Colonia obtenida',
            data: $colonia,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function getByNombre(string $nombre)
    {
        $inicio = microtime(true);

        $colonia = DB::table('Colonias')
            ->select('Id', 'Nombre', 'CiudadId')
            ->where('Nombre', 'like', '%' . $nombre . '%')
            ->first();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Colonia obtenida',
            data: $colonia,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function getByCiudadId(int $ciudadId)
    {
        $inicio = microtime(true);

        $colonias = DB::table('Colonias')
            ->select('Id', 'Nombre', 'CiudadId')
            ->where('CiudadId', $ciudadId)
            ->get();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Colonias obtenidas',
            data: $colonias,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function create(array $data)
    {
        $inicio = microtime(true);

        $coloniaId = DB::table('Colonias')->insertGetId([
            'Nombre' => $data['nombre'],
            'CiudadId' => $data['ciudadid'],
        ]);

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Colonia creada',
            data: $this->getById($coloniaId),
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function update(int $id, array $data)
    {
        $inicio = microtime(true);

        $updateData = [];
        if (isset($data['nombre'])) {
            $updateData['Nombre'] = $data['nombre'];
        }
        if (isset($data['ciudadid'])) {
            $updateData['CiudadId'] = $data['ciudadid'];
        }

        if (empty($updateData)) {
            $fin = microtime(true);

            return  new ServiceResponse(
                success: false,
                message: 'No se proporcionaron datos para actualizar',
                status: 400,
                execution_time_ms: round(($fin - $inicio) * 1000, 2)
            );
        }

        $updated = DB::table('Colonias')
            ->where('Id', $id)
            ->update($updateData);

        $fin = microtime(true);

        if ($updated) {
            return new ServiceResponse(
                success: true,
                message: 'Colonia actualizada',
                data: $this->getById($id),
                status: 200,
                execution_time_ms: round(($fin - $inicio) * 1000, 2)
            );
        } else {
            return new ServiceResponse(
                success: false,
                message: 'Colonia no encontrada o sin cambios',
                status: 404,
                execution_time_ms: round(($fin - $inicio) * 1000, 2)
            );
        }
    }

    public function delete(int $id)
    {
        $inicio = microtime(true);
        
        $deleted = DB::table('Colonias')
            ->where('Id', $id)
            ->delete();

        $fin = microtime(true);

        if ($deleted) {
            return new ServiceResponse(
                success: true,
                message: 'Colonia eliminada',
                status: 200,
                execution_time_ms: round(($fin - $inicio) * 1000, 2)
            );
        } else {
            return new ServiceResponse(
                success: false,
                message: 'Colonia no encontrada',
                status: 404,
                execution_time_ms: round(($fin - $inicio) * 1000, 2)
            );
        }
    }
}