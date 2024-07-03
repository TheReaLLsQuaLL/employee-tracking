@extends('layouts.app')

@section('content')
    @push('css')
        <link href="https://cdn.datatables.net/v/dt/jq-3.7.0/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-html5-3.0.2/datatables.min.css" rel="stylesheet">
    @endpush
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('start'))
            <div class="bg-green-200 border-green-500 border-l-4 p-4 mb-4">
                <div class="flex items-center">
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('start') }}</p>
                    </div>
                </div>
            </div>
        @endif
        @if (session('stop'))
            <div class="bg-yellow-200 border-black-500 border-l-4 p-4 mb-4">
                <div class="flex items-center">
                    <div class="ml-3">
                        <p class="text-sm text-black-700">{{ session('stop') }}</p>
                    </div>
                </div>
            </div>
        @endif
        @if (session('delete'))
            <div class="bg-red-200 border-white-500 border-l-4 p-4 mb-4">
                <div class="flex items-center">
                    <div class="ml-3">
                        <p class="text-sm text-white-700">{{ session('delete') }}</p>
                    </div>
                </div>
            </div>
        @endif
        @if (session('project_created'))
            <div class="bg-green-200 border-green-500 border-l-4 p-4 mb-4">
                <div class="flex items-center">
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('project_created') }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="max-w-7xl mx-auto pb-6 sm:px-6 lg:px-8">
        <div class="px-4 sm:px-0">
            <div class="bg-white shadow-md rounded my-6">
                <table class="p-10" id="employeeTable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Project Name</th>
                        <th>Freelancer</th>
                        <th>Project Dates</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th><span class="float-end">Actions</span></th>
                    </tr>
                    </thead>
                    <tbody class="text-gray-700">
                    @foreach($taskList as $tasks)

                        <tr>
                            <td>{{$tasks->id}}</td>
                            <td>{{\App\Models\Project::find($tasks->projects_id)->name ?? "Unnamed"}}</td>
                            <td>{{\App\Models\User::find($tasks->users_id)->name}}</td>
                            <td>{{\Carbon\Carbon::parse($tasks->projects->end)->format('Y-m-d')}} > {{\Carbon\Carbon::parse($tasks->projects->start)->format('Y-m-d')}} </td>
                            <td>{{\Carbon\Carbon::parse($tasks->start)->format('H:i')}}</td>
                            <td>@if($tasks->end !== NULL) {{\Carbon\Carbon::parse($tasks->end)->format('H:i') }} @else Continues @endif</td>
                            <td>
                                <div class="float-end">
                                    @if(!$tasks->end)
                                        <form action="{{route('dashboard.stop')}}" method="POST" style="display:inline;" onsubmit="return confirmTaskStop();">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$tasks->id}}" />
                                            <button type="submit" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">Stop</button>
                                        </form>
                                    @endif
                                    @if(!$tasks->end)
                                        <a href="{{route('dashboard.edit', $tasks->id)}}" class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:focus:ring-yellow-900">Edit</a>
                                    @endif
                                    <form action="{{route('dashboard.delete')}}" method="POST" style="display:inline;" onsubmit="return confirmTaskDelete();">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$tasks->id}}" />
                                        <button type="submit" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Delete</button>
                                    </form>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('js')
        <script src="https://cdn.datatables.net/v/dt/jq-3.7.0/jszip-3.10.1/dt-2.0.8/b-3.0.2/b-html5-3.0.2/datatables.min.js"></script>
        <script>
            let table = new DataTable('#employeeTable', {
                layout: {
                    topStart: {
                        buttons: [
                            {
                                extend: 'excelHtml5',
                                exportOptions: {
                                    columns: [1, 2, 3, 4, 5]
                                }
                            },
                            {
                                extend: 'csvHtml5',
                                exportOptions: {
                                    columns: [1, 2, 3, 4, 5]
                                }
                            },
                            'colvis'
                        ]
                    }
                },
                order: [[1, 'desc']]
            });
            function confirmTaskStop() {
                return confirm('Are you sure you want to stop this task?');
            }
            function confirmTaskDelete() {
                return confirm('Are you sure you want to delete this task?');
            }
        </script>

    @endpush
@endsection
