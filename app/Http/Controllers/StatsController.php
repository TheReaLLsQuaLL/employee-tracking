<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeLog;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index()
    {
        try {
            $totalHours = EmployeeLog::sum(DB::raw('TIMESTAMPDIFF(HOUR, start, end)'));

            $dailyHours = EmployeeLog::select(DB::raw('DATE(start) as date'), DB::raw('SUM(TIMESTAMPDIFF(HOUR, start, end)) as total_hours'))
                ->groupBy(DB::raw('DATE(start)'))
                ->get();

            $mostWorkedProject = EmployeeLog::select('projects_id', DB::raw('SUM(TIMESTAMPDIFF(HOUR, start, end)) as total_hours'))
                ->groupBy('projects_id')
                ->orderBy('total_hours', 'desc')
                ->first();

            $mostActiveEmployee = EmployeeLog::select('users_id', DB::raw('SUM(TIMESTAMPDIFF(HOUR, start, end)) as total_hours'))
                ->groupBy('users_id')
                ->orderBy('total_hours', 'desc')
                ->first();

            return view('dashboard.stats.index', compact('totalHours', 'dailyHours', 'mostWorkedProject', 'mostActiveEmployee'));
        } catch (\Exception $e) {
            // Handle the error gracefully, possibly log the error and return an error message
            return redirect()->route('dashboard.stats.index')->withErrors('Error fetching statistics.');
        }
    }

}
