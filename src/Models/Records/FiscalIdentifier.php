<?php
namespace Verifactu\Models\Records;

use Symfony\Component\Validator\Constraints as Assert;
use Verifactu\Models\Model;

/**
 * Identificador fiscal
 *
 * @field Caberecera/ObligadoEmision
 * @field Caberecera/Representante
 */
class FiscalIdentifier extends Model {
    /**
     * Nombre-razón social
     *
     * @field NombreRazon
     */
    #[Assert\NotBlank]
    #[Assert\Length(max: 120)]
    public string $name;

    /**
     * Número de identificación fiscal (NIF)
     *
     * @field NIF
     */
    #[Assert\NotBlank]
    #[Assert\Length(exactly: 9)]
    public string $nif;
}
