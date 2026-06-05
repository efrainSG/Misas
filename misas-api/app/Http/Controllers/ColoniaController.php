<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ColoniaService;
use App\Http\Requests\CreateColoniaRequest;
use App\Http\Requests\UpdateColoniaRequest;

class ColoniaController extends Controller
{
    private $coloniaService;

    public function __construct(ColoniaService $coloniaService)
    {
        $this->coloniaService = $coloniaService;
    }

    public function getAll()
    {
        $result = $this->coloniaService->getAll();
        
        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function getAllDescriptive()
    {
        $result = $this->coloniaService->getAllDescriptive();
        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function getById(int $id)
    {
        $result = $this->coloniaService->getById($id);

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function getByNombre(string $nombre)
    {
        $result = $this->coloniaService->getByNombre($nombre);

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function getByCiudadId(int $ciudadId)
    {
        $result = $this->coloniaService->getByCiudadId($ciudadId);

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function create(CreateColoniaRequest $request)
    {
        // Crear la nueva colonia
        $result = $this->coloniaService->create($request->validated());

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function update(int $id, UpdateColoniaRequest $request)
    {
        // Actualizar la colonia existente
        $result = $this->coloniaService->update($id, $request->validated());

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function delete(int $id)
    {
        $result = $this->coloniaService->delete($id);

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }
}
?>