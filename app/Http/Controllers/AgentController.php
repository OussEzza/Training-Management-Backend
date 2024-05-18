<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'email' => ['required', 'email', Rule::unique('agents')],
            'service' => 'required',
            'function' => 'required',
        ]);

        $existingAgent = Agent::where('email', $request->email)->first();
        if ($existingAgent) {
            return response()->json([
                'error' => 'Email already exists in the database'
            ], 400);
        }

        Agent::create([
            'name' => $request->name,
            'email' => $request->email,
            'service' => $request->service,
            'function' => $request->function,
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
            'email' => ['required', 'email', Rule::unique('agents')->ignore($id)],
            'service' => 'required',
            'function' => 'required',
        ]);

        $agent = Agent::findOrFail($id);

        $agent->update([
            'name' => $request->name,
            'email' => $request->email,
            'service' => $request->service,
            'function' => $request->function,
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
