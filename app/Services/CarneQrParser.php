<?php

namespace App\Services;

/**
 * Parser de ancho fijo para el payload QR del carné de colaborador.
 *
 * Offsets confirmados contra la ÚNICA muestra real documentada en
 * specs/001-modernizacion-epp/research.md (longitud total 113). El Principio V
 * de la constitución exige validar con ≥5 muestras reales distintas antes de
 * confiar en estos offsets en producción (tarea T033, pendiente) — mientras
 * tanto, el parser SOLO acepta payloads de exactamente 113 caracteres y
 * nunca devuelve datos parciales si la longitud no calza, para no asignar
 * una entrega al colaborador equivocado.
 */
class CarneQrParser
{
    private const LONGITUD_ESPERADA = 113;

    private const CAMPOS = [
        'cedula' => [0, 10],
        'apellido1' => [10, 23],
        'apellido2' => [33, 23],
        'nombres' => [56, 46],
        'sexo' => [102, 1],
        'fecha_nacimiento' => [103, 8],
        'grupo_sanguineo_rh' => [111, 2],
    ];

    /**
     * @return array{cedula:string,apellido1:string,apellido2:string,nombres:string,sexo:string,fecha_nacimiento:string,grupo_sanguineo_rh:string}|null
     */
    public static function parse(string $payload): ?array
    {
        // El lector de cámara puede agregar un salto de línea/retorno de carro
        // al final del valor decodificado; eso no forma parte de los 113
        // caracteres fijos del payload, así que se recorta antes de validar.
        $payload = rtrim($payload, "\r\n");

        if (strlen($payload) !== self::LONGITUD_ESPERADA) {
            \Log::warning('CarneQrParser: longitud de payload inesperada', [
                'longitud_recibida' => strlen($payload),
                'longitud_esperada' => self::LONGITUD_ESPERADA,
                'payload' => $payload,
            ]);

            return null;
        }

        $datos = [];
        foreach (self::CAMPOS as $campo => [$offset, $longitud]) {
            $datos[$campo] = trim(substr($payload, $offset, $longitud));
        }

        if ($datos['cedula'] === '' || ! ctype_digit($datos['cedula'])) {
            return null;
        }

        return $datos;
    }
}
