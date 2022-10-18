<x-layout>
    <header>
        <h1 class="text-3xl text-center font-bold my-6 uppercase">
            Subjects
        </h1>
        <a href="/subject/create/0" class="bg-laravel text-white rounded mb-2 py-2 px-4 hover:bg-black">
            New
        </a>
    </header>
    <table class="w-full table-auto rounded-sm">
        <tbody>
            @unless($subject->isEmpty())
            <tr class="border-gray-300">
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> ID </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Code </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Name </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Course </th>
                <th  class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start" colspan="3"> Action </th>
            </tr>
            @foreach($subject as $subj)
            <tr class="border-gray-300">
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$subj->id}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$subj->code}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$subj->name}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$subj->course}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <a href="/subject/{{$subj->id}}/edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <form action="/subject/{{$subj->id}}" method="POST">
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
                    Subject is empty.
                </td>
            </tr>
            @endunless
        </tbody>
    </table>
</x-layout>