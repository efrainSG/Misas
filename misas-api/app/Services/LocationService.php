<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Http\Responses\ServiceResponse;

class LocationService {

    public function getAll()
    {
        $inicio = microtime(true);

        $locaciones = DB::table('Locaciones')
            ->select('Id', 'Nombre', 'Direccion', 'ColoniaId', 'Telefono', 'TipoLocacionId')
            ->get();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Locaciones obtenidas',
            data: $locaciones,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function getAllDescriptive()
    {
        $inicio = microtime(true);

        $locaciones = DB::table('Locaciones as L')
            ->join('Colonias as C', 'C.Id', '=', 'L.ColoniaId')
            ->join('TipoLocaciones as T', 'T.Id', '=', 'L.TipoLocacionId')
            ->select('L.Id', 'L.Nombre', 'L.Direccion', 'C.Nombre as ColoniaNombre', 'L.Telefono', 'T.Nombre as TipoLocacionNombre')
            ->get();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Locaciones obtenidas',
            data: $locaciones,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function getById(int $id)
    {
        $inicio = microtime(true);

        $locacion = DB::table('Locaciones')
            ->select('Id', 'Nombre', 'Direccion', 'ColoniaId', 'Telefono', 'TipoLocacionId')
            ->where('Id', $id)
            ->first();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Locación obtenida',
            data: $locacion,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function getByTipoLocacionId(int $tipoLocacionId)
    {
        $inicio = microtime(true);

        $locaciones = DB::table('Locaciones')
            ->select('Id', 'Nombre', 'Direccion', 'ColoniaId', 'Telefono', 'TipoLocacionId')
            ->where('TipoLocacionId', $tipoLocacionId)
            ->get();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Locaciones obtenidas',
            data: $locaciones,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function getByColoniaId(int $coloniaId)
    {
        $inicio = microtime(true);

        $locaciones = DB::table('Locaciones')
            ->select('Id', 'Nombre', 'Direccion', 'ColoniaId', 'Telefono', 'TipoLocacionId')
            ->where('ColoniaId', $coloniaId)
            ->get();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Locaciones obtenidas',
            data: $locaciones,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function getByNombre(string $nombre)
    {
        $inicio = microtime(true);

        $locaciones = DB::table('Locaciones')
            ->select('Id', 'Nombre', 'Direccion', 'ColoniaId', 'Telefono', 'TipoLocacionId')
            ->where('Nombre', 'like', '%' . $nombre . '%')
            ->get();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Locaciones obtenidas',
            data: $locaciones,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function getByTipoAndColonia(int $tipoLocacionId, int $coloniaId)
    {
        $inicio = microtime(true);

        $locaciones = DB::table('Locaciones')
            ->select('Id', 'Nombre', 'Direccion', 'ColoniaId', 'Telefono', 'TipoLocacionId')
            ->where('TipoLocacionId', $tipoLocacionId)
            ->where('ColoniaId', $coloniaId)
            ->get();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Locaciones obtenidas',
            data: $locaciones,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }
    
    public function getHorariosByLocacionId(int $locacionId)
    {
        $inicio = microtime(true);

        $horarios = DB::table('Horarios as h')
            ->join('Locaciones as l', 'l.Id', '=', 'h.LocacionId')
            ->select('l.Id as LocacionId',
                     'l.Nombre as LocacionNombre',
                     'h.DiaSemana',
                     'h.Hora',
                     'h.Notas')
            ->where('h.LocacionId', $locacionId)
            ->where('h.Activo', true)
            ->orderBy('h.DiaSemana')
            ->orderBy('h.Hora')
            ->get();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Horarios obtenidos',
            data: $horarios,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function create(array $data)
    {
        $inicio = microtime(true);
        
        $exists = DB::table('Locaciones')
            ->where('Nombre', $data['nombre'])
            ->exists();
        
        if ($exists) {
            return new ServiceResponse(
                success: false,
                message: 'Ya existe una locación con ese nombre',
                status: 400
            );
        }
        
        $id = DB::table('Locaciones')->insertGetId([
            'Nombre' => $data['nombre'],
            'Direccion' => $data['direccion'],
            'ColoniaId' => $data['coloniaid'],
            'Telefono' => $data['telefono'] ?? null,
            'TipoLocacionId' => $data['tipolocacionid']
        ]);

        $inserted = $this->getById($id);

        $fin = microtime(true);
        return new ServiceResponse(
            success: true,
            message: 'Locación creada',
            data: $inserted->data,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function update(int $id, array $data)
    {
        $exists = DB::table('TipoLocaciones')
        ->where('Id', $id)
        ->exists();

        if (!$exists) {
            return new ServiceResponse(
                success: false,
                message: 'Locación no encontrada',
                status: 404
            );
        }
        
        DB::table('Locaciones')
            ->where('Id', $id)
            ->update([
                'Nombre' => $data['nombre'],
                'Direccion' => $data['direccion'],
                'ColoniaId' => $data['coloniaid'],
                'Telefono' => $data['telefono'] ?? null,
                'TipoLocacionId' => $data['tipolocacionid']
            ]);
        
        return new ServiceResponse(
            success: true,
            message: 'Locación actualizada',
            data: $this->getById($id),
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function delete(int $id)
    {
        $inicio = microtime(true);

        $allowDelete = DB::table('Horarios')
            ->where('LocacionId', $id)
            ->count() === 0;
        if (!$allowDelete) {
            return new ServiceResponse(
                success: false,
                message: 'No se puede eliminar la locación porque hay horarios asociados',
                status: 400
            );
        }

        $deleted = DB::table('Locaciones')
            ->where('Id', $id)
            ->delete();

        $fin = microtime(true);

        if ($deleted) {
            return new ServiceResponse(
                success: true,
                message: 'Locación eliminada',
                status: 200,
                execution_time_ms: round(($fin - $inicio) * 1000, 2)
            );
        } else {
            return new ServiceResponse(
                success: false,
                message: 'Locación no encontrada',
                status: 404
            );
        }
    }
}