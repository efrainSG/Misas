<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return $this->ciudadService->getById($id);
    }

    public function getByNombre(string $nombre)
    {
        return $this->ciudadService->getByNombre($nombre);
    }
}
