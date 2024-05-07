<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index()
    {
        $agents = Agent::all();

        return response()->json([
            'agents' => $agents,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'service' => 'required',
            'function' => 'required',
            // 'department' => 'required',
        ]);

        Agent::create([
            'name' => $request->name,
            'service' => $request->service,
            'function' => $request->function,
            // 'department' => $request->department,
        ]);

        return response()->json([
            'message' => 'Agent created successfully'
        ]);
    }


    public function show(Agent $agent)
    {
        //
        return response()->json([
            'agent' => $agent
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'service' => 'required',
            'function' => 'required',
            // 'department' => 'required',
        ]);

        $agent = Agent::findOrFail($id);

        $agent->update([
            'name' => $request->name,
            'service' => $request->service,
            'function' => $request->function,
            // 'department' => $request->department,
        ]);

        return response()->json([
            'message' => 'Agent updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $agent = Agent::findOrFail($id);
        $agent->delete();

        return response()->json([
            'message' => 'Agent deleted successfully'
        ]);
    }
}
