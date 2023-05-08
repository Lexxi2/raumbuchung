<?php

namespace App\Http\Controllers;


use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\SogoController;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all_rooms = Room::all();

        return view('pages.dashboard.index', [
            'all_rooms'    => $all_rooms,
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
        $data = $request->all();

        $room = Room::find($data['room']);

        // ddd($data);
        // ddd( date("Y-m-d H:i:s", strtotime($data['von']) ) );

        $validator = Validator::make($request->all(), [
            'title'      => ['required'],
            'von'        => ['required'],
            'bis'        => ['required'],
        ]);


        if ($validator->fails()) {

            return redirect(route('dashboard.show', $room->id))->withErrors($validator)->withInput($request->input());;

        } else {

            // custom validation for calendar entry not overlapping

            // conversion of input data
            $von = strtotime($data['von']);
            $bis = strtotime($data['bis']);

            // get all calender entries of today
            $calendar_entries = SogoController::getCalendarEntriesToday($room);
            // ddd($calendar_entries);

            foreach($calendar_entries as $entry){

                // 1 : existing entry end_time in new entry timespan
                if( (strtotime($entry['start_time']) <= $von) && (strtotime($entry['end_time']) >= $von && strtotime($entry['end_time']) >= $bis) ){

                    $validator->errors()->add('von', 'Es existiert bereits ein Eintrag zu dieser von-Zeit');
                    return back()->withErrors($validator)->withInput();
                }

                // 2 : existing entry start_time and end_time in new entry timespan
                if( (strtotime($entry['start_time']) >= $von) && (strtotime($entry['end_time']) <= $bis) ){

                    $validator->errors()->add('von', 'Es existiert bereits ein Eintrag in diesem Zeitraum');
                    return back()->withErrors($validator)->withInput();
                }

                // 3 : existing entry start_time in new entry timespan
                if( (strtotime($entry['start_time']) >= $von && strtotime($entry['start_time']) <= $bis) && (strtotime($entry['end_time']) >= $bis) ){

                    $validator->errors()->add('bis', 'Es existiert bereits ein Eintrag zu dieser bis-Zeit');
                    return back()->withErrors($validator)->withInput();
                }
            }


            // store
            // ddd($data);
            // ddd( date("Y-m-d H:i:s",strtotime($data['von']) ) );

            $title = $data['title'];
            $start = date("Y-m-d H:i:s", strtotime($data['von']));
            $end = date("Y-m-d H:i:s", strtotime($data['bis']));

            $data = SogoController::postEvent($room->id, $title, $start, $end);

            // redirect
            return redirect(route('dashboard.show', $room->id));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($room)
    {
        $room = Room::find($room);
        // ddd($room);

        $all_rooms = Room::all();
        $timespan = 6+14;

        $room_termine = SogoController::getCalendarEntriesToday($room);

        // ddd($room_termine);

        return view('pages.dashboard.show', [
            'room'     => $room,
            'all_rooms' => $all_rooms,
            'timespan' => $timespan,
        ]);
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
