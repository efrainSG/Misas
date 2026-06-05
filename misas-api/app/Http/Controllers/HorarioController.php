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
        $result = $this->horarioService->getAll();

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function getAllDescriptive()
    {
        $result = $this->horarioService->getAllDescriptive();
        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function getById(int $id)
    {
        $result = $this->horarioService->getById($id);

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function getByDiaSemana(string $diaSemana)
    {
        $result = $this->horarioService->getByDiaSemana($diaSemana);

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function getByActivo(bool $activo)
    {
        $result = $this->horarioService->getByActivo($activo);

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function getByHora(string $hora)
    {
        $result = $this->horarioService->getByHora($hora);

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function getByLocacionId(int $locacionId)
    {
        $result = $this->horarioService->getByLocacionId($locacionId);

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function findHorarios(Request $request)
    {
        $ciudadId = $request->query('ciudadid');
        $diaSemana = $request->query('diasemana');
        $hora = $request->query('hora');

        $result = $this->horarioService->findHorarios($ciudadId, $diaSemana, $hora);

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function create(CreateHorarioRequest $request)
    {
        // Crear el nuevo horario
        $result = $this->horarioService->create($request->validated());

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function update(int $id, UpdateHorarioRequest $request)
    {
        // Actualizar el horario existente
        $result = $this->horarioService->update($id, $request->validated());

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function delete(int $id)
    {
        $result = $this->horarioService->delete($id);

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }
}