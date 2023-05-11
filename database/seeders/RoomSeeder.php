<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // seed the SOGo Room Users with 
        // encrypted passwords
        DB::table('rooms')->insert([
            [
                'name' => 'meetingroom1', 
                'email' => 'meetingroom1@kastgroup.com',
                'password' => Crypt::encryptString('pSVa}dcm-/cHZoe9&,'),
                'username' => 'mail_meetingroom1',
                'location' => 'Wallisellen',
                'color'    => '#32a852',
            ],
            [
                'name' => 'meetingroom2', 
                'email' => 'meetingroom2@kastgroup.com',
                'password' => Crypt::encryptString('";H*rGF/B5BBA~}v9+'),
                'username' => 'mail_meetingroom2',
                'location' => 'Schaan',
                'color'    => '#fcba03',
            ],
            [
                'name' => 'meetingroom3', 
                'email' => 'meetingroom3@kastgroup.com',
                'password' => Crypt::encryptString('5"3!=%~/,Ftd,^v:@3'),
                'username' => 'mail_meetingroom3',
                'location' => '',
                'color'    => '#fc03ca',
            ],

        ]);
    }
}
