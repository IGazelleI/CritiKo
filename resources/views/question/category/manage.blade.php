<x-layout>
    <header>
        <h1 class="text-3xl text-center font-bold my-6 uppercase">
            Question Categories
        </h1>
        <a href="/q/c/create" class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
            New
        </a>
    </header>
    <table class="w-full table-auto rounded-sm">
        <tbody>
            @unless($cats->isEmpty())
            <tr class="border-gray-300">
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> ID </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Name </th>
                <th  class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start" colspan="3"> Action </th>
            </tr>
            @foreach($cats as $c)
            <tr class="border-gray-300">
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$c->id}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$c->name}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <a href="/question/manage/{{$c->id}}">
                        <i class="fa-solid fa-search"></i>
                    </a>
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <a href="/q/c/{{$c->id}}/edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <form action="/q/c/{{$c->id}}" method="POST">
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
                    Category is empty.
                </td>
            </tr>
            @endunless
        </tbody>
    </table>
</x-layout>