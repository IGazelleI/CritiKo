<x-layout>
    <header>
        <h1 class="text-3xl text-center font-bold my-6 uppercase">
            <h1 class="text-3xl text-center font-bold my-6 uppercase">
                @foreach ($blocks as $block)
                    @php 
                        $b = $block;
                    @endphp
                @endforeach
                {{$b->course}} {{$b->year_level}} -  {{$b->section}} Students
            </h1>
        </h1>
        <a href="/block/student/add/{{$b->id}}" class="bg-laravel text-white rounded mb-2 py-2 px-4 hover:bg-black">
            Add
        </a>
        <a href="/block/student/addToSubjects/{{$b->id}}" class="bg-laravel text-white rounded mb-2 ml-2 py-2 px-4 hover:bg-black">
            Add to Subjects
        </a>
    </header>
    <table class="w-full table-auto rounded-sm">
        <tbody>
            @unless($blockStuds->isEmpty())
            <tr class="border-gray-300">
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> ID </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Name </th>
                <th  class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start" colspan="3"> Action </th>
            </tr>
            @foreach($blockStuds as $blockStud)
            <tr class="border-gray-300">
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$blockStud->id}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$blockStud->student}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <form action="/block/student/{{$blockStud->id}}" method="POST">
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
                    Block has currently no students.
                </td>
            </tr>
            @endunless
        </tbody>
    </table>
</x-layout>