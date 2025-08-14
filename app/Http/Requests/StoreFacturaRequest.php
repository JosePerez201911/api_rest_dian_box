<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $number Número de documento
 * @property string $type_document_id Tipo de documento
 * @property string $date Fecha en formato YYYY-MM-DD
 * @property string $time Hora en formato HH:mm:ss
 * @property string $resolution_number Número de resolución
 * @property string $prefix Prefijo
 */
class StoreFacturaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            /**
             * Numero de la factura.
             * @var
             * @example 02652662
             */
            'number' => ['required', 'string', 'max:191'],

            /**
             * Tipo de documento a enviar a al DIAN.
             * @var   int
             * @example 1
             */
            'type_document_id' => ['required', 'string', 'max:191'],


            /**
             * Tipo de documento a enviar a al DIAN.
             * @dateTime
             * @example 2025-08-12 
             */
            'date' => ['required', 'date'],

            /**
             * Hora de la Factura
             * @time
             * @example 14:30:00
             */
            'time' => ['required', 'date_format:H:i:s'],

            /**
             * Resolución de la Factura
             * @string
             * @example 152663666
             */
            'resolution_number' => ['required', 'string', 'max:191'],

            /**
             * Prefijo de la Factura
             * @string
             * @example SETT
             */
            'prefix' => ['required', 'string', 'max:191'],

            /**
             * Notas de la Factura
             * @string
             * @example Notas adicionales
             */
            'notes' => ['required', 'string'],


            /**
             * Información del cliente
             * @array
             *
             */
            'customer' => ['required', 'array'],

            /**
             * Indentificacion del cliente
             * @string
             * @example 123456789
             */
            'customer.identification_number' => ['required', 'numeric', 'digits_between:6,15'],

            /**
             * Indentificacion del cliente
             * @string
             * @example CONSUMIDOR FINAL
             */
            'customer.name' => ['required', 'string', 'max:191'],

            /**
             * Telefono del cliente
             * @string
             * @example 22222222
             */
            'customer.phone' => ['required', 'string', 'max:191'],

            /**
             * Direccion del cliente
             * @string
             * @example calle 1234 
             */
            'customer.address' => ['required', 'string', 'max:191'],


            /**
             * Correo electrónico del cliente
             * 
             * @var string
             * @example "cliente@example.com"
             */
            'customer.email' => ['required', 'string', 'email', 'max:191'],


            /**
             * type_document_identification_id
             * 
             * @var string
             * @example "CC"
             */
            'customer.type_document_identification_id' => ['required', 'string'],

            /**
             * type_organization_id
             * 
             * @var string
             * @example "CC"
             */
            'customer.type_organization_id' => ['required', 'string'],

            /**
             * type_liability_id
             * 
             * @var string
             * @example "CC"
             */
            'customer.type_liability_id' => ['required', 'string'],

            /**
             * municipality_id
             * 
             * @var string
             * @example "CC"
             */
            'customer.municipality_id' => ['required', 'string'],

            /**
             * type_regime_id
             * 
             * @var string
             * @example "CC"
             */
            'customer.type_regime_id' => ['required', 'string'],

            /**
             * Información del medio de pago
             * @array
             *
             */
            'payment_form' => ['required', 'array'],

            /**
             * Indentificacion del cliente
             * @string
             * @example 123456789
             */
            'payment_form.payment_form_id' => ['required', 'numeric', 'digits_between:6,15'],

            /**
             * Indentificacion del cliente
             * @string
             * @example 123456789
             */
            'payment_form.payment_method_id' => ['required', 'numeric', 'digits_between:6,15'],


            /**
             * Indentificacion del cliente
             * @string
             * @example 123456789
             */
            'payment_form.payment_due_date' => ['required', 'numeric', 'digits_between:6,15'],

            /**
             * Indentificacion del cliente
             * @string
             * @example 123456789
             */
            'payment_form.duration_measure' => ['required', 'numeric', 'digits_between:6,15'],


            /**
             * Información del totales de factura
             * @array
             *
             */
            'legal_monetary_totals' => ['required', 'array'],

            /**
             * → Subtotal de todas las líneas sin descuentos ni impuestos (ej: suma de cantidad × valor unitario de cada ítem)
             * @string
             * @example 60000.00
             */
            'legal_monetary_totals.line_extension_amount' => ['required', 'numeric', 'digits_between:1,18'],


            /**
             * → Subtotal después de restar descuentos, pero antes de impuestos. Generalmente, si no hay descuentos, es igual a line_extension_amount.
             * @string
             * @example 60000.00
             */
            'legal_monetary_totals.tax_exclusive_amount' => ['required', 'numeric', 'digits_between:1,18'],

            /**
             *  → Total después de sumar los impuestos.
             * @string
             * @example 60000.00
             */
            'legal_monetary_totals.tax_inclusive_amount' => ['required', 'numeric', 'digits_between:1,18'],

            /**
             * → Total de descuentos aplicados.
             * @string
             * @example 0
             */
            'legal_monetary_totals.allowance_total_amount' => ['required', 'numeric', 'digits_between:1,18'],

            /**
             * → Total final a pagar (con impuestos y descuentos aplicados).
             * @string
             * @example 60000.00
             */
            'legal_monetary_totals.payable_amount' => ['required', 'numeric', 'digits_between:1,18'],

            /**
             * Totales de impuestos
             * 
             * @var array
             */
            'tax_totals' => ['required', 'array'],

            /**
             * → Id Iva tabla impuestos.
             * @string
             * @example 1
             */
            'tax_totals.*.tax_id' => ['required', 'numeric', 'digits_between:1,18'],

            /**
             * → Valor del iva .
             * @string
             * @example 100000
             */
            'tax_totals.*.tax_amount' => ['required', 'numeric', 'digits_between:1,18'],

            /**
             * → Porcentaje de iva .
             * @string
             * @example 19
             */
            'tax_totals.*.percent' => ['required', 'numeric', 'digits_between:1,18'],

            /**
             * → Valor base de iva.
             * @string
             * @example 100000
             */
            'tax_totals.*.taxable_amount' => ['required', 'numeric', 'digits_between:1,18'],

            /**
             * Líneas de la factura.
             *
             * @var array
             */
            'invoice_lines' => ['required', 'array'],

            /**
             * Unidad de medida (ID según catálogo DIAN).
             *
             * @var int
             * @example 70
             */
            'invoice_lines.*.unit_measure_id' => ['required', 'integer'],

            /**
             * Cantidad facturada.
             *
             * @var string
             * @example "1"
             */
            'invoice_lines.*.invoiced_quantity' => ['required', 'numeric'],

            /**
             * Subtotal de la línea (sin impuestos).
             *
             * @var string
             * @example "840336.134"
             */
            'invoice_lines.*.line_extension_amount' => ['required', 'numeric'],

            /**
             * Indicador de producto gratuito.
             *
             * @var bool
             * @example false
             */
            'invoice_lines.*.free_of_charge_indicator' => ['required', 'boolean'],

            /**
             * Totales de impuestos por línea.
             *
             * @var array
             */
            'invoice_lines.*.tax_totals' => ['required', 'array'],

            /**
             * → Id IVA según tabla de impuestos.
             *
             * @var int
             * @example 1
             */
            'invoice_lines.*.tax_totals.*.tax_id' => ['required', 'numeric', 'digits_between:1,18'],

            /**
             * Valor del impuesto.
             *
             * @var string
             * @example "159663.865"
             */
            'invoice_lines.*.tax_totals.*.tax_amount' => ['required', 'numeric'],

            /**
             * Base gravable del impuesto.
             *
             * @var string
             * @example "840336.134"
             */
            'invoice_lines.*.tax_totals.*.taxable_amount' => ['required', 'numeric'],

            /**
             * Porcentaje de impuesto.
             *
             * @var string
             * @example "19.00"
             */
            'invoice_lines.*.tax_totals.*.percent' => ['required', 'numeric'],

            /**
             * Descripción del ítem.
             *
             * @var string
             * @example "COMISION POR SERVICIOS"
             */
            'invoice_lines.*.description' => ['required', 'string', 'max:191'],

            /**
             * Notas adicionales de la línea.
             *
             * @var string
             * @example "ESTA ES UNA PRUEBA DE NOTA DE DETALLE DE LINEA."
             */
            'invoice_lines.*.notes' => ['nullable', 'string', 'max:500'],

            /**
             * Código interno del producto o servicio.
             *
             * @var string
             * @example "COMISION"
             */
            'invoice_lines.*.code' => ['required', 'string', 'max:50'],

            /**
             * Tipo de identificación del ítem (según catálogo DIAN).
             *
             * @var int
             * @example 4
             */
            'invoice_lines.*.type_item_identification_id' => ['required', 'integer'],

            /**
             * Precio unitario.
             *
             * @var string
             * @example "1000000.00"
             */
            'invoice_lines.*.price_amount' => ['required', 'numeric'],

            /**
             * Cantidad base para el cálculo del precio.
             *
             * @var string
             * @example "1"
             */
            'invoice_lines.*.base_quantity' => ['required', 'numeric'],



        ];
    }
}
