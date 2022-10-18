<x-layout>
    @php
        //check role
        function checkRole($type)
        {
            switch($type)
            {
                case 3: return 'Faculty';
                        break;
                case 4: return 'Student';
            }
        }
    @endphp
    <header>
        <h1 class="text-3xl text-center font-bold my-6 uppercase">
            Questions
        </h1>
        <a href="/question/create" class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
            New
        </a>
        <a href="/question/type" class="bg-laravel text-white rounded ml-2 py-2 px-4 hover:bg-black">
            Type
        </a>
        <a href="/q/c" class="bg-laravel text-white rounded ml-2 py-2 px-4 hover:bg-black">
            Category
        </a>
        <a href="/question/preview" class="bg-laravel text-white rounded ml-2 py-2 px-4 hover:bg-black">
            Preview
        </a>
    </header>
    <table class="w-full table-auto rounded-sm">
        <tbody>
            @unless($question->isEmpty())
            <tr class="border-gray-300">
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> ID </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Type </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Category </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Sentence </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Keyword </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Answerer </th>
                <th  class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start" colspan="3"> Action </th>
            </tr>
            @foreach($question as $q)
            <tr class="border-gray-300">
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$q->id}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$q->type}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$q->category}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$q->sentence}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$q->keyword}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{checkRole($q->answerer)}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <a href="/question/{{$q->id}}/edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <form action="/question/{{$q->id}}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button class="text-red-500">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
            @else
            <tr class="border-gray-300">
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    Question is empty.
                </td>
            </tr>
            @endunless
        </tbody>
    </table>
</x-layout>