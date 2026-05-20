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
        return response()->json([
            'success' => true,
            'message' => 'Locaciones obtenidas exitosamente',
            'data' => $this->locationService->getAll()
        ]);
    }

    public function getAllDescriptive()
    {
        return response()->json([
            'success' => true,
            'message' => 'Locaciones obtenidas exitosamente',
            'data' => $this->locationService->getAllDescriptive()
        ]);
    }

    public function getById(int $id)
    {
        $data = $this->locationService->getById($id);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontraron locaciones con ese ID'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'Locación obtenida exitosamente',
            'data' => $data
        ]);
    }

    public function getByTipoLocacionId(int $tipoLocacionId)
    {
        return response()->json([
            'success' => true,
            'message' => 'Locaciones obtenidas exitosamente',
            'data' => $this->locationService->getByTipoLocacionId($tipoLocacionId)
        ]);
    }

    public function getByColoniaId(int $coloniaId)
    {
        $data = $this->locationService->getByColoniaId($coloniaId);
        return response()->json([
            'success' => true,
            'message' => 'Locaciones obtenidas exitosamente',
            'data' => $data
        ]);
    }

    public function getByNombre(string $nombre)
    {
        $data = $this->locationService->getByNombre($nombre);
        return response()->json([
            'success' => true,
            'message' => 'Locaciones obtenidas exitosamente',
            'data' => $data
        ]);
    }

    public function getByTipoAndColonia(int $tipoLocacionId, int $coloniaId)
    {
        $data = $this->locationService->getByTipoAndColonia($tipoLocacionId, $coloniaId);
        return response()->json([
            'success' => true,
            'message' => 'Locaciones obtenidas exitosamente',
            'data' => $data
        ]);
    }

    public function getHorariosByLocacionId(int $locacionId)
    {
        $locacion = $this->locationService->getById($locacionId);
        if (!$locacion) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró la locación con ese ID'
            ], 404);
        }

        $data = $this->locationService->getHorariosByLocacionId($locacionId);

        if ($data->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontraron horarios para esta locación'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Horarios obtenidos exitosamente',
            'data' => [
                'locacion' => $data[0]->LocacionNombre,
                'horarios' => $data->map(function ($item) {
                    return [
                        'diaSemana' => $item->DiaSemana,
                        'hora' => $item->Hora,
                        'notas' => $item->Notas
                    ];
                })
            ]
        ]);
    }

    public function create(CreateLocacionRequest $request)
    {
        // Crear la nueva locación
        $newLocacion = $this->locationService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Locación creada exitosamente',
            'data' => $newLocacion
        ], 201);
    }

    public function update(int $id, UpdateLocacionRequest $request)
    {
        // Actualizar la locación existente
        $updatedLocacion = $this->locationService->update($id, $request->validated());

        return response()->json([
            'success' => $updatedLocacion['success'],
            'message' => $updatedLocacion['message'],
            'data' => $updatedLocacion['data'] ?? null
        ], $updatedLocacion['status'] ?? 200);
    }

    public function delete(int $id)
    {
        $deleted = $this->locationService->delete($id);

        return response()->json([
            'success' => $deleted['success'],
            'message' => $deleted['message']
        ], $deleted['status'] ?? 404);
    }
}