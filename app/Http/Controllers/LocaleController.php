<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function switch(Request $request, string $locale): RedirectResponse
    {
        $allowedLocales = ['en', 'zh_CN'];

        if (in_array($locale, $allowedLocales, true)) {
            $request->session()->put('locale', $locale);
        }

        return redirect()->back();
    }
}