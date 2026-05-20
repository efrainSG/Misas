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
        return response()->json([
            'success' => true,
            'message' => 'Tipos de locación obtenidos exitosamente',
            'data' => $this->tipoLocacionService->getAll()
        ]);
    }

    public function getById(int $id)
    {
        $data = $this->tipoLocacionService->getById($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontraron tipos de locación con ese ID'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Tipo de locación obtenido exitosamente',
            'data' => $data
        ]);
    }

    public function getByNombre(string $nombre)
    {
        $data = $this->tipoLocacionService->getByNombre($nombre);
        return response()->json([
            'success' => true,
            'message' => 'Tipo de locación obtenido exitosamente',
            'data' => $data
        ]);
    }

    public function create(CreateTipoLocacionRequest $request)
    {
        $newTipoLocacion = $this->tipoLocacionService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Tipo de locación creado exitosamente',
            'data' => $newTipoLocacion
        ], 201);
    }

    public function update(int $id, UpdateTipoLocacionRequest $request)
    {
        // Actualizar el tipo de locación existente
        $updatedTipoLocacion = $this->tipoLocacionService->update($id, $request->validated());

        return response()->json([
            'success' => $updatedTipoLocacion['success'],
            'message' => $updatedTipoLocacion['message'],
            'data' => $updatedTipoLocacion['data'] ?? null
        ], $updatedTipoLocacion['status'] ?? 200);
    }

    public function delete(int $id)
    {
        $deleted = $this->tipoLocacionService->delete($id);

        return response()->json([
            'success' => $deleted['success'],
            'message' => $deleted['message']
        ], $deleted['status'] ?? 404);
    }
}
?>