<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use SimpleCalDAV\CalDAVCalendar;
use App\Http\Controllers\Controller;
use SimpleCalDAV\SimpleCalDAVClient;

class SogoController extends Controller
{

    // GET
    // https://mail.khost.ch/SOGo/dav/<cn>/Calendar/personal.ics

    // CREATE/UPDATE
    // https://mail.khost.ch/SOGo/dav/<cn>/Calendar/personal/<uuid>.ics 

    public static function setColor($username) 
    {
        // get the password from the database
        $user = User::all()->firstOrFail(function($value, $key) use ($username) {
            return $value["username"] === $username;
        });

        $url = 'https://mail.khost.ch/SOGo/dav/' . $username . '/Calendar/personal' . $user->email . '.ics';
        $client = new CalDAVCalendar($url, $username, $user->password);

        $data = $client->setRBGcolor('50, 168, 82');
    
        
        ddd($data);
    }

    public static function test($username) 
    {
        // get the password from the database
        $user = User::all()->firstOrFail(function($value, $key) use ($username) {
            return $value["username"] === $username;
        });

        // self::setColor($username);
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

    // get all the attributes from all calendars
    public static function getRoomCalendar($username) 
    {
        // find the user to get the password from the database
        $user = User::all()->firstOrFail(function($value, $key) use ($username) {
            return $value["username"] === $username;
        });

        // ddd($user);

        // url for the room
        $url = 'https://mail.khost.ch/SOGo/dav/' . $username . '/Calendar/personal';

        // ddd($url);

        // create Client and connect
        $client = new SimpleCalDAVClient();
        $client->connect($url, $username, $user->password);

        $arrayOfCalendars = $client->findCalendars(); // Returns an array of all accessible calendars on the server. calendars as CalDAV Objects
        
        // ddd($arrayOfCalendars['personal']->getRBGcolor());
        return $arrayOfCalendars;
    }
    
}