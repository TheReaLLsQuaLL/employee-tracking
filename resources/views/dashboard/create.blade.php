@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto pb-6 sm:px-6 lg:px-8">
        <div class="px-4 sm:px-0">
            <div class="bg-white shadow-md rounded my-6">
                <div class="container mx-auto mt- 4 w-64 text-center">
                    <h1 class="text-2xl mb-4">Start New</h1>
                    <form action="{{route('dashboard.start')}}" method="POST" style="display:inline;" onsubmit="return confirmTaskStart();" class="max-w-sm mx-auto">
                        @csrf
                        <select name="projects_id" id="project" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="">Select a project</option>
                            @foreach($projects as $project)
                                @if(!in_array($project->id, $assignedProjects) && $project->end !== NULL)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endif
                            @endforeach
                        </select>

                        <select name="users_id" id="user" class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                            <option value="">Select a User</option>
                            @foreach($users as $user)
                                @if(!in_array($user->id, $assignedUsers))
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-2 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 ">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
