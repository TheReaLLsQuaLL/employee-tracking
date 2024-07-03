<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index(){
        return view('dashboard.projects.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'start' => 'required',
            'end' => 'required',
        ]);

        if($validator->fails()) {
            return redirect()->back()->with('error', $validator);
        }
        $project =  new Project();

        $project->name = $request->name;
        $project->start = Carbon::createFromFormat('d/m/Y', $request->start)->format('Y-m-d');
        $project->end = Carbon::createFromFormat('d/m/Y', $request->end)->format('Y-m-d');;
        $project->save();

        return redirect()->route('dashboard.index')->with('project_created', 'Project successfully created.');

    }
}
