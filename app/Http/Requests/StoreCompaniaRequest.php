<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\TypeDocumentIdentification;
use Illuminate\Validation\Rule;
use App\Models\TypeLiabilities;
use App\Models\TypeOrganizations;
use App\Models\TypeRegimen;
use App\Models\Municipalities;
use Dedoc\Scramble\Attributes\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\ScrambleExtensions\ValidationExceptionToResponseExtension;

class StoreCompaniaRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $modelTypeDocumentIdentification = new TypeDocumentIdentification;
        $modelTypeLiabilities = new TypeLiabilities;
        $modelTypeOrganizations = new TypeOrganizations;
        $modelTypeRegimen = new TypeRegimen;
        $modelMunicipalities = new Municipalities;

        return [
            'tipo_documento' => [
                'required',
                'integer',
                Rule::exists(
                    $modelTypeDocumentIdentification->getConnectionName() . '.' . $modelTypeDocumentIdentification->getTable(),
                    'id'
                ),
            ],
            'identificacion' => ['required', 'string', 'max:191'],
            'tipo_organizacion' => [
                'required',
                'integer',
                Rule::exists(
                    $modelTypeOrganizations->getConnectionName() . '.' . $modelTypeOrganizations->getTable(),
                    'id'
                ),
            ],
            'tipo_regimen' => [
                'required',
                'integer',
                Rule::exists(
                    $modelTypeRegimen->getConnectionName() . '.' . $modelTypeRegimen->getTable(),
                    'id'
                ),
            ],
            'tipo_responsabilidad' => [
                'required',
                'integer',
                Rule::exists(
                    $modelTypeLiabilities->getConnectionName() . '.' . $modelTypeLiabilities->getTable(),
                    'id'
                ),
            ],
            'razon_social' => ['required', 'string', 'max:255'],
            'municipio' => [
                'required',
                'integer',
                Rule::exists(
                    $modelMunicipalities->getConnectionName() . '.' . $modelMunicipalities->getTable(),
                    'id'
                ),
            ],
            'telefono' => ['required', 'string', 'max:191'],
            'direccion' => ['required', 'string', 'max:191'],
            'correo' => ['required', 'string', 'max:191']

        ];
    }

 

    public function messages(): array
    {
        $opciones = (new TypeDocumentIdentification)
            ->newQuery()
            ->get(['id', 'name'])
            ->map(fn($item) => "{$item->id} - {$item->name}")
            ->implode(', ');

        $opcionesOrganizaciones = (new TypeOrganizations)
            ->newQuery()
            ->get(['id', 'name'])
            ->map(fn($item) => "{$item->id} - {$item->name}")
            ->implode(', ');

        $opcionesTypeRegimen = (new TypeRegimen)
            ->newQuery()
            ->get(['id', 'name'])
            ->map(fn($item) => "{$item->id} - {$item->name}")
            ->implode(', ');

        $opcionesTypeLiabilities = (new TypeLiabilities)
            ->newQuery()
            ->get(['id', 'name'])
            ->map(fn($item) => "{$item->id} - {$item->name}")
            ->implode(', ');

        return [
            'tipo_documento.required'    => 'El campo tipo_documento es obligatorio.',
            'tipo_documento.integer'     => 'El campo tipo_documento debe ser un número entero.',
            'tipo_documento.exists'      => "El tipo_documento no es válido. Opciones permitidas: {$opciones}",

            'tipo_organizacion.required' => 'El campo tipo_organizacion es obligatorio.',
            'tipo_organizacion.integer'  => 'El campo tipo_organizacion debe ser un número entero.',
            'tipo_organizacion.exists'   => "El tipo_organizacion no es válido. Opciones permitidas: {$opcionesOrganizaciones}",

            'tipo_regimen.required' => 'El campo tipo_regimen es obligatorio.',
            'tipo_regimen.integer'  => 'El campo tipo_regimen debe ser un número entero.',
            'tipo_regimen.exists'   => "El tipo_regimen no es válido. Opciones permitidas: {$opcionesTypeRegimen}",

            'tipo_responsabilidad.required' => 'El campo tipo_responsabilidad es obligatorio.',
            'tipo_responsabilidad.integer'  => 'El campo tipo_responsabilidad debe ser un número entero.',
            'tipo_responsabilidad.exists'   => "El tipo_responsabilidad no es válido. Opciones permitidas: {$opcionesTypeLiabilities}",

            'municipio.required' => 'El campo municipio es obligatorio.',
            'municipio.integer'  => 'El campo municipio debe ser un número entero.',
            'municipio.exists'   => "El municipio no es válido. Opciones permitidas: revisar documentacion",

            'razon_social.required' => 'El campo razon_social es obligatorio.',
            'razon_social.string'   => 'El campo razon_social debe ser una cadena de texto.',
            'razon_social.max'      => 'El campo razon_social no debe exceder los 255 caracteres.',

            'telefono.required' => 'El campo telefono es obligatorio.',
            'telefono.string'   => 'El campo telefono debe ser una cadena de texto.',
            'telefono.max'      => 'El campo telefono no debe exceder los 191 caracteres.',

            'direccion.required' => 'El campo direccion es obligatorio.',
            'direccion.string'   => 'El campo direccion debe ser una cadena de texto.',
            'direccion.max'      => 'El campo direccion no debe exceder los 191 caracteres.',

            'correo.required' => 'El campo correo es obligatorio.',
            'correo.string'   => 'El campo correo debe ser una cadena de texto.',
            'correo.max'      => 'El campo correo no debe exceder los 191 caracteres.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'alert'   => 'error',
                'mensaje' => 'Datos inválidos',
                'errores'  => $validator->errors()
            ], 422)
        );
    }
}
