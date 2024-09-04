<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class GroupController extends Controller
{
    public function groups(Request $request) {

        $context = [];

        return Inertia::render('Group/Groups', $context);
    }
}
