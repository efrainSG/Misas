<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ColoniaService;

class ColoniaController extends Controller
{
    private $coloniaService;

    public function __construct(ColoniaService $coloniaService)
    {
        $this->coloniaService = $coloniaService;
    }

    public function getAll()
    {
        return $this->coloniaService->getAll();
    }

    public function getAllDescriptive()
    {
        return $this->coloniaService->getAllDescriptive();
    }

    public function getById(int $id)
    {
        $data = $this->coloniaService->getById($id);
        if (!$data) {
            return response()->json(['message' => 'No se encontraron colonias con ese ID'], 404);
        }
        return $data;
    }

    public function getByNombre(string $nombre)
    {
        return $this->coloniaService->getByNombre($nombre);
    }

    public function getByCiudadId(int $ciudadId)
    {
        return $this->coloniaService->getByCiudadId($ciudadId);
    }

    public function create(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'ciudadId' => 'required|integer'
        ]);

        // Crear la nueva colonia
        $newColonia = $this->coloniaService->create($validatedData);

        return response()->json($newColonia, 201);
    }

    public function update(int $id, Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'ciudadId' => 'required|integer'
        ]);

        // Actualizar la colonia existente
        $updatedColonia = $this->coloniaService->update($id, $validatedData);

        if (!$updatedColonia) {
            return response()->json(['message' => 'No se encontró la colonia para actualizar'], 404);
        }

        return response()->json($updatedColonia);
    }

    public function delete(int $id)
    {
        $deleted = $this->coloniaService->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'No se encontró la colonia para eliminar'], 404);
        }

        return response()->json(['message' => 'Colonia eliminada exitosamente']);
    }

}
?>