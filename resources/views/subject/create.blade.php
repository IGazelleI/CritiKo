<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Create Subject
            </h2>
            <p class="mb-4">Make a new subject</p>
        </header>

        <form action="/subject" method="POST">
            @csrf
            <div class="mb-6">
                <label for="course_id" class="inline-block text-lg mb-2">
                    Course
                </label>
                <select name="course_id" id="course_id" class="border border-gray-200 rounded p-2 w-full">
                    @foreach ($course as $c)
                        <option value="{{$c->id}}" {{(old('course_id') == $c->id || $course_id == $c->id)? 'selected' : ''}}> {{$c->name}} </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-6">
                <label
                    for="code"
                    class="inline-block text-lg mb-2"
                    >Code</label
                >
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="code" value="{{old('code')}}"
                />

                @error('code')
                    <p class="text-red-500 text-xs mt-1"> {{$message}} </p>
                @enderror
            </div>
            <div class="mb-6">
                <label
                    for="name"
                    class="inline-block text-lg mb-2"
                    >Name</label
                >
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="name" value="{{old('name')}}"
                />

                @error('name')
                    <p class="text-red-500 text-xs mt-1"> {{$message}} </p>
                @enderror
            </div>
            <div class="mb-6">
                <button
                    class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"
                >
                    Create Subject
                </button>

                <a href="/subject{{$course_id == 0? '' : '//manage/' . $course_id}}" class="text-black ml-4"> Back </a>
            </div>
        </form>
    </x-card>
</x-layout>