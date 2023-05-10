<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use Sabre\VObject\Reader;
use SimpleCalDAV\CalDAVCalendar;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

use SimpleCalDAV\SimpleCalDAVClient;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use Sabre\VObject\Component\VCalendar;

class SogoController extends Controller
{
    // GET
    // https://mail.khost.ch/SOGo/dav/<cn>/Calendar/personal.ics

    // CREATE/UPDATE
    // https://mail.khost.ch/SOGo/dav/<cn>/Calendar/personal/<uuid>.ics 


    // create new event in SOGo Calendar
    public static function postEvent($room, $title, $start, $end)
    {
        $room = Room::find($room);

        $url = 'https://mail.khost.ch/SOGo/dav/'. $room->username .'/Calendar/personal/';

        $client = new SimpleCalDAVClient();

        $client->connect($url, $room->username, Crypt::decryptString($room->password));

        $arrayOfCalendars = $client->findCalendars();

        $client->setCalendar($arrayOfCalendars["personal"]);

        // VCalendar Object
        $vcalendar = new VCalendar([
            'VEVENT' => [
                'SUMMARY' => $title,
                'DTSTART' => new \DateTime($start),
                'DTEND'   => new \DateTime($end)
            ]
        ]);

        $client->create($vcalendar->serialize());
    }


    public static function getCalendarEntriesToday($room)
    {
        // today and tomorrow for sorting of entries
        $today = strtotime(today());
        $tomorrow =  strtotime("tomorrow"); // $tomorrow =  date("Y-m-d H:i:s", strtotime("tomorrow"));

        $request = HTTP::withBasicAuth($room->username, Crypt::decryptString($room->password))->get('https://mail.khost.ch/SOGo/dav/'. $room->username .'/Calendar/personal.ics');
    
        $vCalendar = Reader::read($request->body());
    
        // Convert Calendar to Laravel Collection
        $data = [];
    
        foreach ($vCalendar->VEVENT as $event) {

            // only get events of today
            if( ( strtotime($event->DTSTART) >= $today ) && ( strtotime($event->DTEND) <= $tomorrow )){

                 // Handle attendee
                if($event->ATTENDEE) {
                    $attendees = [];
                    foreach($event->ATTENDEE as $attendee) {
                        $attendees[] = (string) $attendee;
                    }
                }
        
                // put data into collection
                $data[] = [
                    'title'       => (string) $event->SUMMARY,
                    'description' => (string) $event->DESCRIPTION,
                    'attendee'    => $attendees ?? null,
                    'start_time'  => Carbon::parse((string) $event->DTSTART),
                    'end_time'    => Carbon::parse((string) $event->DTEND),
                ];
            }         
        }
    
        $collection = collect($data);

        return $collection;
    }


    // all entries not sorted or filtered
    public static function getCalendarEntries($room)
    {
        // ddd($room);
        $request = HTTP::withBasicAuth($room->username, Crypt::decryptString($room->password))->get('https://mail.khost.ch/SOGo/dav/'. $room->username .'/Calendar/personal.ics');

        // ddd($request->body());
    
        $vCalendar = Reader::read($request->body());
    
        // ddd($vCalendar);
    
        // Convert Calendar to Laravel Collection
        $data = [];
    
        foreach ($vCalendar->VEVENT as $event) {
    
            // Handle attendee
            if($event->ATTENDEE) {
                $attendees = [];
    
                foreach($event->ATTENDEE as $attendee) {
                    $attendees[] = (string) $attendee;
                }
            }
    
            $data[] = [
                'title'       => (string) $event->SUMMARY,
                'description' => (string) $event->DESCRIPTION,
                'attendee'    => $attendees ?? null,
                'start_time'  => Carbon::parse((string) $event->DTSTART),
                'end_time'    => Carbon::parse((string) $event->DTEND),
            ];
        }
    
        $collection = collect($data);
    
        ddd($collection);
    
        return $collection;
    }



    // for testing 
    public static function test($username) 
    {
        // get the password from the database
        // $room = Room::all()->firstOrFail(function($value, $key) use ($username) {
        //     return $value["username"] === $username;
        // });

        $pass = '";H*rGF/B5BBA~}v9+';

        $url = 'https://mail.khost.ch/SOGo/dav/' . 'mail_meetingroom2'. '/Calendar/personal';

        // $client1 = new CalDAVCalendar('https://mail.khost.ch/SOGo/dav/' . $username . '/Calendar/personal' . $user->email . '.ics', $username, $user->password);
        // $data = $client1->getRBGcolor();
        // ddd($data);

        $client = new SimpleCalDAVClient();
    
        $client->connect($url, 'mail_meetingroom2', $pass);
    
        $arrayOfCalendars = $client->findCalendars();

        ddd($arrayOfCalendars);      
        
    }
    
}