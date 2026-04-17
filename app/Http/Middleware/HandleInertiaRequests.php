<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */

    //Function dipanggil setiap request
    //Data di sini tersedia di semua komponen Vue via usePage().props
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),

            //Data Auth dikirim ke semua halaman vue
            'auth' => [
                'user' => Auth::check() ? [
                    'id' => Auth::id(),
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'role' => Auth::user()->role,
                    'avatar' => Auth::user()->avatar,
                ] : null,
            ],

            //Flash message dikirim sekali setelah redirect
            'flash' => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error')
            ],
        ];
    }
}
