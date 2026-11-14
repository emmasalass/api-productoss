<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Listar todos los productos (GET /api/productos)
     */
    public function index()
    {
        $productos = Producto::all();

        return response()->json([
            'status' => true,
            'message' => 'Lista de productos obtenida correctamente',
            'data' => $productos
        ], 200);
    }

    /**
     * Crear un nuevo producto con validaciones (POST /api/productos)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $producto = Producto::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Producto creado exitosamente',
            'data' => $producto
        ], 201);
    }

    /**
     * Mostrar un producto específico por su ID (GET /api/productos/{id})
     */
    public function show($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'status' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Producto encontrado',
            'data' => $producto
        ], 200);
    }

    /**
     * Actualizar un producto existente (PUT /api/productos/{id})
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'status' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'sometimes|required|numeric|min:0',
            'stock' => 'sometimes|required|integer|min:0',
        ]);

        $producto->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Producto actualizado exitosamente',
            'data' => $producto
        ], 200);
    }

    /**
     * Eliminar un producto (DELETE /api/productos/{id})
     */
    public function destroy($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return response()->json([
                'status' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        $producto->delete();

        return response()->json([
            'status' => true,
            'message' => 'Producto eliminado exitosamente'
        ], 200);
    }
}