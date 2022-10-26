<title> Preview Questions </title>
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
                    $qnum = 1;
                    $prevCat = '';
                @endphp
                
                @foreach($question as $q)
                {{-- Static sa pagset nga quanti ni siya --}}
                <input type="hidden" name="{{'qID' . $qnum}}" value="{{$q->id}}"/>
                @if($q->typeID == 1)
                <tr class="border-gray-300">
                    @if($prevCat != $q->cat)
                    @php
                        $count = 0;
                    @endphp
                    <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> {{$q->cat}} </th>
                    @endif
                </tr>

                <tr class="border-gray-300">
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        {{++$count}}. {{$q->sentence}}
                        <input type="hidden" name="{{'qCatID'  . $qnum}}" value="{{$q->catID}}"/>
                    </td>
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        <input type="radio" name="{{'qAns' . $qnum}}" value='1'/>
                    </td>
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        <input type="radio" name="{{'qAns' . $qnum}}" value='2'/>
                    </td>
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        <input type="radio" name="{{'qAns' . $qnum}}" value='3'/>
                    </td>
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        <input type="radio" name="{{'qAns' . $qnum}}" value='4'/>
                    </td>
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                        <input type="radio" name="{{'qAns' . $qnum}}" value='5'/>
                    </td>
                </tr>
                @php
                    $prevCat = $q->cat;
                    $qnum++;
                @endphp
                @else {{-- question type quality --}}
                <tr class="border-gray-300">
                    <td class="px-4 py-8 border-t border-b border-gray-300 text-lg" colspan="6">
                        <div class="mb-6">
                            <label for="{{'qAns' . $qnum}}" class="inline-block text-lg ml-3 mb-2">
                                {{$q->sentence}}
                            </label>
                            <input type="text" class="border border-black-200 rounded p-2 w-full" name="{{'qAns' . $qnum}}"/>
                        </div>
                    </td>
                </tr>
                @endif
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