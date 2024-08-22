<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class FeedController extends Controller
{
    public function index() {
        $context = [];

        return Inertia::render('Feed/Index', $context);
    }
}
