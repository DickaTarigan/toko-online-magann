<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    //
    public function index(): Response
    {
        return Inertia::render('Seller/Dashboard', [
            'stats' => [
                'totalProduk' => 0, //nanti kita isi
                'totalPesanan' => 0,
                'totalPendapatan' => 0,
            ]
        ]);
    }
}
