<x-layout>
    <header>
        <h1 class="text-3xl text-center font-bold my-6 uppercase">
            @foreach ($klases as $klase)
                @php 
                    $k = $klase;
                @endphp
            @endforeach
            {{$k->name}} Students
        </h1>
        <a href="/block/klase/detail/add/{{$k->id}}" class="bg-laravel text-white rounded mb-2 py-2 px-4 hover:bg-black">
            Add
        </a>
    </header>
    <table class="w-full table-auto rounded-sm">
        <tbody>
            @unless($klase_dets->isEmpty())
            <tr class="border-gray-300">
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> ID </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Student </th>
                <th  class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start" colspan="3"> Action </th>
            </tr>
            @foreach($klase_dets as $detail)
            <tr class="border-gray-300">
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$detail->id}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$detail->student}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <form action="/block/klase/detail/{{$detail->id}}" method="POST">
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
                    Current subject has no students.
                </td>
            </tr>
            @endunless
        </tbody>
    </table>
</x-layout>