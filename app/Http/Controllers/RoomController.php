<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\SogoController;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.room.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.room.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        // Validation
        $rules = array(
            'name'         => 'required',
            'username'     => 'required|unique:rooms',
            'email'        => 'required|unique:rooms',
            'password'     => 'required',
            'color'        => 'required',
        );
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {

            return redirect(route('room.create'))->withErrors($validator)->withInput($request->input());;

        } else {
            // store
            $room = Room::create([
                'name'         => $data['name'],
                'username'     => $data['username'],
                'email'        => $data['email'],
                'password'     => $data['password'],
                'color'        => $data['color'],
                'location'     => $data['location'],
                'description'  => $data['description'],
            ]);

            // redirect
            return redirect(route('room.index'));
        }
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
    public function edit($room_id)
    {
        $room = Room::findOrFail($room_id);

        return view('pages.room.edit', [
            'room'   => $room,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $room = Room::findOrFail($id);

        // Validation
        $rules = array(
            'name'         => 'required',
            'username'     => 'required|unique:rooms,username,'.$room->id,
            'email'        => 'required|unique:rooms,email,'.$room->id,
            'password'     => 'required',
            'color'        => 'required',
        );
        $validator = Validator::make($data, $rules);

        // check
        if ($validator->fails()) {
            
            return redirect(route('room.edit',$room->id))->withErrors($validator)->withInput($request->input());;

        } else {
            // update
            $room->update([
                'email'        => $data['email'],
                'username'     => $data['username'],
                'name'         => $data['name'],
                'location'     => $data['location'],
                'color'        => $data['color'],
                'password'     => Crypt::encryptString($data['password']),
                'description'  => $data['description'],

            ]);
            $room->save();

            // redirect
            return redirect(route('room.index'));
        }     
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        // redirect
        return redirect(route('room.index'))->with('success', 'Room deleted');
    }
}
