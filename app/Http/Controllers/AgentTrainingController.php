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
        $perPage = $request->query('perPage', 10);

        $query = AgentTraining::query();

        if ($trainingId) {
            $query->where('training_id', $trainingId);
        } elseif ($agentId) {
            $query->where('agent_id', $agentId);
        }

        $agentTraining = $query->paginate($perPage);

        return response()->json([
            'agent_training' => $agentTraining->items(),
            'total_pages' => $agentTraining->lastPage(),
            'current_page' => $agentTraining->currentPage(),
        ]);
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
        return response()->json([
            'agent-training' => $agentTraining
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AgentTraining  $agentTraining
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AgentTraining $agentTraining)
    {
        $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'training_id' => 'required|exists:trainings,id',
            'date_from' => 'required|date',
            'date_to' => 'required|date',
        ]);

        $agentTraining->update([
            'agent_id' => $request->agent_id,
            'training_id' => $request->training_id,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ]);

        return response()->json(['message' => 'Agent training updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AgentTraining  $agentTraining
     * @return \Illuminate\Http\Response
     */
    public function destroy(AgentTraining $agentTraining)
    {
        $agentTraining->delete();
        return response()->json(['message' => 'Agent training deleted successfully']);
    }

    public function updateExpiredStatus()
    {
        // Execute the console command
        Artisan::call('update:expired-status');

        // Optionally, return a response
        return response()->json(['message' => 'Expired status updated successfully']);
    }
}
