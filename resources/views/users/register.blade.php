<x-layout>
    <x-card class="max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Register
            </h2>
            <p class="mb-4">Create an account to do features</p>
        </header>

        <form action="/users" method="POST">
            @csrf
            <div class="mb-6">
                <label for="type" class="inline-block text-lg mb-2">
                    Role
                </label>
                <select name="type" id="" class="border border-gray-200 rounded p-2 w-full">
                    <option value="1" {{old('type') == 1? 'selected' : ''}}> Admin </option>
                    <option value="2" {{old('type') == 2? 'selected' : ''}}> SAST Officer </option>
                    <option value="3" {{old('type') == 3? 'selected' : ''}}> Faculty </option>
                    <option value="4" {{old('type') == 4? 'selected' : ''}}> Student </option>
                </select>
            </div>
            <div class="mb-6">
                <label for="department_id" class="inline-block text-lg mb-2">
                    Department (Faculty Only)
                </label>
                <select name="department_id" id="department_id" class="border border-gray-200 rounded p-2 w-full">
                    @foreach ($departments as $department)
                        <option value="{{$department->id}}" {{old('department_id') == $department->id? 'selected' : ''}}> {{$department->name}} </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-6">
                <label for="course_id" class="inline-block text-lg mb-2">
                    Course (Students Only)
                </label>
                <select name="course_id" id="course_id" class="border border-gray-200 rounded p-2 w-full">
                    @foreach ($courses as $course)
                        <option value="{{$course->id}}" {{old('course_id') == $course->id? 'selected' : ''}}> {{$course->name}} </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-6">
                <label for="name" class="inline-block text-lg mb-2">
                    Name
                </label>
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="name"
                    value="{{old('name')}}"
                />

                @error('name')
                    <p class="text-red-500 text-xs mt-1">
                        {{$message}}
                    </p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="inline-block text-lg mb-2"
                    >Email</label
                >
                <input
                    type="email"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="email"
                    value="{{old('email')}}"
                />

                @error('email')
                    <p class="text-red-500 text-xs mt-1">
                        {{$message}}
                    </p>
                @enderror
            </div>

            <div class="mb-6">
                <label
                    for="password"
                    class="inline-block text-lg mb-2"
                >
                    Password
                </label>
                <input
                    type="password"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="password"
                    value="{{old('password')}}"
                />
                @error('password')
                    <p class="text-red-500 text-xs mt-1">
                        {{$message}}
                    </p>
                @enderror
            </div>

            <div class="mb-6">
                <label
                    for="password2"
                    class="inline-block text-lg mb-2"
                >
                    Confirm Password
                </label>
                <input
                    type="password"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="password_confirmation"
                    value="{{old('password_confirmation')}}"
                />

                @error('password_confirm')
                    <p class="text-red-500 text-xs mt-1">
                        {{$message}}
                    </p>
                @enderror
            </div>

            <div class="mb-6">
                <button
                    type="submit"
                    class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"
                >
                    Sign Up
                </button>
            </div>

            <div class="mt-8">
                <p>
                    Already have an account?
                    <a href="/login" class="text-laravel"
                        >Login</a
                    >
                </p>
            </div>
        </form>
    </x-card>
</x-layout>