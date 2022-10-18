<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Edit Question
            </h2>
            <p class="mb-4">Edit Question</p>
        </header>

        <form action="/question" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label for="q_type_id" class="inline-block text-lg mb-2">
                    Type
                </label>
                <select name="q_type_id" id="q_type_id" class="border border-gray-200 rounded p-2 w-full">
                    @foreach ($types as $type)
                        <option value="{{$type->id}}" {{(old('q_type_id') == $type->id || $q->q_type_id == $type->id)? 'selected' : ''}}> {{$type->name}} </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-6">
                <label for="q_category_id" class="inline-block text-lg mb-2">
                    Category
                </label>
                <select name="q_category_id" id="q_category_id" class="border border-gray-200 rounded p-2 w-full">
                    @foreach ($category as $cat)
                        <option value="{{$cat->id}}" {{(old('q_category_id') == $cat->id || $q->q_category_id == $cat->id)? 'selected' : ''}}> {{$cat->name}} </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-6">
                <label
                    for="sentence"
                    class="inline-block text-lg mb-2"
                    >Sentence</label
                >
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="sentence" value="{{$q->sentence}}"
                />

                @error('sentence')
                    <p class="text-red-500 text-xs mt-1"> {{$message}} </p>
                @enderror
            </div>

            <div class="mb-6">
                <label
                    for="keyword"
                    class="inline-block text-lg mb-2"
                    >Keyword</label
                >
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="keyword" value="{{$q->keyword}}"
                />

                @error('keyword')
                    <p class="text-red-500 text-xs mt-1"> {{$message}} </p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="type" class="inline-block text-lg mb-2">
                    Question Answeree
                </label>
                <select name="type" id="" class="border border-gray-200 rounded p-2 w-full">
                    <option value="3" {{(old('type') == 3 || $q->type == 3)? 'selected' : ''}}> Faculty </option>
                    <option value="4" {{(old('type') == 4 || $q->type == 4)? 'selected' : ''}}> Student </option>
                </select>
            </div>
            <div class="mb-6">
                <button
                    class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"
                >
                    Update Question
                </button>

                <a href="/question" class="text-black ml-4"> Back </a>
            </div>
        </form>
    </x-card>
</x-layout>