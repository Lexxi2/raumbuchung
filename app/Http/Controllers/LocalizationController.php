<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

class LocalizationController extends Controller
{
    public function change(Request $request, $locale)
    {
        // Sets the 'locale' variable in the Application to the given one
        App::setLocale($locale);

        // saves the language in the session
        session()->put('locale', $locale);

        // redirect back
        return redirect()->back();
    }
}
