<?php

namespace App\Http\Controllers;

use App\Models\EmployeeLog;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WorkingHoursController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $taskList = EmployeeLog::orderBy('id', 'ASC')->with('projects')->get();
        return view('dashboard.index', ['taskList' => $taskList]);
    }
    public function create(){
        $assignedProjects = EmployeeLog::whereNotNull('projects_id')->pluck('projects_id')->toArray();
        $assignedUsers = EmployeeLog::whereNull('end')->pluck('users_id')->toArray();
        $projects = Project::all();
        $users = User::all();
        return view('dashboard.create', ['projects' => $projects, 'users' => $users, 'assignedProjects' => $assignedProjects, 'assignedUsers' => $assignedUsers]);
    }
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'users_id' => 'required|exists:users,id',
            'projects_id' => 'required|exists:projects,id',
        ]);

        try {
            $workHourLog = new EmployeeLog();
            $workHourLog->start = Carbon::now();
            $workHourLog->users_id = $request->users_id;
            $workHourLog->projects_id = $request->projects_id;
            $workHourLog->save();

            return redirect()->route('dashboard.index')->with('start', 'Task Started');
        } catch (\Exception $e) {
            return redirect()->route('dashboard.index')->withErrors('Error starting task.');
        }
    }

    public function stop(Request $request): \Illuminate\Http\RedirectResponse
    {
        $workHourLog = EmployeeLog::find($request->id);
        if (!$workHourLog) {
            return redirect()->route('dashboard.index')->withErrors('Task not found.');
        }

        try {
            $workHourLog->end = Carbon::now();
            $workHourLog->save();

            return redirect()->route('dashboard.index')->with('stop', 'Task Stopped');
        } catch (\Exception $e) {
            return redirect()->route('dashboard.index')->withErrors('Error stopping task.');
        }
    }

    public function edit($id)
    {
        $task = EmployeeLog::find($id);
        $projects = Project::all();
        $selectedProjectId = $task->projects_id;
        $assignedProjects = EmployeeLog::whereNotNull('projects_id')->pluck('projects_id')->toArray();
        $assignedUsers = EmployeeLog::whereNull('end')->pluck('users_id')->toArray();
        return view('dashboard.edit', ['task' => $task, 'projects' => $projects, 'assignedProjects' => $assignedProjects, 'selectedProjectId' => $selectedProjectId, 'assignedUsers' => $assignedUsers]);
    }
    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $workHourLog = EmployeeLog::find($id);
        // assign to variable current "start" column to convert into hours and split
        $startDateTime = Carbon::parse($workHourLog->start);
        // split the hour and minute from the request
        list($hour, $minute) = explode(':', $request->update);
        // update the hour and minute
        $startDateTime->setTime($hour, $minute);

        $workHourLog->start = $startDateTime;
        $workHourLog->projects_id = $request->projects_id;
        $workHourLog->save();

        return redirect()->route('dashboard.index')->with('update', 'Task Successfully Updated');
    }
    public function destroy(Request $request){
        $workHourLog = EmployeeLog::find($request->id);
        $workHourLog->delete();
        return redirect()->route('dashboard.index')->with('delete', 'Task Successfully Deleted');
    }
}
