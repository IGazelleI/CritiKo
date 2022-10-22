<x-layout>
    <header>
        <h1 class="text-3xl text-center font-bold my-6 uppercase">
            Users
        </h1>
    </header>
    <table class="w-full table-auto rounded-sm">
        <tbody>
            @unless($users->isEmpty())
            <tr class="border-gray-300">
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> ID </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Type </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Name </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Date Created </th>
                <th  class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start" colspan="3"> Action </th>
            </tr>
            @foreach($users as $user)
            <tr class="border-gray-300">
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$user->id}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$user->type}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$user->name}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{date('M. d, Y @ g:i:s A', strToTime($user->created_at))}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    <form action="/user/{{$user->id}}" method="POST">
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