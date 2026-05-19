<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CiudadService;

class CiudadController extends Controller
{
    private $ciudadService;

    public function __construct(CiudadService $ciudadService)
    {
        $this->ciudadService = $ciudadService;
    }

    public function getAll()
    {
        return $this->ciudadService->getAll();
    }

    public function getById(int $id)
    {
        $data = $this->ciudadService->getById($id);
        if (!$data) {
            return response()->json(['message' => 'No se encontraron ciudades con ese ID'], 404);
        }
        return $data;
    }

    public function getByNombre(string $nombre)
    {
        $data = $this->ciudadService->getByNombre($nombre);
        return $data;
    }

    public function create(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100'
        ]);

        // Crear la nueva ciudad
        $newCiudad = $this->ciudadService->create($validatedData);

        if ($newCiudad instanceof \Illuminate\Http\JsonResponse) {
            return $newCiudad; // Retorna el error de validación si existe
        }
        return response()->json($newCiudad, 201);
    }

    public function update(int $id, Request $request)
    {
        if ($id != $request->input('id')) {
            return response()->json(['message' => 'El ID en la ruta no coincide con el ID en el cuerpo de la solicitud'], 400);
        }
        
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100'
        ]);

        // Actualizar la ciudad existente
        $updatedCiudad = $this->ciudadService->update($id, $validatedData);

        if (!$updatedCiudad) {
            return response()->json(['message' => 'No se encontró la ciudad para actualizar'], 404);
        }

        return response()->json($updatedCiudad);
    }

    public function delete(int $id)
    {
        $deleted = $this->ciudadService->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'No se encontró la ciudad para eliminar'], 404);

        }
        return response()->json(['message' => 'Ciudad eliminada exitosamente']);
    }
}