<title> Periods </title>
<x-layout>
    <header>
        <h1 class="text-3xl text-center font-bold my-6 uppercase">
            Periods
        </h1>
        <a href="/period/add" class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
            New
        </a>
    </header>
    <table class="w-full table-auto rounded-sm">
        <tbody>
            @unless($periods->isEmpty())
            <tr class="border-gray-300">
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> ID </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Description </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Start Date </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> End Date </th>
                <th  class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start" colspan="3"> Action </th>
            </tr>
            @foreach($periods as $period)
            <tr class="border-gray-300">
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$period->id}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$period->description}}
                </td><td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    @if(isset($period->begin))
                        {{date('M. d, Y @ D', strToTime($period->begin))}}
                    @else
                        Not set yet.
                    @endif 
                </td><td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    @if(isset($period->begin))
                        {{date('M. d, Y @ D', strToTime($period->end))}}
                    @else
                        Not set yet.
                    @endif 
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <a href="/period/{{$period->id}}/edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <form action="/period/{{$period->id}}" method="POST">
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
                    Period is empty.
                </td>
            </tr>
            @endunless
        </tbody>
    </table>
</x-layout>