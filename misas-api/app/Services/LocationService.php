<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;

class LocationService {
        public function getAll()
    {
        $locaciones = DB::table('Locaciones')
            ->select('Id', 'Nombre', 'Direccion')
            ->get();

        return response()->json($locaciones);
    }

    public function getById(int $id)
    {
        $locacion = DB::table('Locaciones')
            ->select('Id', 'Nombre', 'Direccion')
            ->where('Id', $id)
            ->first();

        if ($locacion) {
            return response()->json($locacion);
        } else {
            return response()->json(['message' => 'Locación no encontrada'], 404);
        }
    }

    public function getByTipoLocacionId(int $tipoLocacionId)
    {
        $locaciones = DB::table('Locaciones')
            ->select('Id', 'Nombre', 'Direccion')
            ->where('TipoLocacionId', $tipoLocacionId)
            ->get();

        return response()->json($locaciones);
    }

    public function getByColoniaId(int $coloniaId)
    {
        $locaciones = DB::table('Locaciones')
            ->select('Id', 'Nombre', 'Direccion')
            ->where('ColoniaId', $coloniaId)
            ->get();

        return response()->json($locaciones);
    }

    public function getByNombre(string $nombre)
    {
        $locaciones = DB::table('Locaciones')
            ->select('Id', 'Nombre', 'Direccion')
            ->where('Nombre', 'like', '%' . $nombre . '%')
            ->get();

        return response()->json($locaciones);
    }

    public function createLocation(array $data)
    {
        $id = DB::table('Locaciones')->insertGetId([
            'Nombre' => $data['Nombre'],
            'Direccion' => $data['Direccion'],
            'ColoniaId' => $data['ColoniaId'],
            'Telefono' => $data['Telefono'] ?? null,
            'TipoLocacionId' => $data['TipoLocacionId']
        ]);

        return response()->json(['message' => 'Locación creada', 'id' => $id], 201);
    }

    public function updateLocation(int $id, array $data)
    {
        $updated = DB::table('Locaciones')
            ->where('Id', $id)
            ->update([
                'Nombre' => $data['Nombre'],
                'Direccion' => $data['Direccion'],
                'ColoniaId' => $data['ColoniaId'],
                'Telefono' => $data['Telefono'] ?? null,
                'TipoLocacionId' => $data['TipoLocacionId']
            ]);

        if ($updated) {
            return response()->json(['message' => 'Locación actualizada']);
        } else {
            return response()->json(['message' => 'Locación no encontrada'], 404);
        }
    }

    public function deleteLocation(int $id)
    {
        $deleted = DB::table('Locaciones')
            ->where('Id', $id)
            ->delete();

        if ($deleted) {
            return response()->json(['message' => 'Locación eliminada']);
        } else {
            return response()->json(['message' => 'Locación no encontrada'], 404);
        }
    }
}