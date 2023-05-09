<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

class LocalizationController extends Controller {


   public function change(Request $request, $locale)
   {
    // ddd($locale);

       App::setLocale($locale);

       session()->put('locale', $locale);

       return redirect()->back();

   }
}