<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CiudadService;

class CiudadController extends Controller
{
    private $ciudadService;

    public function __construct(CiudadService $ciudadService)
    {
        $this->ciudadService = $ciudadService;
    }

    public function getAll()
    {
        return $this->ciudadService->getAll();
    }

    public function getById(int $id)
    {
        $data = $this->ciudadService->getById($id);
        if ($data->isEmpty()) {
            return response()->json(['message' => 'No se encontraron ciudades con ese ID'], 404);
        }
        return $data;
    }

    public function getByNombre(string $nombre)
    {
        return $this->ciudadService->getByNombre($nombre);
    }
}
