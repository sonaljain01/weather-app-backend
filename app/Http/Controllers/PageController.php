<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\cache;

class PageController extends Controller
{
    Cache::put('user','sonal');
    public function index(){
        dd(
            Cache::get('user')
        );
        return view('index')
    }
}
