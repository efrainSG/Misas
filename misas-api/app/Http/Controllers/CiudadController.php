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
        return response()->json([
            'success' => true,
            'message' => 'Ciudades obtenidas exitosamente',
            'data' => $this->ciudadService->getAll()
        ]);
    }

    public function getById(int $id)
    {
        $data = $this->ciudadService->getById($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontraron ciudades con ese ID'], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Ciudad obtenida exitosamente',
            'data' => $data
        ]);
    }

    public function getByNombre(string $nombre)
    {
        $data = $this->ciudadService->getByNombre($nombre);
        return response()->json([
            'success' => true,
            'message' => 'Ciudades obtenidas exitosamente',
            'data' => $data
        ]);
    }

    public function create(CreateCiudadRequest $request)
    {
        // Crear la nueva ciudad
        $newCiudad = $this->ciudadService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Ciudad creada exitosamente',
            'data' => $newCiudad
        ], 201);
    }

    public function update(int $id, UpdateCiudadRequest $request)
    {
        $updatedCiudad = $this->ciudadService->update($id, $request->validated());

        return response()->json([
            'success' => $updatedCiudad['success'],
            'message' => $updatedCiudad['message'],
            'data' => $updatedCiudad['data'] ?? null
        ], $updatedCiudad['status'] ?? 200);
    }

    public function delete(int $id)
    {
        $deleted = $this->ciudadService->delete($id);

        return response()->json([
            'success' => $deleted['success'],
            'message' => $deleted['message']
        ], $deleted['status'] ?? 200);
    }
}