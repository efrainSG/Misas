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
        return response()->json([
            'success' => true,
            'message' => 'Colonias obtenidas exitosamente',
            'data' => $this->coloniaService->getAll()
        ]);
    }

    public function getAllDescriptive()
    {
        return response()->json([
            'success' => true,
            'message' => 'Colonias obtenidas exitosamente',
            'data' => $this->coloniaService->getAllDescriptive()
        ]);
    }

    public function getById(int $id)
    {
        $data = $this->coloniaService->getById($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontraron colonias con ese ID'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Colonia obtenida exitosamente',
            'data' => $data
        ]);
    }

    public function getByNombre(string $nombre)
    {
        return response()->json([
            'success' => true,
            'message' => 'Colonias obtenidas exitosamente',
            'data' => $this->coloniaService->getByNombre($nombre)
        ]);
    }

    public function getByCiudadId(int $ciudadId)
    {
        return response()->json([
            'success' => true,
            'message' => 'Colonias obtenidas exitosamente',
            'data' => $this->coloniaService->getByCiudadId($ciudadId)
        ]);
    }

    public function create(CreateColoniaRequest $request)
    {
        // Crear la nueva colonia
        $newColonia = $this->coloniaService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Colonia creada exitosamente',
            'data' => $newColonia
        ], 201);
    }

    public function update(int $id, UpdateColoniaRequest $request)
    {
        // Actualizar la colonia existente
        $updatedColonia = $this->coloniaService->update($id, $request->validated());

        return response()->json([
            'success' => $updatedColonia['success'],
            'message' => $updatedColonia['message'],
            'data' => $updatedColonia['data'] ?? null
        ], $updatedColonia['status'] ?? 200);
    }

    public function delete(int $id)
    {
        $deleted = $this->coloniaService->delete($id);

        return response()->json([
            'success' => $deleted['success'],
            'message' => $deleted['message']
        ], $deleted['status'] ?? 200);
    }
}
?>