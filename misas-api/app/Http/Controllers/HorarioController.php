<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HorarioService;

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
        $data = $this->horarioService->getById($id);
        if (!$data) {
            return response()->json(['message' => 'No se encontraron horarios con ese ID'], 404);
        }
        return $data;
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

    public function create(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'diaSemana' => 'required|integer',
            'locacionId' => 'required|integer',
            'hora' => 'required|string|max:10',
            'activo' => 'required|boolean',
            'notas' => 'nullable|string|max:500'
        ]);

        // Crear el nuevo horario
            $newHorario = $this->horarioService->createHorario($validatedData);

        return response()->json($newHorario, 201);
    }
}
