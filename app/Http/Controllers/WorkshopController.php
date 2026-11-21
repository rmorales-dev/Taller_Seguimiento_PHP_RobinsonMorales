<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkshopController extends Controller
{
    /**
     * Main dashboard view for the workshop.
     */
    public function index()
    {
        return view('workshop.index');
    }
}
