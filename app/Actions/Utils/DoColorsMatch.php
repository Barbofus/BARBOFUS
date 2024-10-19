<?php

declare(strict_types=1);

namespace App\Actions\Utils;

/**
 * Check if two hex colors match
 *
 * First parameter is the input hex color given by the user, second one is the hex to compare to
 */
final class DoColorsMatch
{
    /**
     * @var array<string, int[]>
     */
    public $colorsSize = [
        'red' => [0, 15],
        'orange' => [12, 39],
        'yellow' => [40, 65],
        'green' => [65, 155],
        'blue' => [155, 250],
        'purple' => [250, 300],
        'pink' => [290, 345],
        'red2' => [345, 360],
    ];

    /**
     * @param  string  $inputColor  The input hex color, given by the user
     * @param  string  $colorToMatch  The hex color to compare the input with
     * @return bool
     */
    public function __invoke(string $inputColor, string $colorToMatch)
    {
        // Convert our hex color into HSL
        $inputHSL = $this->getHue($this->hexToRgb($inputColor));
        $matchHSL = $this->getHue($this->hexToRgb($colorToMatch));

        // Si le Hue + 15 (la range de red2) dépasse les 360, on compte ça dans 'red'
        $inputHSL[0] = ($inputHSL[0] + ($this->colorsSize['red2'][1] - $this->colorsSize['red2'][0]) >= 360) ? $inputHSL[0] + 15 - 360 : $inputHSL[0];
        $matchHSL[0] = ($matchHSL[0] + ($this->colorsSize['red2'][1] - $this->colorsSize['red2'][0]) >= 360) ? $matchHSL[0] + 15 - 360 : $matchHSL[0];

        // Check if the input is a grayscale
        if ($inputHSL[1] < 5) {
            // If it's a grayscale, we compare the brightness
            return $matchHSL[1] < 5 && abs($inputHSL[2] - $matchHSL[2]) <= 30;
        }

        // Check all the colors size
        foreach ($this->colorsSize as $key => $color) {
            // If both of our values are contains in the same area, they match
            if ($inputHSL[0] >= $color[0] && $inputHSL[0] <= $color[1] && $matchHSL[0] >= $color[0] && $matchHSL[0] <= $color[1] && abs($inputHSL[1] - $matchHSL[1]) < 30 && abs($inputHSL[2] - $matchHSL[2]) < 30) {
                return true;
            }
        }

        // No match
        return false;
    }

    /**
     * @return int[]
     */
    public function hexToRgb(string $hex)
    {
        $split_hex_color = str_split($hex, 2);
        $r = hexdec($split_hex_color[0]);
        $g = hexdec($split_hex_color[1]);
        $b = hexdec($split_hex_color[2]);

        return [$r, $g, $b];
    }

    /**
     * @param  int[]  $RGB
     * @return float[]
     */
    public function getHue($RGB)
    {
        // scale the RGB values to 0 to 1 (percentages)
        $r = $RGB[0] / 255;
        $g = $RGB[1] / 255;
        $b = $RGB[2] / 255;
        $max = max($r, $g, $b);
        $min = min($r, $g, $b);

        // lightness calculation. 0 to 1 value, scale to 0 to 100% at end
        $l = ($max + $min) / 2;

        // saturation calculation. Also 0 to 1, scale to percent at end.
        $d = $max - $min;

        // achromatic (grey) so hue and saturation both zero
        $h = $s = 0;

        if ($d != 0) {
            $s = $d / (1 - abs((2 * $l) - 1));
            // hue (if not grey) This is being calculated directly in degrees (0 to 360)
            switch ($max) {
                case $r:
                    $h = 60 * fmod((($g - $b) / $d), 6);
                    if ($b > $g) { //will have given a negative value for $h
                        $h += 360;
                    }
                    break;
                case $g:
                    $h = 60 * (($b - $r) / $d + 2);
                    break;
                case $b:
                    $h = 60 * (($r - $g) / $d + 4);
                    break;
            }
        }

        return [round($h), round($s * 100), round($l * 100)];
    }
}
