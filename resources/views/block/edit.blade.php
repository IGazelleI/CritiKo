<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Edit Block
            </h2>
            <p class="mb-4"> Edit {{$block->year_level}} - {{$block->section}}</p>
        </header>

        <form action="/block/{{$block->id}}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label for="course_id" class="inline-block text-lg mb-2">
                    Course
                </label>
                <select name="course_id" id="course_id" class="border border-gray-200 rounded p-2 w-full">
                    @foreach ($courses as $course)
                        <option value="{{$course->id}}" {{(old('type') == $course->id || $block->course_id == $course->id)? 'selected' : ''}}> {{$course->name}} </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label
                    for="year_level"
                    class="inline-block text-lg mb-2"
                    >Year Level</label
                >
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="year_level" value="{{$block->year_level}}"
                />

                @error('year_level')
                    <p class="text-red-500 text-xs mt-1"> {{$message}} </p>
                @enderror
            </div>

            <div class="mb-6">
                <label
                    for="section"
                    class="inline-block text-lg mb-2"
                    >Section</label
                >
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="section" value="{{$block->section}}"
                />

                @error('section')
                    <p class="text-red-500 text-xs mt-1"> {{$message}} </p>
                @enderror
            </div>
            <div class="mb-6">
                <label
                    for="user_id"
                    class="inline-block text-lg mb-2"
                    >Adviser</label
                >
                <select name="user_id" id="user_id" class="border border-gray-200 rounded p-2 w-full">
                    @foreach ($adviser as $prof)
                        <option value="{{$prof->id}}" {{(old('user_id') == $prof->id || $block->user_id == $prof->id)? 'selected' : ''}}> {{$prof->name}} </option>
                    @endforeach
                </select>

                @error('user_id')
                    <p class="text-red-500 text-xs mt-1"> {{$message}} </p>
                @enderror
            </div>
            <div class="mb-6">
                <button
                    class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"
                >
                    Update Block
                </button>

                <a href="/block/manage/{{$block->course_id}}" class="text-black ml-4"> Back </a>
            </div>
        </form>
    </x-card>
</x-layout>