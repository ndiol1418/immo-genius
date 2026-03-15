<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AnnonceFront;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class DashboardController extends Controller
{
    //
    public function index(){
        $is_admin = false;
        return view('home', compact('is_admin'));
    }

}
