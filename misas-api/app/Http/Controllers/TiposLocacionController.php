<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TipoLocacionService;
use App\Http\Requests\CreateTipoLocacionRequest;
use App\Http\Requests\UpdateTipoLocacionRequest;

class TiposLocacionController extends Controller
{
    private $tipoLocacionService;

    public function __construct(TipoLocacionService $tipoLocacionService)
    {
        $this->tipoLocacionService = $tipoLocacionService;
    }

    public function getAll()
    {
        $result = $this->tipoLocacionService->getAll();

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms ?? null,
        ], $result->status ?? 200);
    }

    public function getById(int $id)
    {
        $result = $this->tipoLocacionService->getById($id);

        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms ?? null,
        ], $result->status ?? 200);
    }

    public function getByNombre(string $nombre)
    {
        $result = $this->tipoLocacionService->getByNombre($nombre);
        return response()->json([
            'success' => $result->success,
            'message' => $result->message,
            'data' => $result->data,
            'execution_time_ms' => $result->execution_time_ms ?? null,
        ], $result->status ?? 200);
    }

    public function create(CreateTipoLocacionRequest $request)
    {
        $newTipoLocacion = $this->tipoLocacionService->create($request->validated());

        return response()->json([
            'success' => $newTipoLocacion->success,
            'message' => $newTipoLocacion->message,
            'data' => $newTipoLocacion->data,
            'execution_time_ms' => $newTipoLocacion->execution_time_ms ?? null,
        ], $newTipoLocacion->status ?? 201);
    }

    public function update(int $id, UpdateTipoLocacionRequest $request)
    {
        // Actualizar el tipo de locación existente
        $updatedTipoLocacion = $this->tipoLocacionService->update($id, $request->validated());

        return response()->json([
            'success' => $updatedTipoLocacion->success,
            'message' => $updatedTipoLocacion->message,
            'data' => $updatedTipoLocacion->data,
            'execution_time_ms' => $updatedTipoLocacion->execution_time_ms ?? null,
        ], $updatedTipoLocacion->status ?? 201);
    }

    public function delete(int $id)
    {
        $deleted = $this->tipoLocacionService->delete($id);

        return response()->json([
            'success' => $deleted->success,
            'message' => $deleted->message,
            'execution_time_ms' => $deleted->execution_time_ms ?? null,
        ], $deleted->status ?? 200);
    }
}