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
     * @return array{hue: int, saturation: int, lightness: int}|null  Returns null on invalid input
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

        // Si le Hue + 15 (la range de red2) dépasse les 360, on compte ça dans 'red'
        // Same wrapping as DoColorsMatch lines 40-41
        $hue = (int) $hsl[0];
        if ($hue + 15 >= 360) {
            $hue = $hue + 15 - 360;
        }

        return [
            'hue' => $hue,
            'saturation' => (int) $hsl[1],
            'lightness' => (int) $hsl[2],
        ];
    }
}
