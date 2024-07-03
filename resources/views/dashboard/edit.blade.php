@extends('layouts.app')

@section('content')

    <div class="max-w-2xl mx-auto pb-6 sm:px-6 lg:px-8">
        <div class="px-4 sm:px-0">
            <div class="bg-white shadow-md rounded my-6">
                <div class="container mx-auto mt- 4 w-64 text-center">
                    <h1 class="text-2xl mb-4">Edit Task</h1>
                    <form action="{{ route('dashboard.update', $task->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-5">
                            <label for="timeInput" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Choose Time</label>
                            <input type="text" id="timeInput" name="update" value="{{\Carbon\Carbon::parse($task->start)->format('H:i')}}" class="text-center w-32 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@flowbite.com" required />
                            <label for="project" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black mt-2">Select Project</label>
                            <select name="projects_id" id="project" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="">Select a project</option>
                                @foreach($projects as $project)
                                    @if(!in_array($project->id, $assignedProjects) && $project->end !== NULL )
                                        <option value="{{ $project->id }}" {{ $project->id == $selectedProjectId ? 'selected' : '' }}>
                                            {{ $project->name }}
                                        </option>
                                    @endif
                                    @if($project->id == $selectedProjectId)
                                        <option value="{{ $project->id }}" }} selected>
                                            {{ $project->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="py-5">
                            <a href="{{ url()->previous() }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-start">
                                Go Back
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/jquery.inputmask.min.js" integrity="sha512-F5Ul1uuyFlGnIT1dk2c4kB4DBdi5wnBJjVhL7gQlGh46Xn0VhvD8kgxLtjdZ5YN83gybk/aASUAlpdoWUjRR3g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('#timeInput').inputmask('99:99', {
            placeholder: "HH:MM",
            insertMode: false,
            showMaskOnHover: false,
            alias: "datetime",
            inputFormat: "HH:MM"
        });

    </script>
@endpush
