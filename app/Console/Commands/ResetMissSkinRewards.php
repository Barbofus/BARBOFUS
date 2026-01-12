<?php

namespace App\Console\Commands;

use App\Actions\MissSkin\ResetUserRewardChoices;
use Illuminate\Console\Command;

class ResetMissSkinRewards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'missskin:reset-rewards';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all user reward choices for the new Miss Skin contest (runs every Tuesday at 7 AM)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🏆 Resetting Miss Skin reward choices...');

        $affectedUsers = (new ResetUserRewardChoices)();

        if ($affectedUsers > 0) {
            $this->info("✅ Reset completed successfully! {$affectedUsers} user(s) affected.");
        } else {
            $this->info('✅ Reset completed! No users had selected rewards.');
        }

        return Command::SUCCESS;
    }
}
