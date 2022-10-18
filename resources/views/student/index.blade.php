<x-layout>
    Student Home Page

    <table class="w-full table-auto rounded-sm">
        <tbody>
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
                    No subjects enrolled.
                </td>
            </tr>
            @endunless
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