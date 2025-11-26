<?php

namespace App\Http\Controllers;

use App\Models\Costume;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    

    public function loginShow(Request $request)
    {
        $isAdminLogin = $request->input('isAdminLogin', false);

        return view('auth.login', compact('isAdminLogin'));
    }
    public function index()
    {
        $user = Auth::user();

        // Stats
        $upcomingEvents = Event::whereDate('date', '>=', now())->count();
        $totalCostumes = Costume::count();
        $activeMembers = User::where('status', 'active')->count();

        // Real Data
        $costumes = Costume::latest()->take(3)->get();
        $events = Event::orderBy('date', 'asc')->take(3)->get();

        if (! in_array($user->type, ['admin', 'manager'])) {

            return view('performer.dashboard', compact(
                'upcomingEvents',
                'totalCostumes',
                'activeMembers',
                'costumes',
                'events'
            ));
        }

        return view('admin.dashboard', compact(
            'upcomingEvents',
            'totalCostumes',
            'activeMembers',
            'costumes',
            'events'
        ));
    }
}
