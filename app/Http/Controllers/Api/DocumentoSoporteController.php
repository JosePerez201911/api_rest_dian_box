<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CompaniaService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCompaniaRequest;
use Dedoc\Scramble\Attributes\Endpoint;
use Dedoc\Scramble\Attributes\RequestBody;
use Dedoc\Scramble\Attributes\Response;
use App\DTO\CompaniaResponse;
use App\ScrambleExtensions\ValidationExceptionToResponseExtension;

class DocumentoSoporteController extends Controller
{
    protected $compania;

    public function __construct(CompaniaService $companiaService)
    {
        $this->compania = $companiaService;
    }

    public function index(Request $request)
    {
        return response()->json(
            $this->compania->list($request->all())
        );
    }

    
    public function store(StoreCompaniaRequest $request)
    {
        // Si falla validación, Laravel responde con 422 automáticamente
        // y Scramble lo documenta basado en el FormRequest

        try {
            $this->compania->create($request->validated());

            return response()->json([
                'alert'     => 'success',
                'nombre'    => 'Mi Compañía SAS',
                'nit'       => '900123456-7',
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
