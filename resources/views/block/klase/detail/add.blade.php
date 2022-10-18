<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Add Student
            </h2>
            @foreach($klases as $klase)
                @php
                    $k = $klase;
                @endphp
            @endforeach
            <p class="mb-4">Add Student to {{$k->subject}}</p>
        </header>

        <form action="/block/klase/detail" method="POST">
            @csrf
            <input type="hidden" name="klase_id" value="{{$k->id}}"/>
            <div class="mb-6">
                <label for="user_id" class="inline-block text-lg mb-2">
                    Student
                </label>
                <select name="user_id" id="user_id" class="border border-gray-200 rounded p-2 w-full">
                    @unless($students->isEmpty())

                    @foreach ($students as $student)
                        <option value="{{$student->id}}" {{old('user_id') == $student->id? 'selected' : ''}}> {{$student->name}} </option>
                    @endforeach

                    @else
                        <option> Current course has no students. </option>

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
                    Add
                </button>

                <a href="/block/klase/detail/manage/{{$k->id}}" class="text-black ml-4"> Back </a>
            </div>
        </form>
    </x-card>
</x-layout>