<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
               Enrollment
            </h2>
        </header>

        <form action="/enroll" method="POST">
            @csrf
            <input type="hidden" name="period_id" value="{{$semID}}"/>
            <div class="mb-6">
                <label for="course_id" class="inline-block text-lg mb-2">
                    Course
                </label>
                <select name="course_id" id="course_id" class="border border-gray-200 rounded p-2 w-full">
                    @foreach ($courses as $course)
                        <option value="{{$course->id}}" {{old('course_id') == $course->id? 'selected' : ''}}> {{$course->name}} </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label for="year_level" class="inline-block text-lg mb-2">
                    Year Level
                </label>
                <select name="year_level" id="" class="border border-gray-200 rounded p-2 w-full">
                    @for ($i = 1; $i <= 4; $i++)
                        <option value="{{$i}}" {{(old('type') == $i || $prevYear == $i)? 'selected' : ''}}> {{$i}} </option>
                    @endfor
                </select>
            </div>

            <div class="mb-6">
                <button
                    class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"
                >
                    Enroll
                </button>

                <a href="/student" class="text-black ml-4"> Back </a>
            </div>
        </form>
    </x-card>
</x-layout>