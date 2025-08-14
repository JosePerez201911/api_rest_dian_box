<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FacturaService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFacturaRequest;
use Dedoc\Scramble\Attributes\Body;

// app/Http/Controllers/UserController.php
class FacturaController extends Controller
{
       /**
     * @param User $user The resolved user instance.
     */
    protected $service;

    public function __construct(FacturaService $facturaService)
    {
        $this->service = $facturaService;
    }
    public function store(StoreFacturaRequest $request)
    {

        try {
            $this->service->create($request->validated());

            return response()->json([
                'alert'     => 'success',
                'nombre'    => 'Factura enviada con exito',
                'creado_en' => now()->toIso8601String(),
            ], 201);
        } catch (\Exception $e) {
            // Captura cualquier error que ocurra
            return response()->json([
                'alert'   => 'error',
                'message' => 'Errors al crear la compañía',
                'error'   => $e->getMessage()
            ], 422);
        }
    }
}
