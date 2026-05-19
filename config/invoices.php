<?php

declare(strict_types=1);

use Brick\Math\RoundingMode;
use Elegantly\Invoices\Enums\InvoiceType;
use Elegantly\Invoices\InvoiceDiscount;
use Elegantly\Invoices\Models\Invoice;
use Elegantly\Invoices\Models\InvoiceItem;

return [

    'model_invoice' => Invoice::class,
    'model_invoice_item' => InvoiceItem::class,

    'discount_class' => InvoiceDiscount::class,

    'cascade_invoice_delete_to_invoice_items' => true,

    'serial_number' => [
        /**
         * If true, will generate a serial number on creation
         * If false, you will have to set the serial_number yourself
         */
        'auto_generate' => true,

        /**
         * Define the serial number format used for each invoice type
         *
         * P: Prefix
         * S: Serie
         * M: Month
         * Y: Year
         * C: Count
         * Example: IN0012-220234
         * Repeat letter to set the length of each information
         * Examples of formats:
         * - PPYYCCCC : IN220123 (default)
         * - PPPYYCCCC : INV220123
         * - PPSSSS-YYCCCC : INV0001-220123
         * - SSSS-CCCC: 0001-0123
         * - YYCCCC: 220123
         */
        'format' => 'PPYYCCCC',

        /**
         * Define the default prefix used for each invoice type
         */
        'prefix' => [
            InvoiceType::Invoice->value => 'IN',
            InvoiceType::Quote->value => 'QO',
            InvoiceType::Credit->value => 'CR',
            InvoiceType::Proforma->value => 'PF',
        ],

    ],

    'date_format' => 'Y-m-d',

    'rounding_mode' => RoundingMode::HalfUp,

    'default_seller' => [
        'company' => null,
        'name' => null,
        'address' => [
            'street' => null,
            'city' => null,
            'postal_code' => null,
            'state' => null,
            'country' => null,
        ],
        'email' => null,
        'phone' => null,
        'tax_number' => null,
        'fields' => [
            //
        ],
    ],

    /**
     * ISO 4217 currency code
     */
    'default_currency' => 'USD',

    /**
     * PDF rendering is delegated to spatie/laravel-pdf.
     * The driver (dompdf, browsershot, chrome, cloudflare, gotenberg, weasyprint)
     * is selected in spatie's own config (`config/laravel-pdf.php` or LARAVEL_PDF_DRIVER env).
     *
     * Recommended for zero-system-dep installs:
     *     LARAVEL_PDF_DRIVER=dompdf
     *
     * Per-invoice override: `$invoice->toPdfInvoice()->driver('browsershot')`.
     */
    'pdf' => [

        'paper' => [
            'size' => 'a4',
            'orientation' => 'portrait',
        ],

        /**
         * The logo displayed in the PDF
         */
        'logo' => null,

        /**
         * The template used to render the PDF
         */
        'template' => 'default.layout',

        'template_data' => [
            /**
             * The color used for the PDF header/accent.
             */
            'color' => '#050038',

            /**
             * The CSS font-family name.
             *
             * Note: 'Arimo' is recommended as it provides superior symbol support
             * compared to Helvetica, while maintaining a similar aesthetic.
             */
            'font' => null,

            /**
             * List of Google Font URLs to be imported into the document.
             */
            'fonts' => [
                // 'https://fonts.googleapis.com/css2?family=Arimo:ital,wght@0,400..700;1,400..700&display=swap',
            ],
        ],

    ],

];
