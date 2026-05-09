<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TipoLocacionService;

class TiposLocacionController extends Controller
{
    private $tipoLocacionService;

    public function __construct(TipoLocacionService $tipoLocacionService)
    {
        $this->tipoLocacionService = $tipoLocacionService;
    }

    public function getAll()
    {
        return $this->tipoLocacionService->getAll();
    }

    public function getById(int $id)
    {
        $data = $this->tipoLocacionService->getById($id);
        if (!$data) {
            return response()->json(['message' => 'No se encontraron tipos de locación con ese ID'], 404);
        }
        return $data;
    }

    public function getByNombre(string $nombre)
    {
        $data = $this->tipoLocacionService->getByNombre($nombre);
        return $data;
    }

    public function create(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255'
        ]);

        // Crear el nuevo tipo de locación
        $newTipoLocacion = $this->tipoLocacionService->createTipoLocacion($validatedData);

        return response()->json($newTipoLocacion, 201);
    }

    public function update(int $id, Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100'
        ]);

        // Actualizar el tipo de locación existente
        $updatedTipoLocacion = $this->tipoLocacionService->updateTipoLocacion($id, $validatedData);

        if (!$updatedTipoLocacion) {
            return response()->json(['message' => 'No se encontró el tipo de locación para actualizar'], 404);
        }

        return response()->json($updatedTipoLocacion);
    }

    public function delete(int $id)
    {
        $deleted = $this->tipoLocacionService->deleteTipoLocacion($id);

        if (!$deleted) {
            return response()->json(['message' => 'No se encontró el tipo de locación para eliminar'], 404);
        }

        return response()->json(['message' => 'Tipo de locación eliminado exitosamente']);
    }
}
?>