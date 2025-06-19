<?php
namespace Verifactu\Models\Records;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Registro de alta de una factura
 * @field RegistroAlta
 */
class RegistrationRecord extends Record {
    /**
     * Nombre-razón social del obligado a expedir la factura
     * @field NombreRazonEmisor
     */
    #[Assert\NotBlank]
    #[Assert\Length(max: 120)]
    public string $issuerName;

    /**
     * Especificación del tipo de factura
     * @field TipoFactura
     */
    #[Assert\NotBlank]
    public InvoiceType $invoiceType;

    /**
     * Descripción del objeto de la factura
     * @field DescripcionOperacion
     */
    #[Assert\NotBlank]
    #[Assert\Length(max: 500)]
    public string $description;

    /**
     * Desglose de la factura
     * @var BreakdownDetails[]
     * @field Desglose
     */
    #[Assert\Valid]
    #[Assert\Count(min: 1, max: 12)]
    public array $breakdown = [];

    /**
     * Importe total de la cuota (sumatorio de la Cuota Repercutida y Cuota de Recargo de Equivalencia)
     * @field CuotaTotal
     */
    #[Assert\NotBlank]
    #[Assert\Regex(pattern: '/^-?\d{1,12}\.\d{2}$/')]
    public string $totalTaxAmount;

    /**
     * Importe total de la factura
     * @field ImporteTotal
     */
    #[Assert\NotBlank]
    #[Assert\Regex(pattern: '/^-?\d{1,12}\.\d{2}$/')]
    public string $totalAmount;

    /**
     * @inheritDoc
     */
    public function calculateHash(): string {
        // NOTE: Values should NOT be escaped as that what the AEAT says ¯\_(ツ)_/¯
        $payload  = 'IDEmisorFactura=' . $this->invoiceId->issuerId;
        $payload .= '&NumSerieFactura=' . $this->invoiceId->invoiceNumber;
        $payload .= '&FechaExpedicionFactura=' . $this->invoiceId->issueDate->format('d-m-Y');
        $payload .= '&TipoFactura=' . $this->invoiceType->value;
        $payload .= '&CuotaTotal=' . $this->totalTaxAmount;
        $payload .= '&ImporteTotal=' . $this->totalAmount;
        $payload .= '&Huella=' . ($this->previousHash ?? '');
        $payload .= '&FechaHoraHusoGenRegistro=' . $this->hashedAt->format('c');
        return strtoupper(hash('sha256', $payload));
    }
}
