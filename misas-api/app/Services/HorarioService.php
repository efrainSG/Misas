<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class HorarioService {
        public function getAll()
    {
        $horarios = DB::table('Horarios')
            ->select('Id', 'DiaSemana', 'Hora', 'Activo', 'Notas')
            ->get();

        return $horarios;
    }

    public function getById(int $id)
    {
        $horario = DB::table('Horarios')
            ->select('Id', 'DiaSemana', 'Hora', 'Activo', 'Notas')
            ->where('Id', $id)
            ->first();

        return $horario;
    }

    public function getByDiaSemana(string $diaSemana)
    {
        $horarios = DB::table('Horarios')
            ->select('Id', 'DiaSemana', 'Hora', 'Activo', 'Notas')
            ->where('DiaSemana', $diaSemana)
            ->get();

        return $horarios;
    }

    public function getByActivo(bool $activo)
    {
        $horarios = DB::table('Horarios')
            ->select('Id', 'DiaSemana', 'Hora', 'Activo', 'Notas')
            ->where('Activo', $activo)
            ->get();

        return $horarios;
    }

    public function getByHora(string $hora)
    {
        $horarios = DB::table('Horarios')
            ->select('Id', 'DiaSemana', 'Hora', 'Activo', 'Notas')
            ->where('Hora', $hora)
            ->get();

        return $horarios;
    }

    public function getByLocacionId(int $locacionId)
    {
        $horarios = DB::table('Horarios')
            ->select('Id', 'DiaSemana', 'Hora', 'Activo', 'Notas')
            ->where('LocacionId', $locacionId)
            ->get();

        return $horarios;
    }

    public function createHorario(array $data)
    {
        $id = DB::table('Horarios')->insertGetId([
            'LocacionId' => $data['LocacionId'],
            'DiaSemana' => $data['DiaSemana'],
            'Hora' => $data['Hora'],
            'Activo' => $data['Activo'],
            'Notas' => $data['Notas'] ?? null
        ]);

        return $this->getById($id);
    }

    public function updateHorario(int $id, array $data)
    {
        $updated = DB::table('Horarios')
            ->where('Id', $id)
            ->update([
                'LocacionId' => $data['LocacionId'],
                'DiaSemana' => $data['DiaSemana'],
                'Hora' => $data['Hora'],
                'Activo' => $data['Activo'],
                'Notas' => $data['Notas'] ?? null
            ]);

        if ($updated) {
            return response()->json(['message' => 'Horario actualizado']);
        } else {
            return response()->json(['message' => 'Horario no encontrado'], 404);
        }
    }

    public function deleteHorario(int $id)
    {
        $deleted = DB::table('Horarios')
            ->where('Id', $id)
            ->delete();

        if ($deleted) {
            return response()->json(['message' => 'Horario eliminado']);
        } else {
            return response()->json(['message' => 'Horario no encontrado'], 404);
        }
    }
}