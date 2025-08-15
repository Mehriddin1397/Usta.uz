<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Change the application language.
     */
    public function change(Request $request, $locale)
    {
        // Get available locales from config
        $availableLocales = array_keys(config('app.available_locales'));
        
        // Check if the requested locale is available
        if (in_array($locale, $availableLocales)) {
            Session::put('locale', $locale);
        }

        return redirect()->back();
    }
}
