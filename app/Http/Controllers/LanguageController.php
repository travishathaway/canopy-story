<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * This is a very simple controller that contains 
 * a single post method that sets the current language in
 * the session.
 */
class LanguageController extends Controller
{
    /**
     * Sets the value of the of the session variabel `lang`
     * to one of the available_locales choices
     *
     * @param $request Request
     */
    public function set(Request $request)
    {
        $lang = $request->input('lang');
        $next = $request->input('next');
        $lang_choices = config('app.available_locales');

        if( in_array(strtolower($lang), $lang_choices) ){
            session(['lang' => $lang]);
        }

        return back();
    } 
}
