<title> {{$title}} </title>
<x-layout>
    <header>
        <h1 class="text-3xl text-center font-bold my-6 uppercase">
            {{$title}}
        </h1>
    </header>
    <x-card>
        <table class="w-full table-auto rounded-sm">
            <tbody>
                @unless($user->isEmpty())
                <tr class="border-gray-300">
                    {{-- <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> ID </th> --}}
                    @if($type == 5)
                    <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Department </th>
                    @endif
                    <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Dean </th>
                    <th  class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start" colspan="3"> Action </th>
                </tr>
                @foreach($user as $det)
                <tr class="border-gray-300">
                    {{-- <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        {{$det->id}}
                    </td> --}}
                    @if($type == 5)
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        {{$det->department}}
                    </td>
                    @endif
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        {{checkDean($det->id, $dean)}}
                    </td>
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        <a href="/user/{{$det->id}}/assign">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </td>
                    {{-- <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        <form action="/subject/{{$det->id}}" method="POST">
                            @csrf
                            @method('DELETE')
    
                            <button class="text-red-500">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td> --}}
                </tr>
                @endforeach
                @else
                <tr class="border-gray-300">
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        User is empty.
                    </td>
                </tr>
                @endunless
            </tbody>
        </table>
    </x-card>
    {{-- <div class="grid grid-rows-1 grid-flow-col gap-4 justify-items-stretch">
        <div>
            <h1 class="text-3xl my-6 ml-5">
                Admin ({{$admin->count()}})
            </h1>
            <table class="w-full table-auto rounded-sm">
                <tbody>
                    @unless($admin->isEmpty())
                    <tr class="border-gray-300">
                        <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> ID </th>
                        <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Name </th>
                    </tr>
                    @foreach($admin as $det)
                    <tr class="border-gray-300">
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            {{$det->id}}
                        </td>
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            {{$det->name}}
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr class="border-gray-300">
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            Admin is empty.
                        </td>
                    </tr>
                    @endunless
                </tbody>
            </table>
        </div>
        <div>
            <h1 class="text-3xl my-6 ml-5">
                SAST ({{$sast->count()}})
            </h1>
            <table class="w-full table-auto rounded-sm">
                <tbody>
                    @unless($sast->isEmpty())
                    <tr class="border-gray-300">
                        <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> ID </th>
                        <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Name </th>
                    </tr>
                    @foreach($sast as $det)
                    <tr class="border-gray-300">
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            {{$det->id}}
                        </td>
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            {{$det->name}}
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr class="border-gray-300">
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            SAST Officer is empty.
                        </td>
                    </tr>
                    @endunless
                </tbody>
            </table>
        </div>
        <div>
            <h1 class="text-3xl my-6 ml-5">
                Dean ({{$dean->count()}})
            </h1>
            <table class="w-full table-auto rounded-sm">
                <tbody>
                    @unless($dean->isEmpty())
                    <tr class="border-gray-300">
                        <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> ID </th>
                        <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Name </th>
                        <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Department</th>
                    </tr>
                    @foreach($dean as $det)
                    <tr class="border-gray-300">
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            {{$det->id}}
                        </td>
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            {{$det->name}}
                        </td>
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            {{$det->department}}
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr class="border-gray-300">
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            Dean is empty.
                        </td>
                    </tr>
                    @endunless
                </tbody>
            </table>
        </div>
        <div>
            <div class="grid grid-rows-1 grid-flow-col gap-4 align-items-stretch">
                <div>
                    <h1 class="text-3xl my-6 ml-5">
                        Faculty ({{$fac->count()}})
                    </h1>
                </div>
                <div class="align-self-center mt-7">
                    <form action='/user/random/3' method="POST">
                        @csrf
                        <input type="number" class="border border-gray-200 rounded w-10 h-10" step="5" name="count"/>
                        <button
                            type="submit"
                            class="text-black rounded py-2 px-4 hover:bg-black hover:text-white"
                        >
                            +
                        </button>
                    </form>
                </div>
            </div>
            <table class="w-full table-auto rounded-sm">
                <tbody>
                    @unless($fac->isEmpty())
                    <tr class="border-gray-300">
                        <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> ID </th>
                        <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Name </th>
                        <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Department</th>
                    </tr>
                    @foreach($fac as $det)
                    <tr class="border-gray-300">
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            {{$det->id}}
                        </td>
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            {{$det->name}}
                        </td>
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            {{$det->department}}
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr class="border-gray-300">
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            Faculty is empty.
                        </td>
                    </tr>
                    @endunless
                </tbody>
            </table>
        </div>
        <div>
            <div class="grid grid-rows-1 grid-flow-col gap-4 align-items-stretch">
                <div>
                    <h1 class="text-3xl my-6 ml-5">
                        Student ({{$student->count()}})
                    </h1>
                </div>
                <div class="align-self-center mt-7">
                    <form action='/user/random/4' method="POST">
                        @csrf
                        <input type="number" class="border border-gray-200 rounded w-10 h-10" step="5" name="count"/>
                        <button
                            type="submit"
                            class="text-black rounded py-2 px-4 hover:bg-black hover:text-white"
                        >
                            +
                        </button>
                    </form>
                </div>
            </div>
            <table class="w-full table-auto rounded-sm">
                <tbody>
                    @unless($student->isEmpty())
                    <tr class="border-gray-300">
                        <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> ID </th>
                        <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Name </th>
                        <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Course </th>
                    </tr>
                    @foreach($student as $det)
                    <tr class="border-gray-300">
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            {{$det->id}}
                        </td>
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            {{$det->name}}
                        </td><td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            {{$det->course}}
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr class="border-gray-300">
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            Student is empty.
                        </td>
                    </tr>
                    @endunless
                </tbody>
            </table>
        </div>
    </div> --}}
</x-layout>
@php
    function checkDean($dept, $deans)
    {
        foreach($deans as $dean)
        {
            if($dean->id == $dept)
                return $dean->name;
        }

        return 'Unassigned';
    }
@endphp