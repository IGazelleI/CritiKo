<x-layout>
    <header>
        <h1 class="text-3xl text-center font-bold my-6 uppercase">
            Blocks
        </h1>
        <a href="/block/create/0" class="bg-laravel text-white rounded mb-2 py-2 px-4 hover:bg-black">
            New
        </a>
    </header>
    <table class="w-full table-auto rounded-sm">
        <tbody>
            @unless($blocks->isEmpty())
            <tr class="border-gray-300">
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> ID </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Year Level </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Section </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Adviser </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Course </th>
                <th  class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start" colspan="3"> Action </th>
            </tr>
            @foreach($blocks as $block)
            <tr class="border-gray-300">
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$block->id}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$block->year_level}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$block->section}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$block->adviser}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$block->course}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <a href="/block/klase/manage/{{$block->id}}">
                        <i class="fa-solid fa-search"></i>
                    </a>
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <a href="/block/{{$block->id}}/edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <form action="/block/{{$block->id}}" method="POST">
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
                    Block is empty.
                </td>
            </tr>
            @endunless
        </tbody>
    </table>
</x-layout>