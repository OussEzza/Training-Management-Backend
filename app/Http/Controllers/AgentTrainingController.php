<?php

namespace App\Http\Controllers;

use App\Models\AgentTraining;
use Illuminate\Http\Request;

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
            'date' => 'required|date',
        ]);

        AgentTraining::create([
            'agent_id' => $request->agent_id,
            'training_id' => $request->training_id,
            'date' => $request->date,
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
    public function update(Request $request, AgentTraining $agentTraining)
    {
        //
    }

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
