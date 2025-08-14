<?php

namespace App\Services;

//use App\Models\Post;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Http;

class CompaniaService
{

    public $url_api_dian_test;
    public $url_api_dian;

    public function __construct()
    {
        $this->url_api_dian_test = config('services.dian.test_url');
        $this->url_api_dian      = config('services.dian.url');
    }


    public function list(array $params = [])
    {
        /* return QueryBuilder::for(Post::class)
            ->allowedFilters([
                'title',
                'status',
                AllowedFilter::exact('author_id'),
            ])
            ->allowedSorts(['title', 'created_at'])
            ->allowedIncludes(['author', 'comments'])
            ->paginate($params['per_page'] ?? 15);*/
    }

    public function create(array $data)
    {
        $identificacion = $data['identificacion'];
        $dv = $this->calcularDigitoVerificacion($identificacion);

        $response = http::post($this->url_api_dian_test . '/'.$identificacion.'/'.$dv, [
            'tipo_documento' => $data['tipo_documento'],
            'identificacion' => $identificacion,
            'dv'             => $dv,
            'tipo_organizacion' => $data['tipo_organizacion'],
            'tipo_regimen'      => $data['tipo_regimen'],
            'tipo_responsabilidad' => $data['tipo_responsabilidad'],
            'nombre'          => $data['nombre'],
            'telefono'        => $data['telefono'],
            'direccion'       => $data['direccion'],
            'correo'          => $data['correo'],
        ]);





    }

    function calcularDigitoVerificacion(string $nit): int
    {
        // Pesos según la posición (de derecha a izquierda)
        $pesos = [71, 67, 59, 53, 47, 43, 41, 37, 29, 23, 19, 17, 13, 7, 3];

        $nit = str_pad($nit, 15, '0', STR_PAD_LEFT); // Rellenar a 15 dígitos

        $suma = 0;
        for ($i = 0; $i < 15; $i++) {
            $digito = (int) $nit[$i];
            $peso = $pesos[$i];
            $suma += $digito * $peso;
        }

        $modulo = $suma % 11;
        $resultado = 11 - $modulo;

        if ($resultado >= 10) {
            return 0;
        }

        return $resultado;
    }
}
