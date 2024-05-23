<?php

namespace App\Http\Controllers;

use App\Models\AgentTraining;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Training;
use Illuminate\Support\Facades\Artisan;


class AgentTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $trainingId = $request->query('training_id');
        $agentId = $request->query('agent_id');

        if ($trainingId) {
            $agentTraining = AgentTraining::where('training_id', $trainingId)->get();
        } elseif ($agentId) {
            $agentTraining = AgentTraining::where('agent_id', $agentId)->get();
        } else {
            $agentTraining = AgentTraining::all();
        }

        return response()->json([
            'agent_training' => $agentTraining,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'training_id' => 'required|exists:trainings,id',
            'date_from' => 'required|date',
            'date_to' => 'required|date',
        ]);

        AgentTraining::create([
            'agent_id' => $request->agent_id,
            'training_id' => $request->training_id,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ]);

        return response()->json(['message' => 'Agent assigned to training successfully'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AgentTraining  $agentTraining
     * @return \Illuminate\Http\Response
     */
    public function show(AgentTraining $agentTraining)
    {
        //
        return response()->json([
            'agent-training' => $agentTraining
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AgentTraining  $agentTraining
     * @return \Illuminate\Http\Response
     */
    public function edit(AgentTraining $agentTraining)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AgentTraining  $agentTraining
     * @return \Illuminate\Http\Response
     */

    //


    public function updateExpiredStatus()
    {
        // Execute the console command
        Artisan::call('update:expired-status');

        // Optionally, return a response
        return response()->json(['message' => 'Expired status updated successfully']);
    }

    // public function update()
    // {
    //     // Get all agent trainings
    //     $agentTrainings = AgentTraining::all();

    //     // Get current date
    //     $currentDate = Carbon::now();

    //     // Loop through each agent training
    //     foreach ($agentTrainings as $training) {
    //         // Fetch the corresponding training details
    //         $trainingDetails = Training::find($training->training_id);

    //         // Calculate the duration of the training (in days)
    //         $durationInDays = $this->calculateDurationInDays($trainingDetails->duration, $trainingDetails->duration_unit);

    //         // Calculate the expiration date by adding the duration to the date_to
    //         $expirationDate = Carbon::parse($training->date_to)->addDays($durationInDays);

    //         // Check if the training has expired
    //         if ($currentDate->greaterThan($expirationDate)) {
    //             // Update the 'expired' column to 1
    //             $training->update(['expired' => 1]);
    //         } else {
    //             // Update the 'expired' column to 0
    //             $training->update(['expired' => 0]);
    //         }
    //     }

    //     // Optionally, you can return a response indicating the status of the operation
    //     return response()->json(['message' => 'Expired status updated successfully']);
    // }

    // // Helper function to calculate the duration in days
    // private function calculateDurationInDays($duration, $durationUnit)
    // {
    //     switch ($durationUnit) {
    //         case 'year':
    //             return $duration * 365; // Assuming 1 year = 365 days
    //         case 'month':
    //             return $duration * 30; // Approximate 1 month = 30 days
    //         case 'day':
    //             return $duration; // Duration is already in days
    //         default:
    //             return 0; // Invalid duration unit
    //     }
    // }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AgentTraining  $agentTraining
     * @return \Illuminate\Http\Response
     */
    public function destroy(AgentTraining $agentTraining)
    {
        //
    }
}
