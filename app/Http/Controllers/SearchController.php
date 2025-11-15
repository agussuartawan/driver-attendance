<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Receipt;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $type = $request->get('type', 'all');

        if (empty($query)) {
            return view('dashboard.search.results', [
                'query' => $query,
                'type' => $type,
                'results' => [
                    'users' => collect(),
                    'schedules' => collect(),
                    'receipts' => collect(),
                    'attendances' => collect(),
                ],
            ]);
        }

        $results = [
            'users' => collect(),
            'schedules' => collect(),
            'receipts' => collect(),
            'attendances' => collect(),
        ];

        if ($type === 'all' || $type === 'users') {
            $results['users'] = User::where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->orWhere('phone', 'like', "%{$query}%")
                    ->orWhere('vehicle', 'like', "%{$query}%");
            })
                ->with('roles')
                ->role('driver')
                ->limit(10)
                ->get();
        }

        if ($type === 'all' || $type === 'schedules') {
            $results['schedules'] = Schedule::where(function ($q) use ($query) {
                $q->where('customer_name', 'like', "%{$query}%")
                    ->orWhere('start_location', 'like', "%{$query}%")
                    ->orWhere('end_location', 'like', "%{$query}%")
                    ->orWhere('category', 'like', "%{$query}%");
            })
                ->with('driver')
                ->limit(10)
                ->get();
        }

        if ($type === 'all' || $type === 'receipts') {
            $results['receipts'] = Receipt::where(function ($q) use ($query) {
                $q->where('category', 'like', "%{$query}%")
                    ->orWhereHas('user', function ($subQ) use ($query) {
                        $subQ->where('name', 'like', "%{$query}%");
                    })
                    ->orWhereHas('schedule', function ($subQ) use ($query) {
                        $subQ->where('customer_name', 'like', "%{$query}%");
                    });
            })
                ->with(['user', 'schedule'])
                ->limit(10)
                ->get();
        }

        if ($type === 'all' || $type === 'attendances') {
            $results['attendances'] = Attendance::where(function ($q) use ($query) {
                $q->where('location', 'like', "%{$query}%")
                    ->orWhere('type', 'like', "%{$query}%")
                    ->orWhereHas('employee', function ($subQ) use ($query) {
                        $subQ->where('name', 'like', "%{$query}%");
                    })
                    ->orWhereHas('schedule', function ($subQ) use ($query) {
                        $subQ->where('customer_name', 'like', "%{$query}%");
                    });
            })
                ->with(['employee', 'schedule'])
                ->limit(10)
                ->get();
        }

        return view('dashboard.search.results', [
            'query' => $query,
            'type' => $type,
            'results' => $results,
        ]);
    }
}
