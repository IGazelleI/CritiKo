<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Edit Subject
            </h2>
            @foreach($blocks as $block)
                @php
                    $b = $block;
                @endphp
            @endforeach
            <p class="mb-4">Edit Subject assigned to {{$b->course}} {{$b->year_level}} -  {{$b->section}}</p>
        </header>

        <form action="/block/klase/{{$klase->id}}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="block_id" value="{{$b->id}}"/>
            <div class="mb-6">
                <label for="subject_id" class="inline-block text-lg mb-2">
                    Subject
                </label>
                <select name="subject_id" id="subject_id" class="border border-gray-200 rounded p-2 w-full">
                    @unless($subjects->isEmpty())

                    @foreach ($subjects as $subject)
                        <option value="{{$subject->id}}" {{(old('subject_id') == $subject->id || $klase->subject_id == $subject->id)? 'selected' : ''}}> {{$subject->name}} </option>
                    @endforeach

                    @else
                        <option> Current course has no subjects. </option>

                    @endunless
                </select>

                @error('subject_id')
                    <p class="text-red-500 text-xs mt-1"> {{$message}} </p>
                @enderror
            </div>
            <div class="mb-6">
                <label
                    for="user_id"
                    class="inline-block text-lg mb-2"
                    >Instructor</label
                >
                <select name="user_id" id="user_id" class="border border-gray-200 rounded p-2 w-full">
                    @unless($instructor->isEmpty())

                    @foreach ($instructor as $prof)
                        <option value="{{$prof->id}}" {{(old('user_id') == $prof->id || $klase->user_id == $prof->id)? 'selected' : ''}}> {{$prof->name}} </option>
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
                    Update
                </button>

                <a href="/" class="text-black ml-4"> Back </a>
            </div>
        </form>
    </x-card>
</x-layout>