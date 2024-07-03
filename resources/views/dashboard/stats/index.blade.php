@extends('layouts.app')

@section('content')

    <div class="max-w-7xl mx-auto pb-6 sm:px-6 lg:px-8 text-center">
        <div class="px-4 sm:px-0">
            <div class="bg-white shadow-md rounded my-6">
                <h2 class="font-bold">Total Work Hours</h2>
                <ul>
                    <p>{{ $totalHours->total_hours ?? "No data available" }} @if(!$totalHours) hours @endif </p>
                </ul>
                <hr>
                <h2 class="font-bold">Daily Work Hours</h2>
                <ul>
                    @if(!$dailyHours)
                        @foreach($dailyHours as $day)
                            <li>{{ $day->date }}: {{ $day->total_hours }} hours</li>
                        @endforeach
                    @else
                        No data available
                    @endif

                </ul>
                <hr>
                <h2 class="font-bold">Most Worked Project</h2>
                @if($mostWorkedProject)
                    <p>{{ \App\Models\Project::find($mostWorkedProject->projects_id)->name }}: {{ $mostWorkedProject->total_hours }} hours</p>
                @else
                    <p>No data available</p>
                @endif
                <hr>
                <h2 class="font-bold">Most Active Employee</h2>
                @if($mostActiveEmployee)
                    <p>{{ \App\Models\User::find($mostActiveEmployee->users_id)->name }}: {{ $mostActiveEmployee->total_hours }} hours</p>
                @else
                    <p>No data available</p>
                @endif
            </div>
        </div>
    </div>

@endsection
