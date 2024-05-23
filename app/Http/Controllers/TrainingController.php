<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TrainingController extends Controller
{
    public function index()
    {
        $trainings = Training::all();

        return response()->json([
            'trainings' => $trainings,
        ]);
    }

    public function store(Request $request)
    {
        // $validatedData = $request->validate([
        //     'name' => 'required',
        //     'duration' => 'required',
        //     'duration_unit' => 'required',
        //     'category' => 'required',
        // ]);

        Training::create([
            'name' => $request['name'],
            'duration' => $request['duration'],
            'duration_unit' => $request['duration_unit'],
            'category' => $request['category'],
        ]);

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
                'duration_unit' => 'required',
                'category' => 'required',
            ]);

            $training = Training::find($id);

            if (!$training) {
                return response()->json([
                    'error' => 'Training not found'
                ], 404);
            }

            $training->name = $validatedData['name'];
            $training->duration = $validatedData['duration'];
            $training->duration_unit = $validatedData['duration_unit'];
            $training->category = $validatedData['category'];
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
