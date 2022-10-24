<title> Add Period </title>
<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Create Period
            </h2>
            <p class="mb-4">Make a new enrollment period</p>
        </header>

        <form action="/period" method="POST">
            @csrf
            <div class="mb-6">
                <label
                    for="description"
                    class="inline-block text-lg mb-2"
                    >Description</label
                >
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="description" value="{{old('description')}}"
                />

                @error('description')
                    <p class="text-red-500 text-xs mt-1"> {{$message}} </p>
                @enderror
            </div>

            <div class="mb-6">
                <label
                    for="begin"
                    class="inline-block text-lg mb-2"
                    > Begin </label
                >
                <input
                    type="date"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="begin" value="{{old('begin')}}"
                />

                @error('begin')
                    <p class="text-red-500 text-xs mt-1"> {{$message}} </p>
                @enderror
            </div>
            <div class="mb-6">
                <label
                    for="end"
                    class="inline-block text-lg mb-2"
                    > End </label
                >
                <input
                    type="date"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="end" value="{{old('end')}}"
                />

                @error('end')
                    <p class="text-red-500 text-xs mt-1"> {{$message}} </p>
                @enderror
            </div>

            <div class="mb-6">
                <button
                    class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"
                >
                    Create Period
                </button>

                <a href="/period/manage" class="text-black ml-4"> Back </a>
            </div>
        </form>
    </x-card>
</x-layout>