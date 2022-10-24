<x-layout>
    @if(!$period['empty'])
        @if(isset($period->begin))
            @if($period->end < NOW()->format('Y-m-d'))
            <x-card>
                <header>
                    <h1 class="text-3xl text-center font-bold my-6 uppercase">
                        Evaluation ended on {{date('F d, Y @ D', strToTime($period->end))}}
                    </h1>
                </header>
            </x-card>
            @elseif($period->begin < NOW()->format('Y-m-d'))
            <form action="/faculty" method="POST">
                @csrf
                <header>
                    <h1 class="text-3xl text-center font-bold my-6 uppercase">
                        Evaluate Co-Faculty
                    </h1>
                    <input type="hidden" name="totalQuestion" value="{{$question->count()}}"/>
                    <x-card>
                        <div class="mb-6">
                            @unless ($facs->isEmpty())
                            <select name="user_id" id="user_id" class="border border-gray-200 rounded p-2 w-full">
                                <option selected disabled> -Select Faculty- </option>
                                @foreach ($facs as $fac)
                                    @php
                                        $done = checkStatus($status, $fac->id);
                                    @endphp
                                    <option value="{{$fac->id}}" 
                                        {{old('user_id') == $fac->id? 'selected' : ''}}
                                        {{$done? 'disabled' : ''}} >
                                        {{$done ? '(Finished) ' : ''}}
                                        {{$fac->name}}
                                    </option>
                                @endforeach
                            </select>
                            @else
                                <select class="border border-gray-200 rounded p-2 w-full" disabled>
                                    <option> Current department faculty is empty. </option>
                                </select>
                            @endunless

                            @error('user_id')
                                <p class="text-red-500 text-xs mt-1">
                                    {{$message}}
                                </p>
                            @enderror
                        </div>
                    </x-card>
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
                            @else {{-- question type qualitative --}}
                            <tr class="border-gray-300">
                                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                    <div class="mb-6">
                                        <label for="{{'qAns' . $qnum}}" class="inline-block text-lg mb-2">
                                            {{$q->sentence}}
                                        </label>
                                        <input type="text" class="border border-black-200 rounded p-2 w-full" name="{{'qAns' . $qnum}}"/>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                            @else {{-- no questions found  --}}
                            <tr class="border-gray-300">
                                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                    Question is empty.
                                </td>
                            </tr>
                            @endunless
                        </tbody>
                    </table>
                    <div class="mb-6">
                        <button
                            class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"
                        >
                            Submit
                        </button>
                    </div>
                </x-card>
            </form>            
            @else
            <x-card>
                <header>
                    <h1 class="text-3xl text-center font-bold my-6 uppercase">
                        Evaluation will open on {{date('F d, Y @ D', strToTime($period->begin))}}
                    </h1>
                </header>
            </x-card>
            @endif
        @else
        <x-card>
            <header>
                <h1 class="text-3xl text-center font-bold my-6 uppercase">
                    Evaluation period date not set
                </h1>
            </header>
        </x-card>
        @endif
    @else 
    <x-card>
        <header>
            <h1 class="text-3xl text-center font-bold my-6 uppercase">
                Evaluation period is empty
            </h1>
        </header>
    </x-card>
    @endif
</x-layout>
@php
    function checkStatus($status, $facultyID)
    {
        if(!$status->isEmpty())
        {
            foreach($status as $detail)
            {
                if($facultyID == $detail->evaluatee)
                    return true;
            }
        }

        return false;
    }
@endphp