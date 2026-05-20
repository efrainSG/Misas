<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;

class LocationService {

    public function getAll()
    {
        $locaciones = DB::table('Locaciones')
            ->select('Id', 'Nombre', 'Direccion', 'ColoniaId', 'Telefono', 'TipoLocacionId')
            ->get();

        return $locaciones;
    }

    public function getAllDescriptive()
    {
        $locaciones = DB::table('Locaciones as L')
            ->join('Colonias as C', 'C.Id', '=', 'L.ColoniaId')
            ->join('TipoLocaciones as T', 'T.Id', '=', 'L.TipoLocacionId')
            ->select('L.Id', 'L.Nombre', 'L.Direccion', 'C.Nombre as ColoniaNombre', 'L.Telefono', 'T.Nombre as TipoLocacionNombre')
            ->get();

        return $locaciones;
    }

    public function getById(int $id)
    {
        $locacion = DB::table('Locaciones')
            ->select('Id', 'Nombre', 'Direccion', 'ColoniaId', 'Telefono', 'TipoLocacionId')
            ->where('Id', $id)
            ->first();

        return $locacion;
    }

    public function getByTipoLocacionId(int $tipoLocacionId)
    {
        $locaciones = DB::table('Locaciones')
            ->select('Id', 'Nombre', 'Direccion', 'ColoniaId', 'Telefono', 'TipoLocacionId')
            ->where('TipoLocacionId', $tipoLocacionId)
            ->get();

        return $locaciones;
    }

    public function getByColoniaId(int $coloniaId)
    {
        $locaciones = DB::table('Locaciones')
            ->select('Id', 'Nombre', 'Direccion', 'ColoniaId', 'Telefono', 'TipoLocacionId')
            ->where('ColoniaId', $coloniaId)
            ->get();

        return $locaciones;
    }

    public function getByNombre(string $nombre)
    {
        $locaciones = DB::table('Locaciones')
            ->select('Id', 'Nombre', 'Direccion', 'ColoniaId', 'Telefono', 'TipoLocacionId')
            ->where('Nombre', 'like', '%' . $nombre . '%')
            ->get();

        return $locaciones;
    }

    public function getByTipoAndColonia(int $tipoLocacionId, int $coloniaId)
    {
        $locaciones = DB::table('Locaciones')
            ->select('Id', 'Nombre', 'Direccion', 'ColoniaId', 'Telefono', 'TipoLocacionId')
            ->where('TipoLocacionId', $tipoLocacionId)
            ->where('ColoniaId', $coloniaId)
            ->get();

        return $locaciones;
    }
    
    public function getHorariosByLocacionId(int $locacionId)
    {
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

        return $horarios;
    }

    public function create(array $data)
    {
        $exists = DB::table('Locaciones')
            ->where('Nombre', $data['nombre'])
            ->exists();
        
        if ($exists) {
            return [
                'message' => 'Ya existe una locación con ese nombre',
                'success' => false,
                'status' => 400
            ];
        }
        
        $id = DB::table('Locaciones')->insertGetId([
            'Nombre' => $data['nombre'],
            'Direccion' => $data['direccion'],
            'ColoniaId' => $data['coloniaid'],
            'Telefono' => $data['telefono'] ?? null,
            'TipoLocacionId' => $data['tipolocacionid']
        ]);

        return $this->getById($id);
    }

    public function update(int $id, array $data)
    {
        $exists = DB::table('TipoLocaciones')
        ->where('Id', $id)
        ->exists();

        if (!$exists) {
            return [
                'message' => 'Locación no encontrada',
                'success' => false,
                'status' => 404
            ];
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
        
        return [
            'message' => 'Locación actualizada',
            'success' => true,
            'data' => $this->getById($id),
            'status' => 200
        ];
    }

    public function delete(int $id)
    {
        $allowDelete = DB::table('Horarios')
            ->where('LocacionId', $id)
            ->count() === 0;
        if (!$allowDelete) {
            return [
                'message' => 'No se puede eliminar la locación porque hay horarios asociados',
                'success' => false,
                'status' => 400
            ];
        }

        $deleted = DB::table('Locaciones')
            ->where('Id', $id)
            ->delete();

        if ($deleted) {
            return [
                'message' => 'Locación eliminada',
                'success' => true,
                'status' => 200
            ];
        } else {
            return [
                'message' => 'Locación no encontrada',
                'success' => false,
                'status' => 404
            ];
        }
    }
}