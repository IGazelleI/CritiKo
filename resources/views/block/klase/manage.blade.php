<x-layout>
    <header>
        <h1 class="text-3xl text-center font-bold my-6 uppercase">
            @foreach ($blocks as $block)
                @php 
                    $b = $block;
                @endphp
            @endforeach
            {{$b->course}} {{$b->year_level}} -  {{$b->section}} Subjects
        </h1>
        <a href="/block/klase/add/{{$b->id}}" class="bg-laravel text-white rounded mb-2 py-2 px-4 hover:bg-black">
            Add
        </a>
        <a href="/block/student/manage/{{$b->id}}" class="bg-laravel text-white rounded mb-2 ml-2 py-2 px-4 hover:bg-black">
            Students
        </a>
    </header>
    <table class="w-full table-auto rounded-sm">
        <tbody>
            @unless($klases->isEmpty())
            <tr class="border-gray-300">
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> ID </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Subject </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Instructor </th>
                <th  class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start" colspan="3"> Action </th>
            </tr>
            @foreach($klases as $klase)
            <tr class="border-gray-300">
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$klase->id}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$klase->subject}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$klase->instructor}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <a href="/block/klase/detail/manage/{{$klase->id}}">
                        <i class="fa-solid fa-search"></i>
                    </a>
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <a href="/block/klase/{{$klase->id}}/edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <form action="/block/klase/{{$klase->id}}" method="POST">
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
                    Current block has no subjects.
                </td>
            </tr>
            @endunless
        </tbody>
    </table>
</x-layout>