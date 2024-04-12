<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Flight;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Flight $flight, Request $request)
    {
        try {
            $flights = Flight::when($request->has('name'), function ($query) use ($request) {
                    $flightName = $request->input('name');
                    $query->where('name', 'like', "%$flightName%");
                })->get();

            return response()->json($flights);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $flightdata = $request->validate([
                'name' => 'required|string',
                'international' => 'required|boolean',
                'image' => 'required|image'
            ]);

            $flight = new Flight;
            $flight->name = $request->name;
            $flight->international = $request->international;

            $imagename = Str::uuid().'.'.$request->image->getClientOriginalExtension();
            $storedImage = $request->image->storeAs('', $imagename, 'public');

            if (!$storedImage) {
                return response()->json(['error' => 'Failed to upload image'], 500);
            }

            $flight->image = $imagename;
            $flight->save();

            return response()->json(['message' => 'Flight and image stored successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }

    /**
     * Get the image URL.
     */
    public function getImage($filename, Flight $flight)
    {
        try {
            $imageUrl = asset('storage/' . $filename);
            return response()->json(['image_url' => $imageUrl]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($filename, Flight $flight)
    {
        try {
            $filePath = storage_path('app/public/' . $filename);

            if (file_exists($filePath)) {
                unlink($filePath);
            } else {
                return response()->json(['error' => 'File not found'], 404);
            }

            $flight->delete();

            return response()->json(['message' => 'Flight data and image successfully deleted']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Flight $flight)
    {
        try {
            $flightdata = $request->validate([
                'name' => 'required|string',
                'international' => 'required|boolean',
                'image' => 'required|image'
            ]);

            if ($flight->image) {
                Storage::delete($flight->image);
            }

            $flight->name = $request->name;
            $flight->international = $request->international;

            $imagename = Str::uuid().'.'.$request->image->getClientOriginalExtension();
            $storedImage = $request->image->storeAs('', $imagename, 'public');

            if (!$storedImage) {
                return response()->json(['error' => 'Failed to upload image'], 500);
            }

            $flight->image = $imagename;
            $flight->save();

            return response()->json(['message' => 'Flight and image updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }

    // Other methods (show, edit, upload) remain unchanged
}
