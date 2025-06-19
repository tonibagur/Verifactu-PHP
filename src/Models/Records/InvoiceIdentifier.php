<?php
namespace Verifactu\Models\Records;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Identificador de factura
 */
class InvoiceIdentifier {
    /**
     * Número de identificación fiscal (NIF) del obligado a expedir la factura
     * @field IDFactura/IDEmisorFactura
     */
    #[Assert\NotBlank]
    #[Assert\Length(exactly: 9)]
    public string $issuerId;

    /**
     * Nº Serie + Nº Factura que identifica a la factura emitida
     * @field IDFactura/NumSerieFactura
     */
    #[Assert\NotBlank]
    #[Assert\Length(max: 60)]
    public string $invoiceNumber;

    /**
     * Fecha de expedición de la factura
     *
     * NOTE: Will ignore the time.
     *
     * @field IDFactura/FechaExpedicionFactura
     */
    #[Assert\NotBlank]
    public DateTimeImmutable $issueDate;
}
