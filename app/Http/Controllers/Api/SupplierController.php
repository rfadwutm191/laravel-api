<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $suppliers = Supplier::orderBy('nama')->get();
        return response()->json([
            'data' => $suppliers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama'   => 'required|string|max:255',
            'no_hp'  => 'nullable|string|max:20',
            'email'  => 'nullable|email|max:255',
            'alamat' => 'nullable|string|max:500',
        ]);

        $supplier = Supplier::create($validated);

        return response()->json([
            'data' => $supplier,
            'message' => 'Supplier berhasil ditambahkan'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier): JsonResponse
    {
        return response()->json([
            'data' => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier): JsonResponse
    {
        $validated = $request->validate([
            'nama'   => 'sometimes|required|string|max:255',
            'no_hp'  => 'nullable|string|max:20',
            'email'  => 'nullable|email|max:255',
            'alamat' => 'nullable|string|max:500',
        ]);

        $supplier->update($validated);

        return response()->json([
            'data' => $supplier,
            'message' => 'Supplier berhasil diperbarui'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier): JsonResponse
    {
        // Cek apakah supplier masih memiliki pembelian
        if ($supplier->pembelians()->exists()) {
            return response()->json([
                'message' => 'Supplier tidak dapat dihapus karena memiliki transaksi pembelian'
            ], 422);
        }

        $supplier->delete();

        return response()->json([
            'message' => 'Supplier berhasil dihapus'
        ]);
    }
}