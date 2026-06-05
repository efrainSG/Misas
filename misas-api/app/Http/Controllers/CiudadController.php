<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CiudadService;
use App\Http\Requests\CreateCiudadRequest;
use App\Http\Requests\UpdateCiudadRequest;

class CiudadController extends Controller
{
    private $ciudadService;

    public function __construct(CiudadService $ciudadService)
    {
        $this->ciudadService = $ciudadService;
    }

    public function getAll()
    {
        $result = $this->ciudadService->getAll();

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function getById(int $id)
    {
        $result = $this->ciudadService->getById($id);

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function getByNombre(string $nombre)
    {
        $result = $this->ciudadService->getByNombre($nombre);
        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function create(CreateCiudadRequest $request)
    {
        // Crear la nueva ciudad
        $result = $this->ciudadService->create($request->validated());

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function update(int $id, UpdateCiudadRequest $request)
    {
        $result = $this->ciudadService->update($id, $request->validated());

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }

    public function delete(int $id)
    {
        $result = $this->ciudadService->delete($id);

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'execution_time_ms' => $result->execution_time_ms
        ], $result->status);
    }
}