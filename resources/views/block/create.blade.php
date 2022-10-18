<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Create Block
            </h2>
            <p class="mb-4">Make a new class</p>
        </header>

        <form action="/block" method="POST">
            @csrf
            <div class="mb-6">
                <label for="course_id" class="inline-block text-lg mb-2">
                    Course
                </label>
                <select name="course_id" id="course_id" class="border border-gray-200 rounded p-2 w-full">
                    @foreach ($courses as $course)
                        <option value="{{$course->id}}" {{(old('type') == $course->id || $course_id == $course->id)? 'selected' : ''}}> {{$course->name}} </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-6">
                <label
                    for="year_level"
                    class="inline-block text-lg mb-2"
                    >Year Level</label
                >
                <select name="year_level" id="year_level" class="border border-gray-200 rounded p-2 w-full">
                    <option value="1" {{old('year_level') == 1? 'selected' : ''}}> 1 </option>
                    <option value="2" {{old('year_level') == 2? 'selected' : ''}}> 2 </option>
                    <option value="3" {{old('year_level') == 3? 'selected' : ''}}> 3 </option>
                    <option value="4" {{old('year_level') == 4? 'selected' : ''}}> 4 </option>
                </select>

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
                    name="section" value="{{old('section')}}"
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
                    @unless($adviser->isEmpty())

                    @foreach ($adviser as $prof)
                        <option value="{{$prof->user_id}}" {{old('user_id') == $prof->user_id? 'selected' : ''}}> {{$prof->name}} </option>
                    @endforeach

                    @else
                        <option> Department's current faculty is empty. </option>
                    
                    @endunless
                </select>

                @error('user_id')
                    <p class="text-red-500 text-xs mt-1"> {{$message}} </p>
                @enderror
            </div>
            <div class="mb-6">
                <button
                    class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"
                >
                    Create Block
                </button>

                <a href="/block{{$course_id == 0? '': '//manage/' . $course_id}}" class="text-black ml-4"> Back </a>
            </div>
        </form>
    </x-card>
</x-layout>