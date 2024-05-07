<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TrainingController extends Controller
{
    public function index()
    {
        $trainings = Training::select('id', 'name', 'duration', 'category')->get();

        return response()->json([
            'trainings' => $trainings,
        ]);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required',
        //     'duration' => 'required',
        //     'category' => 'required',
        // ]);
        Training::create($request->post());
        return response()->json([
            'message' => 'Training created successfully'
        ]);
    }

    public function show(Training $training)
    {
        return response()->json([
            'training' => $training
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required',
                'duration' => 'required',
                'category' => 'required',
            ]);

            $training = Training::find($id);

            if (!$training) {
                return response()->json([
                    'error' => 'Training not found'
                ], 404);
            }

            $training->name = $request->input('name');
            $training->duration = $request->input('duration');
            $training->category = $request->input('category');
            $training->save();

            return response()->json([
                'message' => 'Training updated successfully'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()->first()], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while updating the training'
            ], 500);
        }
    }

    public function destroy(Training $training)
    {
        $training->delete();

        return response()->json([
            'message' => 'Training deleted successfully'
        ]);
    }
}
