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
        return $this->ciudadService->getByNombre($nombre);
    }

    public function create(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100'
        ]);

        // Crear la nueva ciudad
        $newCiudad = $this->ciudadService->createCiudad($validatedData);

        return response()->json($newCiudad, 201);
    }
}
