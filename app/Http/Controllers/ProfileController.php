<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    //method show
    public function show(Request $request): Response
    {
        return Inertia::render('Profile', [
            'user' => [
                'name' => $request->user()->name,
                'email' => $request->user()->email,
                'role' => $request->user()->role,
                //kita ubah formatnya jadi day Fullmonth Year
                'joined_at' => $request->user()->created_at->format('d F Y'),
            ]
        ]);
    }
}
