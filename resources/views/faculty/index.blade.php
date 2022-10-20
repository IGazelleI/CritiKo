<x-layout>
    {{-- attribute table --}}
    {!! $chart->container() !!}
    <table class="w-full table-auto rounded-sm">
        <tbody>
            @unless($attribute->isEmpty())
            <tr class="border-gray-300">
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Attribute </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Points </th>
            </tr>
            @foreach($attribute as $attri)
            <tr class="border-gray-300">
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$attri->name}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$attri->points}}
                </td>
            </tr>
            @endforeach
            @else
            <tr class="border-gray-300">
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    Attributes is empty.
                </td>
            </tr>
            @endunless
        </tbody>
    </table>
    {{-- status table --}}
    <table class="w-full table-auto rounded-sm">
        <tbody>
            @unless($facs->isEmpty())
            <tr class="border-gray-300">
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Name </th>
                <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Status </th>
            </tr>
            @foreach($facs as $fac)
            <tr class="border-gray-300">
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{$fac->name}}
                </td>
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    {{checkStatus($status, $fac->user_id)}}
                </td>
            </tr>
            @endforeach
            @else
            <tr class="border-gray-300">
                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                    Faculty from department is empty.
                </td>
            </tr>
            @endunless
        </tbody>
    </table>
</x-layout>
{!! $chart->script() !!}
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