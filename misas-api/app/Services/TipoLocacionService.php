<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Http\Responses\ServiceResponse;

class TipoLocacionService {
    
    public function getAll()
    {
        $inicio = microtime(true);

        $tiposLocacion = DB::table('TipoLocaciones')
            ->select('Id', 'Nombre', 'Descripcion')
            ->get();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Tipos de locación obtenidos',
            data: $tiposLocacion,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function getById(int $id)
    {
        $inicio = microtime(true);

        $tipoLocacion = DB::table('TipoLocaciones')
            ->select('Id', 'Nombre', 'Descripcion')
            ->where('Id', $id)
            ->first();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Tipo de locación obtenido',
            data: $tipoLocacion,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function getByNombre(string $nombre)
    {
        $inicio = microtime(true);

        $tipoLocacion = DB::table('TipoLocaciones')
            ->select('Id', 'Nombre', 'Descripcion')
            ->where('Nombre', 'like', '%' . $nombre . '%')
            ->get();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Tipo de locación obtenido',
            data: $tipoLocacion,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function create(array $data)
    {
        $inicio = microtime(true);
        
        $exists = DB::table('TipoLocaciones')
            ->where('Nombre', $data['nombre'])
            ->exists();
        
        if ($exists) {
            return new ServiceResponse(
                success: false,
                message: 'Ya existe un tipo de locación con ese nombre',
                status: 400
            );
        }

        $tipoLocacionId = DB::table('TipoLocaciones')->insertGetId([
            'Nombre' => $data['nombre'],
            'Descripcion' => $data['descripcion'] ?? null
        ]);

        $fin = microtime(true);
        return new ServiceResponse(
            success: true,
            message: 'Tipo de locación creado',
            data: $this->getById($tipoLocacionId),
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function update(int $id, array $data)
    {
        $inicio = microtime(true);
        
        $exists = DB::table('TipoLocaciones')
        ->where('Id', $id)
        ->exists();

        if (!$exists) {
            return new ServiceResponse(
                success: false,
                message: 'No se encontró el tipo de locación para actualizar',
                status: 404
            );
        }
        
        DB::table('TipoLocaciones')
        ->where('Id', $id)
        ->update([
            'Nombre' => $data['nombre'],
            'Descripcion' => $data['descripcion'] ?? null
        ]);
        
        $fin = microtime(true);
        return new ServiceResponse(
            success: true,
            message: 'Tipo de locación actualizado',
            data: $this->getById($id),
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function delete(int $id)
    {
        $inicio = microtime(true);
        $allowDelete = DB::table('Locaciones')
            ->where('TipoLocacionId', $id)
            ->count() === 0;
        if (!$allowDelete) {
            return new ServiceResponse(
                success: false,
                message: 'No se puede eliminar el tipo de locación porque hay locaciones asociadas',
                status: 400
            );
        }

        $deleted = DB::table('TipoLocaciones')
            ->where('Id', $id)
            ->delete();

        $fin = microtime(true);
        if ($deleted) {
            return new ServiceResponse(
                success: true,
                message: 'Tipo de locación eliminado',
                status: 200,
                execution_time_ms: round(($fin - $inicio) * 1000, 2)
            );
        } else {
            return new ServiceResponse(
                success: false,
                message: 'Tipo de locación no encontrado',
                status: 404,
                execution_time_ms: round(($fin - $inicio) * 1000, 2)
            );
        }
    }
}
?>