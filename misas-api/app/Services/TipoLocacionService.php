<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;

class TipoLocacionService {
    
    public function getAll()
    {
        $tiposLocacion = DB::table('TipoLocaciones')
            ->select('Id', 'Nombre')
            ->get();

        return $tiposLocacion;
    }

    public function getById(int $id)
    {
        $tipoLocacion = DB::table('TipoLocaciones')
            ->select('Id', 'Nombre')
            ->where('Id', $id)
            ->first();

        return $tipoLocacion;
    }

    public function getByNombre(string $nombre)
    {
        $tipoLocacion = DB::table('TipoLocaciones')
            ->select('Id', 'Nombre')
            ->where('Nombre', 'like', '%' . $nombre . '%')
            ->get();

        return $tipoLocacion;
    }
}
?>