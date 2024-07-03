<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeLog;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index(){

        $totalHours = EmployeeLog::select(DB::raw('SUM(TIMESTAMPDIFF(HOUR, start, end)) as total_hours'))
            ->first();

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


        return view('dashboard.stats.index', compact('totalHours', 'dailyHours', 'mostWorkedProject', 'mostActiveEmployee' ));
    }
}
