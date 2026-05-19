<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;

class TipoLocacionService {
    
    public function getAll()
    {
        $tiposLocacion = DB::table('TipoLocaciones')
            ->select('Id', 'Nombre', 'Descripcion')
            ->get();

        return $tiposLocacion;
    }

    public function getById(int $id)
    {
        $tipoLocacion = DB::table('TipoLocaciones')
            ->select('Id', 'Nombre', 'Descripcion')
            ->where('Id', $id)
            ->first();

        return $tipoLocacion;
    }

    public function getByNombre(string $nombre)
    {
        $tipoLocacion = DB::table('TipoLocaciones')
            ->select('Id', 'Nombre', 'Descripcion')
            ->where('Nombre', 'like', '%' . $nombre . '%')
            ->get();

        return $tipoLocacion;
    }

    public function create(array $data)
    {
        $exists = DB::table('TipoLocaciones')
            ->where('Nombre', $data['nombre'])
            ->exists();
        
        if ($exists) {
            return response()->json(['message' => 'Ya existe un tipo de locación con ese nombre'], 400);
        }

        $tipoLocacionId = DB::table('TipoLocaciones')->insertGetId([
            'Nombre' => $data['nombre'],
            'Descripcion' => $data['descripcion'] ?? null
        ]);

        return $this->getById($tipoLocacionId);
    }

    public function update(int $id, array $data)
    {
        $exists = DB::table('TipoLocaciones')
        ->where('Id', $id)
        ->exists();

        if (!$exists) {
            return null;
        }
        
        DB::table('TipoLocaciones')
        ->where('Id', $id)
        ->update([
            'Nombre' => $data['nombre'],
            'Descripcion' => $data['descripcion'] ?? null
        ]);
        
        return $this->getById($id);
    }

    public function delete(int $id)
    {
        $allowDelete = DB::table('Locaciones')
            ->where('TipoLocacionId', $id)
            ->count() === 0;
        if (!$allowDelete) {
            return response()->json(['message' => 'No se puede eliminar el tipo de locación porque hay locaciones asociadas'], 400);
        }

        $deleted = DB::table('TipoLocaciones')
            ->where('Id', $id)
            ->delete();

        if ($deleted) {
            return response()->json(['message' => 'Tipo de locación eliminado']);
        } else {
            return response()->json(['message' => 'Tipo de locación no encontrado'], 404);
        }
    }
}
?>