<x-layout>
    <header>
        <h1 class="text-3xl text-center font-bold my-6 uppercase">
            Preview Questions
        </h1>
        <a href="/question" class="bg-laravel text-white rounded ml-2 py-2 px-4 hover:bg-black">
            Back
        </a>
    </header>
    <x-card>
        <table class="w-full table-auto rounded-sm">
            <tbody>
                @unless($question->isEmpty())
                <tr class="border-gray-300">
                    <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start">  </th>
                    <th  class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> 1 </th>
                    <th  class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> 2 </th>
                    <th  class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> 3 </th>
                    <th  class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> 4 </th>
                    <th  class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> 5 </th>
                </tr>
                @php
                    $count = 0;
                    $prevCat = '';
                @endphp

                @foreach($question as $q)
                <tr class="border-gray-300">
                    @if($prevCat != $q->cat)
                    @php
                        $count = 0;
                        $qnum = 1;
                    @endphp
                    <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> {{$q->cat}} </th>
                    @endif
                </tr>

                <tr class="border-gray-300">
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        {{++$count}}. {{$q->sentence}}
                    </td>
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        <input type="radio" name="{{'q' . $qnum}}"/>
                    </td>
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        <input type="radio" name="{{'q' . $qnum}}"/>
                    </td>
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        <input type="radio" name="{{'q' . $qnum}}"/>
                    </td>
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        <input type="radio" name="{{'q' . $qnum}}"/>
                    </td>
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        <input type="radio" name="{{'q' . $qnum}}"/>
                    </td>
                </tr>
                @php
                    $prevCat = $q->cat;
                    $qnum++;
                @endphp
                @endforeach
                @else
                <tr class="border-gray-300">
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        Question is empty.
                    </td>
                </tr>
                @endunless
            </tbody>
        </table>
    </x-card>
</x-layout>