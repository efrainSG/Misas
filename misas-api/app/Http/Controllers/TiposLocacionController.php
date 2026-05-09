<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TipoLocacionService;

class TiposLocacionController extends Controller
{
    private $tipoLocacionService;

    public function __construct(TipoLocacionService $tipoLocacionService)
    {
        $this->tipoLocacionService = $tipoLocacionService;
    }

    public function getAll()
    {
        return $this->tipoLocacionService->getAll();
    }

    public function getById(int $id)
    {
        $data = $this->tipoLocacionService->getById($id);
        if (!$data) {
            return response()->json(['message' => 'No se encontraron tipos de locación con ese ID'], 404);
        }
        return $data;
    }

    public function getByNombre(string $nombre)
    {
        $data = $this->tipoLocacionService->getByNombre($nombre);
        return $data;
    }
}
?>