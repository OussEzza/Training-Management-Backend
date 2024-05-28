<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AgentTraining;
use App\Models\Training;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\TrainingExpiredMail;

class CheckExpiredTrainings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:expired-trainings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for expired trainings and send notifications to agents';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get today's date
        $today = Carbon::now();

        // Get all agent-training records
        $agentTrainings = AgentTraining::with('agent', 'training')->get();

        // Loop through each agent-training record
        foreach ($agentTrainings as $agentTraining) {
            // Use the date_to field to calculate the expiry date based on training's duration
            $training = $agentTraining->training;
            $dateTo = Carbon::parse($agentTraining->date_to);

            // Calculate the duration in days based on the training's duration and unit
            $durationInDays = 0;
            if ($training->duration_unit === 'year') {
                $durationInDays = $training->duration * 365; // Assuming 1 year = 365 days
            } elseif ($training->duration_unit === 'month') {
                $durationInDays = $training->duration * 30; // Approximate months to days
            } elseif ($training->duration_unit === 'day') {
                $durationInDays = $training->duration;
            }

            // Calculate the expiry date
            $expiryDate = $dateTo->addDays($durationInDays);

            // Check if the current date is greater than the expiry date
            if ($today->greaterThan($expiryDate)) {
                // The training has expired, send email notification to the agent
                $agent = $agentTraining->agent;

                Mail::to($agent->email)->send(new TrainingExpiredMail($agent, $training));

                // Update the agent-training record to mark it as expired
                $agentTraining->update(['expired' => true]);

                $this->info("Notification sent to {$agent->email} for expired training {$training->name} scheduled for {$agentTraining->date_from} to {$agentTraining->date_to}");
            }
        }

        $this->info('Expired trainings checked and email notifications sent successfully.');
    }
}
