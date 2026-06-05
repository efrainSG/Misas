<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Http\Responses\ServiceResponse;

class CiudadService {

    public function getAll()
    {
        $inicio = microtime(true);

        $ciudades = DB::table('Ciudades')
            ->select('Id', 'Nombre')
            ->get();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Ciudades obtenidas',
            data: $ciudades,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function getById(int $id)
    {
        $inicio = microtime(true);
    
        $ciudad = DB::table('Ciudades')
            ->select('Id', 'Nombre')
            ->where('Id', $id)
            ->first();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Ciudad obtenida',
            data: $ciudad,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function getByNombre(string $nombre)
    {
        $inicio = microtime(true);
        
        $ciudad = DB::table('Ciudades')
            ->select('Id', 'Nombre')
            ->where('Nombre', 'like', '%' . $nombre . '%')
            ->get();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Ciudades obtenidas',
            data: $ciudad,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function create(array $data)
    {
        $inicio = microtime(true);

        $ciudadId = DB::table('Ciudades')->insertGetId([
            'Nombre' => $data['nombre'],
        ]);
    
        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Ciudad creada',
            data: $this->getById($ciudadId),
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function update(int $id, array $data)
    {
        $inicio = microtime(true);

        $exists = DB::table('Ciudades')
            ->where('Id', $id)
            ->exists();

        if (!$exists) {
            $fin = microtime(true);
            return new ServiceResponse(
                success: false,
                message: 'Ciudad no encontrada',
                status: 404,
                execution_time_ms: round(($fin - $inicio) * 1000, 2)
            );
        }

        $updated = DB::table('Ciudades')
            ->where('Id', $id)
            ->update(['Nombre' => $data['nombre']]);

        if($updated) {
            $fin = microtime(true);
            return new ServiceResponse(
                success: true,
                message: 'Ciudad actualizada',
                data: $this->getById($id),
                status: 200,
                execution_time_ms: round(($fin - $inicio) * 1000, 2)
            );
        }

        $updated = DB::table('Ciudades')
            ->where('Id', $id)
            ->update(['Nombre' => $data['nombre']]);

        if($updated) {
            $fin = microtime(true); 
            return new ServiceResponse(
                success: true,
                message: 'Ciudad actualizada',
                data: $this->getById($id),
                status: 200,
                execution_time_ms: round(($fin - $inicio) * 1000, 2)
            );
        } else {
            $fin = microtime(true);
            return new ServiceResponse(
                success: false,
                message: 'Ciudad no encontrada',
                status: 404,
                execution_time_ms: round(($fin - $inicio) * 1000, 2)
            );
        }
    }

    public function delete(int $id)
    {
        $inicio = microtime(true);

        $allowDelete = DB::table('Colonias')
            ->where('CiudadId', $id)
            ->count() === 0;
        if (!$allowDelete) {
            $fin = microtime(true);
            return new ServiceResponse(
                success: false,
                message: 'No se puede eliminar la ciudad porque hay colonias asociadas',
                status: 400,
                execution_time_ms: round(($fin - $inicio) * 1000, 2)
            );
        }

        $deleted = DB::table('Ciudades')
            ->where('Id', $id)
            ->delete();

        if ($deleted) {
            $fin = microtime(true);
            return new ServiceResponse(
                success: true,
                message: 'Ciudad eliminada exitosamente',
                status: 200,
                execution_time_ms: round(($fin - $inicio) * 1000, 2)
            );
        } else {
            $fin = microtime(true);
            return new ServiceResponse(
                success: false,
                message: 'Ciudad no encontrada',
                status: 404,
                execution_time_ms: round(($fin - $inicio) * 1000, 2)
            );
        }
    }
}