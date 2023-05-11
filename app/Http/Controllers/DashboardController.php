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
        return view('pages.dashboard.index');
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

        // first validation
        $validator = Validator::make($request->all(), [
            'title'      => ['required'],
            'von'        => ['required'],
            'bis'        => ['required'],
        ]);

        if ($validator->fails()) {

            return redirect(route('dashboard.show', $room->id))->withErrors($validator)->withInput($request->input());;

        } else {
           // second custom validation for calendar entry not overlapping

            // conversion of input data
            $von = strtotime($data['von']);
            $bis = strtotime($data['bis']);

            // get all calender entries of today
            $calendar_entries = SogoController::getCalendarEntriesToday($room);

            foreach($calendar_entries as $entry){

                // 1 : existing entry end_time in new entry timespan
                if( (strtotime($entry['start_time']) <= $von) && (strtotime($entry['end_time']) >= $von && strtotime($entry['end_time']) >= $bis) ){

                    $validator->errors()->add('von', 'Es existiert bereits ein Eintrag zu diesem Zeitraum');
                    return back()->withErrors($validator)->withInput();
                }

                // 2 : existing entry start_time and end_time in new entry timespan
                if( (strtotime($entry['start_time']) >= $von && strtotime($entry['start_time']) <= $bis) && (strtotime($entry['end_time']) >= $bis) ){

                    $validator->errors()->add('bis', 'Es existiert bereits ein Eintrag zu diesem Zeitraum');
                    return back()->withErrors($validator)->withInput();
                }

                // 3 : existing entry start_time in new entry timespan
                if( (strtotime($entry['start_time']) <= $von) && (strtotime($entry['end_time']) >= $von) && (strtotime($entry['end_time']) <= $bis) ){

                    $validator->errors()->add('von', 'Es existiert bereits ein Eintrag in diesem Zeitraum');
                    return back()->withErrors($validator)->withInput();
                }
            }

            // store
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
    public function show($room_id)
    {
        $room = Room::find($room_id);

        // How many hours should be shown on the calendar
        $timespan = 6+14;

        // get all events of today for this room
        $room_termine = SogoController::getCalendarEntriesToday($room);

        // make array with events for frontend javascript
        $events = [];
        foreach($room_termine as $termin){

            // duration for frontend
            $duration = abs(strtotime($termin['start_time']) - strtotime($termin['end_time']))/900;  // duration in 15mins

            // pushes the data on th array
            array_push($events, [
                'title' => $termin['title'],
                'begin' => date("H:i", strtotime($termin['start_time'])),
                'end'   => date("H:i", strtotime($termin['end_time'])),
                'duration' => $duration,
            ]);
        }

        // return Values
        // Returns the View with all the needed data
        return view('pages.dashboard.show', [
            'room'     => $room,
            'timespan' => $timespan,
            'events'  => $events,
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
