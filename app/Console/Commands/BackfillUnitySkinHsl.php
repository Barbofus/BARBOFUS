<?php

namespace App\Console\Commands;

use App\Actions\Utils\ComputeColorHsl;
use App\Models\UnitySkin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BackfillUnitySkinHsl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'skins:backfill-hsl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backfill HSL columns for all unity skins';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Backfilling HSL columns for unity skins...');

        $computeHsl = new ComputeColorHsl;
        $processed = 0;

        $total = UnitySkin::query()->whereNull('color_cloth_1_hue')->count();

        if ($total === 0) {
            $this->info('No skins to process. All HSL columns are already filled.');

            return Command::SUCCESS;
        }

        $this->output->progressStart($total);

        UnitySkin::query()->whereNull('color_cloth_1_hue')->chunkById(500, function ($skins) use ($computeHsl, &$processed) {
            foreach ($skins as $skin) {
                $hsl1 = $computeHsl($skin->color_cloth_1);
                $hsl2 = $computeHsl($skin->color_cloth_2);
                $hsl3 = $computeHsl($skin->color_cloth_3);
                $hsl4 = $computeHsl($skin->color_cloth_4);

                DB::table('unity_skins')->where('id', $skin->id)->update([
                    'color_cloth_1_hue' => $hsl1['hue'] ?? null,
                    'color_cloth_1_saturation' => $hsl1['saturation'] ?? null,
                    'color_cloth_1_lightness' => $hsl1['lightness'] ?? null,
                    'color_cloth_2_hue' => $hsl2['hue'] ?? null,
                    'color_cloth_2_saturation' => $hsl2['saturation'] ?? null,
                    'color_cloth_2_lightness' => $hsl2['lightness'] ?? null,
                    'color_cloth_3_hue' => $hsl3['hue'] ?? null,
                    'color_cloth_3_saturation' => $hsl3['saturation'] ?? null,
                    'color_cloth_3_lightness' => $hsl3['lightness'] ?? null,
                    'color_cloth_4_hue' => $hsl4['hue'] ?? null,
                    'color_cloth_4_saturation' => $hsl4['saturation'] ?? null,
                    'color_cloth_4_lightness' => $hsl4['lightness'] ?? null,
                ]);

                $processed++;
                $this->output->progressAdvance();
            }
        });

        $this->output->progressFinish();

        $this->info("Done! {$processed} skin(s) updated with HSL values.");

        return Command::SUCCESS;
    }
}
