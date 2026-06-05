<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LocationService;
use App\Http\Requests\CreateLocacionRequest;
use App\Http\Requests\UpdateLocacionRequest;

class LocacionController extends Controller
{
    private $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function getAll()
    {
        $result = $this->locationService->getAll();
        
        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function getAllDescriptive()
    {
        $result = $this->locationService->getAllDescriptive();
        
        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function getById(int $id)
    {
        $result = $this->locationService->getById($id);

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function getByTipoLocacionId(int $tipoLocacionId)
    {
        $result = $this->locationService->getByTipoLocacionId($tipoLocacionId);
        
        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function getByColoniaId(int $coloniaId)
    {
        $result = $this->locationService->getByColoniaId($coloniaId);
        
        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function getByNombre(string $nombre)
    {
        $result = $this->locationService->getByNombre($nombre);

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function getByTipoAndColonia(int $tipoLocacionId, int $coloniaId)
    {
        $result = $this->locationService->getByTipoAndColonia($tipoLocacionId, $coloniaId);

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function getHorariosByLocacionId(int $locacionId)
    {
        $pre_result = $this->locationService->getById($locacionId);
        if (!$pre_result->success) {
            return response()->json([
                'success' => $pre_result->success,
                'message' => $pre_result->message
            ], $pre_result->status);
        }

        $result = $this->locationService->getHorariosByLocacionId($locacionId);

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function create(CreateLocacionRequest $request)
    {
        // Crear la nueva locación
        $result = $this->locationService->create($request->validated());

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function update(int $id, UpdateLocacionRequest $request)
    {
        // Actualizar la locación existente
        $result = $this->locationService->update($id, $request->validated());

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function delete(int $id)
    {
        $result = $this->locationService->delete($id);

        return response()->json([
            'success' => $result->success,
            'message' => $result->message
        ], $result->status);
    }
}