<title> Dean Assignment </title>
<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Dean Assignment for {{$dept->abbre}}
            </h2>
        </header>

        <form action="/user/dean" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="department_id" value="{{$dept->id}}"/>
            <div class="mb-6">
                <label for="subject_id" class="inline-block text-lg mb-2">
                    Faculty
                </label>
                <select name="user_id" id="user_id" class="border border-gray-200 rounded p-2 w-full">
                    @unless($facs->isEmpty())
                    @foreach ($facs as $fac)
                        <option value="{{$fac->id}}"> {{$fac->name}} </option>
                    @endforeach

                    @else
                        <option selected disabled> Current department has no faculty. </option>

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
                    Assign
                </button>

                <a href="/block/klase/manage/{{}}" class="text-black ml-4"> Back </a>
            </div>
        </form>
    </x-card>
</x-layout>