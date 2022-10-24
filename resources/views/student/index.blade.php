<title> {{auth()->user()->name}} </title>
<x-layout>
    <header class="text-center">
        <h2 class="text-2xl font-bold uppercase mb-1">
            {{$semester}}
        </h2>
    </header>
    <table class="w-full table-auto rounded-sm">
        <tbody>
            @if($enrollStatus == 'Pending' || $enrollStatus == 'Denied')
                <tr class="border-gray-300">
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        Enrollment Status: {{$enrollStatus}}
                    </td>
                </tr>
            @elseif($enrollStatus == 'Approved')
                @unless($klases->isEmpty())
                    <tr class="border-gray-300">
                        <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Class Code </th>
                        <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Instructor </th>
                        <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Status </th>
                    </tr>
                    @foreach($klases as $klase)
                    <tr class="border-gray-300">
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            {{$klase->subject}}
                        </td>
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            {{$klase->instructor}}
                        </td>
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            {{checkStatus($status, $klase->insID)}}
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr class="border-gray-300">
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            Current course has no subjects.
                        </td>
                    </tr>
                @endunless
            @else
                <tr class="border-gray-300">
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        {{$enrollStatus}}
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</x-layout>
@php
    function checkStatus($status, $facultyID)
    {
        foreach($status as $detail)
        {
            if($facultyID == $detail->evaluatee)
                return 'Finished';
        }

        return 'Pending';
    }
@endphp