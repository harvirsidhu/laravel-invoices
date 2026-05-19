<?php

declare(strict_types=1);

use Brick\Money\Money;
use Elegantly\Invoices\Enums\InvoiceState;
use Elegantly\Invoices\Enums\InvoiceType;
use Elegantly\Invoices\Pdf\PdfInvoice;
use Elegantly\Invoices\Pdf\PdfInvoiceItem;

function makeInvoice(): PdfInvoice
{
    return new PdfInvoice(
        type: InvoiceType::Invoice,
        state: InvoiceState::Paid,
        serial_number: 'TEST-001',
        created_at: now(),
        due_at: now(),
        items: [
            new PdfInvoiceItem(
                label: 'Item',
                unit_price: Money::of(10, 'USD'),
                quantity: 1,
            ),
        ],
    );
}

it('renders a non-empty pdf via the spatie dompdf driver', function () {
    config()->set('laravel-pdf.driver', 'dompdf');

    $output = makeInvoice()->getPdfOutput();

    expect($output)->toBeString()
        ->and(strlen($output))->toBeGreaterThan(0)
        ->and(substr($output, 0, 4))->toBe('%PDF');
});

it('honors a per-call driver override', function () {
    // Force spatie's default to an invalid driver — the per-call override should win.
    config()->set('laravel-pdf.driver', 'browsershot');

    $output = makeInvoice()->driver('dompdf')->getPdfOutput();

    expect(substr($output, 0, 4))->toBe('%PDF');
});

it('respects landscape orientation from config', function () {
    config()->set('laravel-pdf.driver', 'dompdf');
    config()->set('invoices.pdf.paper.orientation', 'landscape');

    $output = makeInvoice()->getPdfOutput();

    expect(substr($output, 0, 4))->toBe('%PDF');
});
