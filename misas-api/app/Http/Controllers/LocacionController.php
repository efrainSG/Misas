<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocacionController extends Controller
{
    private $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function getAll()
    {
        return $this->locationService->getAll();
    }

    public function getById(int $id)
    {
        return $this->locationService->getById($id);
    }

    public function getByTipoLocacionId(int $tipoLocacionId)
    {
        return $this->locationService->getByTipoLocacionId($tipoLocacionId);
    }

    public function getByColoniaId(int $coloniaId)
    {
        return $this->locationService->getByColoniaId($coloniaId);
    }

    public function getByNombre(string $nombre)
    {
        return $this->locationService->getByNombre($nombre);
    }
}
