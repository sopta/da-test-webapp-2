<?php

declare(strict_types=1);

namespace CzechitasApp\Modules\QRPayment;

use BaconQrCode\Common\ErrorCorrectionLevel;
use BaconQrCode\Encoder\Encoder;
use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Writer;
use Illuminate\Support\Str;

class QRPayment
{
    /** @var array<string, string> */
    protected $qrCodeData = [];

    /**
     * @param string|int|null $vs
     * @param string|int|null $ks
     * @param string|int|null $ss
     */
    public function __construct(
        float $price,
        $vs = null,
        $ks = null,
        $ss = null,
        ?string $msg = null,
        ?string $bankAcc = null
    ) {
        $this->qrCodeData = \array_filter([
            'ACC'   => static::bankAccToIBAN($bankAcc ?? \config('czechitas.bank_acc')),
            'AM'    => \str_replace(' ', '', \formatPrice($price, '', true, '.')),
            'CC'    => 'CZK',
            'X-VS'  => (string)$vs,
            'X-KS'  => (string)$ks,
            'X-SS'  => (string)$ss,
            'MSG'   => $this->validateMessageText($msg),
        ]);
    }

    /**
     * Validate text to pass into QR payment
     */
    public function validateMessageText(?string $text, int $maxLength = 50): ?string
    {
        if ($text === null) {
            return null;
        }
        $text = Str::ascii(Str::upper($text), 'cs');
        $text = \str_replace(['_', ',', ':'], ' ', $text);

        $text = \preg_replace('/[^A-Z0-9_+.\- ]/', '', $text); // jiné než povolené znaky se vymažou
        $text = \preg_replace('/\s+/', ' ', $text); //jsou-li 2 a více mezer za sebou, nahradíme za jednu

        return Str::limit($text, $maxLength, '');
    }

    public function getCodeContent(string $version = '1.0'): string
    {
        $dataToJoin = [];
        foreach ($this->qrCodeData as $key => $value) {
            $dataToJoin[] = Str::upper($key) . ':' . $value;
        }

        return "SP*{$version}*" . \implode('*', $dataToJoin);
    }

    /**
     * @param array<string, mixed> $settings
     */
    public function toPngText(bool $base64 = false, array $settings = []): string
    {
        $settings = \array_merge([
            'height'          => 400,
            'width'           => 400,
            'correctionLevel' => ErrorCorrectionLevel::M,
            'encoding'        => Encoder::DEFAULT_BYTE_MODE_ECODING,
        ], $settings);

        $renderer = new Png();
        $renderer->setHeight($settings['height']);
        $renderer->setWidth($settings['width']);
        $writer = new Writer($renderer);

        $binary = $writer->writeString($this->getCodeContent(), $settings['encoding'], $settings['correctionLevel']);
        if ($base64) {
            return \base64_encode($binary);
        }

        return $binary;
    }

    public static function bankAccToIBAN(string $bankAcc): string
    {
        if (\strlen($bankAcc) === 24) {
            return $bankAcc;
        }

        $matches = [];
        if (!\preg_match('/^(?:([0-9]{1,6})-)?([0-9]{2,10})\/([0-9]{4})$/', $bankAcc, $matches)) {
            return $bankAcc;
        }

        $prefix = \str_pad($matches[1], 6, '0', \STR_PAD_LEFT);
        $main = \str_pad($matches[2], 10, '0', \STR_PAD_LEFT);
        $bankCode = $matches[3];

        $controllNumber = \str_pad(
            (string)(98 - (int)\bcmod("{$bankCode}{$prefix}{$main}123500", '97')),
            2,
            '0',
            \STR_PAD_LEFT
        );

        return "CZ{$controllNumber}{$bankCode}{$prefix}{$main}";
    }
}
