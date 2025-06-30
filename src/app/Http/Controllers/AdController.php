<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Http\Requests\StoreAdRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ads = Ad::latest()->paginate(10);
        
        // Jeśli request oczekuje JSON (API), zwróć JSON
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'data' => $ads->items(),
                'pagination' => [
                    'current_page' => $ads->currentPage(),
                    'last_page' => $ads->lastPage(),
                    'per_page' => $ads->perPage(),
                    'total' => $ads->total()
                ]
            ]);
        }
        
        // W przeciwnym razie zwróć widok
        return view('ads.index', compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdRequest $request)
    {
        $data = $request->validated();
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('ads', 'public');
            }
        }
        $data['images'] = $images;
        $ad = Ad::create($data);
        
        // Jeśli request oczekuje JSON (API), zwróć JSON
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Ogłoszenie dodane pomyślnie!',
                'data' => $ad
            ], 201);
        }
        
        return redirect()->route('ads.show', $ad)->with('success', 'Ogłoszenie dodane!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Ad $ad)
    {
        // Jeśli request oczekuje JSON (API), zwróć JSON
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['data' => $ad]);
        }
        
        return view('ads.show', compact('ad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ad $ad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ad $ad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ad $ad)
    {
        //
    }
}
