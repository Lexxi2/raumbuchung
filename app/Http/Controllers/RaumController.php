<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\SogoController;
use App\Models\User;
use Illuminate\Http\Request;

class RaumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $raum_all = User::all();
        $all_rooms = [];

        foreach($raum_all as $raum) {
            // ddd($raum->username);
            $raum_cal = SogoController::getRoomCalendar($raum);
            array_push($all_rooms, [
                'attributes' => $raum,
                'calendar'   => $raum_cal['personal'],
            ]);
            
        }
        
        return view('pages.raum.index', [
            'rooms' => $all_rooms,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
