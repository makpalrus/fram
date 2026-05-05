<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LocalizationController extends Controller
{
    public function index($locale) {
    if (!in_array($locale, ['en', 'kz', 'ru'])) {
        abort(404);
    }
    
    App::setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
}
}