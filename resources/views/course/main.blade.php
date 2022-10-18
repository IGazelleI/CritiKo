<x-layout>
    <header>
        <h1 class="text-3xl text-center font-bold my-6 uppercase">
            Courses
        </h1>
        <a href="/course/create/0" class="bg-laravel text-white rounded mb-5 py-2 px-4 hover:bg-black">
            New
        </a>
    </header>
    <table class="w-full table-auto rounded-sm">
        <tbody>
            @unless($course->isEmpty())
            <tr class="border-gray-300">
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> ID </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Abbre </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Name </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Department </th>
                <th  class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start" colspan="3"> Action </th>
            </tr>
            @foreach($course as $c)
            <tr class="border-gray-300">
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$c->id}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$c->abbre}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$c->name}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$c->department}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <a href="/block/manage/{{$c->id}}">
                        <i class="fa-solid fa-search"></i>
                    </a>
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <a href="/course/{{$c->id}}/edit" method="POST">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <form action="/course/{{$c->id}}" method="POST">
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
                    Course is empty.
                </td>
            </tr>
            @endunless
        </tbody>
    </table>
</x-layout>