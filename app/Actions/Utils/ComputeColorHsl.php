<?php

declare(strict_types=1);

namespace App\Actions\Utils;

/**
 * Compute HSL values from a 6-char hex color string
 *
 * Delegates RGB conversion and hue calculation entirely to DoColorsMatch
 * and applies the same red2 wrapping logic to guarantee zero divergence.
 */
final class ComputeColorHsl
{
    public function __construct(private readonly DoColorsMatch $doColorsMatch = new DoColorsMatch) {}

    /**
     * @param  string|null  $hex  A 6-character hex color string (e.g. "FF5733"), without leading "#"
     * @return array{hue: int, saturation: int, lightness: int}|null Returns null on invalid input
     */
    public function __invoke(?string $hex): ?array
    {
        if ($hex === null || $hex === '') {
            return null;
        }

        if (! preg_match('/^[0-9A-Fa-f]{6}$/', $hex)) {
            return null;
        }

        $rgb = $this->doColorsMatch->hexToRgb($hex);
        $hsl = $this->doColorsMatch->getHue($rgb);

        // If hue + red2 range width wraps past 360, fold it back into 'red' —
        // mirrors the same wrapping logic used inside DoColorsMatch.
        $red2Range = $this->doColorsMatch->colorsSize['red2'];
        $rangeWidth = $red2Range[1] - $red2Range[0];
        $hue = (int) $hsl[0];
        if ($hue + $rangeWidth >= 360) {
            $hue = $hue + $rangeWidth - 360;
        }

        return [
            'hue' => $hue,
            'saturation' => (int) $hsl[1],
            'lightness' => (int) $hsl[2],
        ];
    }
}
