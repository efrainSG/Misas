<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HorarioController extends Controller
{
    private $horarioService;

    public function __construct(HorarioService $horarioService)
    {
        $this->horarioService = $horarioService;
    }

    public function getAll()
    {
        return $this->horarioService->getAll();
    }

    public function getById(int $id)
    {
        return $this->horarioService->getById($id);
    }

    public function getByDiaSemana(string $diaSemana)
    {
        return $this->horarioService->getByDiaSemana($diaSemana);
    }

    public function getByActivo(bool $activo)
    {
        return $this->horarioService->getByActivo($activo);
    }

    public function getByHora(string $hora)
    {
        return $this->horarioService->getByHora($hora);
    }

    public function getByLocacionId(int $locacionId)
    {
        return $this->horarioService->getByLocacionId($locacionId);
    }
}
