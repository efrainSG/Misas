<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ColoniaService;

class ColoniaController extends Controller
{
    private $coloniaService;

    public function __construct(ColoniaService $coloniaService)
    {
        $this->coloniaService = $coloniaService;
    }

    public function getAll()
    {
        return $this->coloniaService->getAll();
    }

    public function getById(int $id)
    {
        $data = $this->coloniaService->getById($id);
        if ($data->isEmpty()) {
            return response()->json(['message' => 'No se encontraron colonias con ese ID'], 404);
        }
        return $data;
    }

    public function getByNombre(string $nombre)
    {
        return $this->coloniaService->getByNombre($nombre);
    }

    public function getByCiudadId(int $ciudadId)
    {
        return $this->coloniaService->getByCiudadId($ciudadId);
    }

}
