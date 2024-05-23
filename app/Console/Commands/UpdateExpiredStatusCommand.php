<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AgentTraining;
use Carbon\Carbon;
use App\Models\Training;

class UpdateExpiredStatus extends Command
{
    protected $signature = 'update:expired-status';

    protected $description = 'Update expired status for agent trainings';

    public function handle()
    {
        // Logic to update expired status
        $agentTrainings = AgentTraining::all();
        $currentDate = Carbon::now();
        foreach ($agentTrainings as $training) {
            $trainingDetails = Training::find($training->training_id);
            $durationInDays = $this->calculateDurationInDays($trainingDetails->duration, $trainingDetails->duration_unit);
            $expirationDate = Carbon::parse($training->date_to)->addDays($durationInDays);
            if ($currentDate->greaterThan($expirationDate)) {
                $training->update(['expired' => 1]);
            } else {
                $training->update(['expired' => 0]);
            }
        }
        $this->info('Expired status updated successfully.');
    }

    private function calculateDurationInDays($duration, $durationUnit)
    {
        // Logic to calculate duration in days
        switch ($durationUnit) {
            case 'year':
                return $duration * 365; // Assuming 1 year = 365 days
            case 'month':
                return $duration * 30; // Approximate 1 month = 30 days
            case 'day':
                return $duration; // Duration is already in days
            default:
                return 0; // Invalid duration unit
        }
    }
}
