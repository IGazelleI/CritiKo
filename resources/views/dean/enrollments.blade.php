<x-layout>
    <header>
        <h1 class="text-3xl text-center font-bold my-6 uppercase">
            Enrollments
        </h1>
    </header>
    <table class="w-full table-auto rounded-sm">
        <tbody>
            @unless($enrollment->isEmpty())
            <tr class="border-gray-300">
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> ID </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Student </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Course </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Year Level </th>
                <th  class="px-4 py-8 border-t border-b border-gray-300 text-lg text-center" colspan="2"> Action </th>
            </tr>
            @foreach($enrollment as $detail)
            <tr class="border-gray-300">
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$detail->id}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$detail->student}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$detail->course}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$detail->year_level}}
                </td>
                    <td class="text-end">
                    <form action="/enroll/{{$detail->id}}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="decision" value="1"/>
                        <button class="bg-black text-white rounded py-2 px-4 hover:bg-black">
                            <i class="fa-solid fa-check"></i>
                        </button>
                    </form>
                </td>
                <td class="text-start">
                    <form action="/enroll/{{$detail->id}}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="decision" value="0"/>
                        <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
                            <i class="fa-solid fa-close"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
            @else
            <tr class="border-gray-300">
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    Enrollment is empty.
                </td>
            </tr>
            @endunless
        </tbody>
    </table>
</x-layout>