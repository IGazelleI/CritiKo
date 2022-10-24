<title> {{auth()->user()->name}} </title>
<x-layout>
    {{-- attribute table --}}
    <div class="grid grid-rows-1 grid-flow-col gap-4 justify-items-stretch">
        <div class="ml-8 justify-self-start">
            {!! $chart->container() !!}
        </div>
        <div>
            <x-card>
                <h3>
                    Improve the following: <br/>
                </h3>
                <ul>
                    @foreach ($recommend as $key)
                        <li>
                            - {{$key->keyword}}
                        </li>
                    @endforeach
                </ul>
            </x-card>
            {{-- Gikan sa qualitative evaluations --}}
            @if(!$comments->isEmpty())
            <table class="w-full table-auto rounded-sm">
                <tbody>
                    <tr class="border-gray-300">
                        <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Comments </th>
                    </tr>
                    @foreach($comments as $dets)
                    <tr class="border-gray-300">
                        <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                            {{$dets->answer}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
        <div>
            {{-- status table --}}
            <table class="w-fit table-auto rounded-sm">
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
        </div>
      </div>
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