<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Edit Department
            </h2>
            <p class="mb-4">Edit {{$dept->name}}</p>
        </header>

        <form action="/department/{{$dept->id}}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label
                    for="name"
                    class="inline-block text-lg mb-2"
                    >Name</label
                >
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="name" value="{{$dept->name}}"
                />

                @error('name')
                    <p class="text-red-500 text-xs mt-1"> {{$message}} </p>
                @enderror
            </div>

            <div class="mb-6">
                <label
                    for="abbre"
                    class="inline-block text-lg mb-2"
                    >Abbrevation</label
                >
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="abbre" value="{{$dept->abbre}}"
                />

                @error('abbre')
                    <p class="text-red-500 text-xs mt-1"> {{$message}} </p>
                @enderror
            </div>

            <div class="mb-6">
                <button
                    class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"
                >
                    Update Department
                </button>

                <a href="/department/manage" class="text-black ml-4"> Back </a>
            </div>
        </form>
    </x-card>
</x-layout>