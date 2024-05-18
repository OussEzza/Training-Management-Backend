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
        // Get all agent-training records
        $agentTrainings = AgentTraining::with('agent', 'training')->get();

        // Loop through each agent-training record
        foreach ($agentTrainings as $agentTraining) {
            // Calculate the expiry date based on the training's duration
            $trainingDate = $agentTraining->date;
            $trainingDuration = $agentTraining->training->duration;
            $expiryDate = Carbon::parse($trainingDate)->addYears($trainingDuration);

            // Check if the expiry date is before the current date
            if (Carbon::now()->greaterThan($expiryDate)) {
                // The training has expired, send email notification to the agent
                $agent = $agentTraining->agent;
                $training = $agentTraining->training;

                Mail::to($agent->email)->send(new TrainingExpiredMail($agent, $training));

                // Update the agent-training record to mark it as expired
                // Here, you can either use a specific property or directly update the record
                $agentTraining->update(['expired' => true]);
            }
        }

        $this->info('Expired trainings checked and email notifications sent successfully.');
    }
}
