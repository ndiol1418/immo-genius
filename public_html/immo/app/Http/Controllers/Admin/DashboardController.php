<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\DashboardController as ControllersDashboardController;
use App\Models\Document;
use App\Models\TypeDocument;
use App\Models\Validation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends ControllersDashboardController
{
    public function dashboard(){


        $is_admin = true;
        return view('admin.dashboard.index', compact('is_admin'));
    }


}
