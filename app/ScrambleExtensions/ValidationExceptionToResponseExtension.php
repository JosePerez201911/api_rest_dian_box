<?php

namespace App\ScrambleExtensions;

use Dedoc\Scramble\Extensions\ExceptionToResponseExtension;
use Dedoc\Scramble\Support\Generator\Reference;
use Dedoc\Scramble\Support\Generator\Response;
use Dedoc\Scramble\Support\Generator\Schema;
use Dedoc\Scramble\Support\Generator\Types as OpenApiTypes;
use Dedoc\Scramble\Support\Type\ObjectType;
use Dedoc\Scramble\Support\Type\Type;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ValidationExceptionToResponseExtension extends ExceptionToResponseExtension
{
    public function shouldHandle(Type $type)
    {
        return $type instanceof ObjectType
            && $type->isInstanceOf(ValidationException::class);
    }

    public function toResponse(Type $type)
    {
        $validationResponseBodyType = (new OpenApiTypes\ObjectType)
                ->addProperty(
                'alert',
                (new OpenApiTypes\StringType)
                    ->setDescription('error.')
            )
            ->addProperty(
                'mensaje',
                (new OpenApiTypes\StringType)
                    ->setDescription('Datos inválidos.')
            )
            ->addProperty(
                'errores',
                (new OpenApiTypes\ObjectType)
                    ->setDescription('Una descripción detallada de cada campo que no pasó la validación.')
                    ->additionalProperties((new OpenApiTypes\ArrayType)->setItems(new OpenApiTypes\StringType))
            )
            ->setRequired(['mensaje', 'errores']);

        return Response::make(422)
            ->setDescription('Validacion de campos')
            ->setContent(
                'application/json',
                Schema::fromType($validationResponseBodyType),
            );
    }

    public function reference(ObjectType $type)
    {
        return new Reference('responses', Str::start($type->name, '\\'), $this->components);
    }
} 