<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HorarioService;
use App\Http\Requests\CreateHorarioRequest;
use App\Http\Requests\UpdateHorarioRequest;

class HorarioController extends Controller
{
    private $horarioService;

    public function __construct(HorarioService $horarioService)
    {
        $this->horarioService = $horarioService;
    }

    public function getAll()
    {
        return response()->json([
            'success' => true,
            'message' => 'Horarios obtenidos exitosamente',
            'data' => $this->horarioService->getAll()
        ]);
    }

    public function getAllDescriptive()
    {
        return response()->json([
            'success' => true,
            'message' => 'Horarios obtenidos exitosamente',
            'data' => $this->horarioService->getAllDescriptive()
        ]);
    }

    public function getById(int $id)
    {
        $data = $this->horarioService->getById($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontraron horarios con ese ID'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Horario obtenido exitosamente',
            'data' => $data
        ]);
    }

    public function getByDiaSemana(string $diaSemana)
    {
        return response()->json([
            'success' => true,
            'message' => 'Horarios obtenidos exitosamente',
            'data' => $this->horarioService->getByDiaSemana($diaSemana)
        ]);
    }

    public function getByActivo(bool $activo)
    {
        return response()->json([
            'success' => true,
            'message' => 'Horarios obtenidos exitosamente',
            'data' => $this->horarioService->getByActivo($activo)
        ]);
    }

    public function getByHora(string $hora)
    {
        return response()->json([
            'success' => true,
            'message' => 'Horarios obtenidos exitosamente',
            'data' => $this->horarioService->getByHora($hora)
        ]);
    }

    public function getByLocacionId(int $locacionId)
    {
        return response()->json([
            'success' => true,
            'message' => 'Horarios obtenidos exitosamente',
            'data' => $this->horarioService->getByLocacionId($locacionId)
        ]);
    }

    public function findHorarios(Request $request)
    {
        $ciudadId = $request->query('ciudadid');
        $diaSemana = $request->query('diasemana');
        $hora = $request->query('hora');

        return response()->json([
            'success' => true,
            'message' => 'Horarios encontrados exitosamente.'.' Filtros: Ciudad=' .
            $ciudadId . ', Día=' . $diaSemana . ', Hora=' . $hora,
            'data' => $this->horarioService->findHorarios($ciudadId, $diaSemana, $hora)
        ]);
    }

    public function create(CreateHorarioRequest $request)
    {
        // Crear el nuevo horario
            $newHorario = $this->horarioService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Horario creado exitosamente',
            'data' => $newHorario
        ], 201);
    }

    public function update(int $id, UpdateHorarioRequest $request)
    {
        // Actualizar el horario existente
        $updatedHorario = $this->horarioService->update($id, $request->validated());

        return response()->json([
            'success' => $updatedHorario['success'],
            'message' => $updatedHorario['message'],
            'data' => $updatedHorario['data'] ?? null
        ], $updatedHorario['status'] ?? 200);
    }

    public function delete(int $id)
    {
        $deleted = $this->horarioService->delete($id);

        return response()->json([
            'success' => $deleted['success'],
            'message' => $deleted['message']
        ], $deleted['status'] ?? 200);
    }
}