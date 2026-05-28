<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class HorarioService {
    public function getAll()
    {
        $horarios = DB::table('Horarios')
            ->select('Id', 'LocacionId', 'DiaSemana', 'Hora', 'Activo', 'Notas')
            ->get();

        return $horarios;
    }

    public function getAllDescriptive()
    {
        $horarios = DB::table('Horarios as h')
            ->join('Locaciones as l', 'h.LocacionId', '=', 'l.Id')
            ->select(
                'h.Id',
                'h.LocacionId',
                'l.Nombre as LocacionNombre',
                'h.DiaSemana',
                'h.Hora',
                'h.Activo',
                'h.Notas'
            )
            ->get();

        return $horarios;
    }

    public function getById(int $id)
    {
        $horario = DB::table('Horarios')
            ->select('Id', 'LocacionId', 'DiaSemana', 'Hora', 'Activo', 'Notas')
            ->where('Id', $id)
            ->first();

        return $horario;
    }

    public function getByDiaSemana(string $diaSemana)
    {
        $horarios = DB::table('Horarios')
            ->select('Id', 'LocacionId', 'DiaSemana', 'Hora', 'Activo', 'Notas')
            ->where('DiaSemana', $diaSemana)
            ->get();

        return $horarios;
    }

    public function getByActivo(bool $activo)
    {
        $horarios = DB::table('Horarios')
            ->select('Id', 'LocacionId', 'DiaSemana', 'Hora', 'Activo', 'Notas')
            ->where('Activo', $activo)
            ->get();

        return $horarios;
    }

    public function getByHora(string $hora)
    {
        $horarios = DB::table('Horarios')
            ->select('Id', 'LocacionId', 'DiaSemana', 'Hora', 'Activo', 'Notas')
            ->where('Hora', $hora)
            ->get();

        return $horarios;
    }

    public function getByLocacionId(int $locacionId)
    {
        $horarios = DB::table('Horarios')
            ->select('Id', 'LocacionId', 'DiaSemana', 'Hora', 'Activo', 'Notas')
            ->where('LocacionId', $locacionId)
            ->get();

        return $horarios;
    }

    public function findHorarios(?int $ciudadId, ?int $diaSemana, ?string $hora)
    {
        $query = DB::table('Horarios as h')
            ->join('Locaciones as l', 'h.LocacionId', '=', 'l.Id')
            ->join('Colonias as c', 'l.ColoniaId', '=', 'c.Id')
            ->join('Ciudades as ci', 'c.CiudadId', '=', 'ci.Id')
            ->select('h.Id', 'c.Nombre as ColoniaNombre', 'ci.Nombre as CiudadNombre', 'l.Nombre as LocacionNombre', 'h.DiaSemana', 'h.Hora', 'h.Notas');

        if ($ciudadId) {
            $query
            ->where('ci.Id', $ciudadId);
        }

        if ($diaSemana) {
            $query
            ->where('h.DiaSemana', $diaSemana);
        }

        if ($hora) {
            $query
            ->where('h.Hora', '>=', $hora);
        }
        $horarios = $query
            ->where('h.Activo', true)
            ->get();

        return $horarios;
    }
    
    public function create(array $data)
    {
        $id = DB::table('Horarios')->insertGetId([
            'LocacionId' => $data['locacionid'],
            'DiaSemana' => $data['diasemana'],
            'Hora' => $data['hora'],
            'Activo' => $data['activo'],
            'Notas' => $data['notas'] ?? null
        ]);

        return $this->getById($id);
    }

    public function update(int $id, array $data)
    {
        $updated = DB::table('Horarios')
            ->where('Id', $id)
            ->update([
                'LocacionId' => $data['locacionid'],
                'DiaSemana' => $data['diasemana'],
                'Hora' => $data['hora'],
                'Activo' => $data['activo'],
                'Notas' => $data['notas'] ?? null
            ]);

        if ($updated) {
            return [
                'message' => 'Horario actualizado',
                'success' => true,
                'data' => $this->getById($id),
                'status' => 200
            ];
        } else {
            return [
                'message' => 'Horario no encontrado',
                'success' => false,
                'status' => 404
            ];
        }
    }

    public function delete(int $id)
    {
        $deleted = DB::table('Horarios')
            ->where('Id', $id)
            ->delete();

        if ($deleted) {
            return [
                'message' => 'Horario eliminado',
                'success' => true,
                'status' => 200
            ];
        } else {
            return [
                'message' => 'Horario no encontrado',
                'success' => false,
                'status' => 404
            ];
        }
    }
}