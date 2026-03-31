<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return $this->coloniaService->getById($id);
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
