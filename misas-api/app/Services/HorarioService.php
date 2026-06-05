<?php

namespace App\Services;
use App\Http\Responses\ServiceResponse;

use Illuminate\Support\Facades\DB;

class HorarioService {
    public function getAll()
    {
        $inicio = microtime(true);

        $horarios = DB::table('Horarios')
            ->select('Id', 'LocacionId', 'DiaSemana', 'Hora', 'Activo', 'Notas')
            ->get();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Horarios obtenidos',
            data: $horarios,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function getAllDescriptive()
    {
        $inicio = microtime(true);

        $horarios = DB::table('Horarios as h')
            ->join('Locaciones as l', 'h.LocacionId', '=', 'l.Id')
            ->join('Colonias as c', 'l.ColoniaId', '=', 'c.Id')
            ->join('Ciudades as ci', 'c.CiudadId', '=', 'ci.Id')
            ->select(
                'h.Id',
                'h.LocacionId',
                'l.Nombre as LocacionNombre',
                'ci.Nombre as CiudadNombre',
                'c.Nombre as ColoniaNombre',
                'h.DiaSemana',
                'h.Hora',
                'h.Activo',
                'h.Notas'
            )
            ->get();
        
        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Horarios obtenidos',
            data: $horarios,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function getById(int $id)
    {
        $inicio = microtime(true);

        $horario = DB::table('Horarios')
            ->select('Id', 'LocacionId', 'DiaSemana', 'Hora', 'Activo', 'Notas')
            ->where('Id', $id)
            ->first();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Horario obtenido',
            data: $horario,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function getByDiaSemana(string $diaSemana)
    {
        $inicio = microtime(true);

        $horarios = DB::table('Horarios')
            ->select('Id', 'LocacionId', 'DiaSemana', 'Hora', 'Activo', 'Notas')
            ->where('DiaSemana', $diaSemana)
            ->get();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Horarios obtenidos',
            data: $horarios,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function getByActivo(bool $activo)
    {
        $inicio = microtime(true);

        $horarios = DB::table('Horarios')
            ->select('Id', 'LocacionId', 'DiaSemana', 'Hora', 'Activo', 'Notas')
            ->where('Activo', $activo)
            ->get();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Horarios obtenidos',
            data: $horarios,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function getByHora(string $hora)
    {
        $inicio = microtime(true);

        $horarios = DB::table('Horarios')
            ->select('Id', 'LocacionId', 'DiaSemana', 'Hora', 'Activo', 'Notas')
            ->where('Hora', $hora)
            ->get();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Horarios obtenidos',
            data: $horarios,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function getByLocacionId(int $locacionId)
    {
        $inicio = microtime(true);

        $horarios = DB::table('Horarios')
            ->select('Id', 'LocacionId', 'DiaSemana', 'Hora', 'Activo', 'Notas')
            ->where('LocacionId', $locacionId)
            ->get();

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Horarios obtenidos',
            data: $horarios,
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function findHorarios(?int $ciudadId, ?int $diaSemana, ?string $hora)
    {
        $inicio = microtime(true);

        $query = DB::table('Horarios as h')
            ->join('Locaciones as l', 'h.LocacionId', '=', 'l.Id')
            ->join('Colonias as c', 'l.ColoniaId', '=', 'c.Id')
            ->join('Ciudades as ci', 'c.CiudadId', '=', 'ci.Id')
            ->select('h.Id', 'h.DiaSemana', 'h.Hora', 'h.Notas',
                     'c.Nombre as ColoniaNombre', 'ci.Nombre as CiudadNombre',
                     'l.Nombre as LocacionNombre', 'l.Direccion', 'l.Telefono'
            );

        if ($ciudadId !== null) {
            $query
            ->where('ci.Id', $ciudadId);
        }

        if ($diaSemana !== null) {
            $query
            ->where('h.DiaSemana', $diaSemana);
        }

        if ($hora != null) {
            $query
            ->where('h.Hora', '>=', $hora);
        }
        $horarios = $query
            ->where('h.Activo', true)
            ->orderBy('h.DiaSemana', 'asc')
            ->orderBy('h.Hora', 'asc')
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

        $id = DB::table('Horarios')->insertGetId([
            'LocacionId' => $data['locacionid'],
            'DiaSemana' => $data['diasemana'],
            'Hora' => $data['hora'],
            'Activo' => $data['activo'],
            'Notas' => $data['notas'] ?? null
        ]);

        $fin = microtime(true);

        return new ServiceResponse(
            success: true,
            message: 'Horario creado',
            data: $this->getById($id),
            execution_time_ms: round(($fin - $inicio) * 1000, 2)
        );
    }

    public function update(int $id, array $data)
    {
        $inicio = microtime(true);

        $updated = DB::table('Horarios')
            ->where('Id', $id)
            ->update([
                'LocacionId' => $data['locacionid'],
                'DiaSemana' => $data['diasemana'],
                'Hora' => $data['hora'],
                'Activo' => $data['activo'],
                'Notas' => $data['notas'] ?? null
            ]);

        $fin = microtime(true);

        if ($updated) {
            return new ServiceResponse(
                success: true,
                message: 'Horario actualizado',
                data: $this->getById($id),
                execution_time_ms: round(($fin - $inicio) * 1000, 2)
            );
        } else {
            return new ServiceResponse(
                success: false,
                message: 'Horario no encontrado',
                execution_time_ms: round(($fin - $inicio) * 1000, 2)
            );
        }
    }

    public function delete(int $id)
    {
        $inicio = microtime(true);
        
        $deleted = DB::table('Horarios')
            ->where('Id', $id)
            ->delete();

        $fin = microtime(true);

        if ($deleted) {
            return new ServiceResponse(
                success: true,
                message: 'Horario eliminado',
                execution_time_ms: round(($fin - $inicio) * 1000, 2)
            );
        } else {
            return new ServiceResponse(
                success: false,
                message: 'Horario no encontrado',
                execution_time_ms: round(($fin - $inicio) * 1000, 2)
            );
        }
    }
}