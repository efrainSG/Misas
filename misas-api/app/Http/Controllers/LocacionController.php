<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LocationService;

class LocacionController extends Controller
{
    private $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function getAll()
    {
        return $this->locationService->getAll();
    }

    public function getById(int $id)
    {
        $data = $this->locationService->getById($id);
        if (!$data) {
            return response()->json(['message' => 'No se encontraron locaciones con ese ID'], 404);
        }
        return $data;
    }

    public function getByTipoLocacionId(int $tipoLocacionId)
    {
        return $this->locationService->getByTipoLocacionId($tipoLocacionId);
    }

    public function getByColoniaId(int $coloniaId)
    {
        $data = $this->locationService->getByColoniaId($coloniaId);
        return $data;
    }

    public function getByNombre(string $nombre)
    {
        $data = $this->locationService->getByNombre($nombre);
        return $data;
    }

    public function getHorariosByLocacionId(int $locacionId)
    {
        $locacion = $this->locationService->getById($locacionId);
        if (!$locacion) {
            return response()->json(['message' => 'No se encontró la locación con ese ID'], 404);
        }

        $data = $this->locationService->getHorariosByLocacionId($locacionId);

        if ($data->isEmpty()) {
            return response()->json(['message' => 'No se encontraron horarios para esta locación'], 404);
        }

        return response()->json([
            'locacion' => $data[0]->LocacionNombre,
            'horarios' => $data->map(function ($item) {
                return [
                    'diaSemana' => $item->DiaSemana,
                    'hora' => $item->Hora,
                    'notas' => $item->Notas
                ];
            })
        ]);
    }

    public function create(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'direccion' => 'required|string|max:500',
            'tipoLocacionId' => 'required|integer',
            'coloniaId' => 'required|integer',
            'telefono' => 'nullable|string|max:20'
        ]);

        // Crear la nueva locación
        $newLocacion = $this->locationService->createLocation($validatedData);

        return response()->json($newLocacion, 201);
    }
}
