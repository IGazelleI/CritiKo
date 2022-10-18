<x-layout>
    <form action="/student" method="POST">
        @csrf
        <header>
            <h1 class="text-3xl text-center font-bold my-6 uppercase">
                Evaluate Co-Faculty
            </h1>
            <input type="hidden" name="totalQuestion" value="{{$question->count()}}"/>
            <div class="mb-6">
                <label for="user_id" class="inline-block text-lg mb-2">
                    Name
                </label>
                
                @unless ($facs->isEmpty())
                <select name="user_id" id="user_id" class="border border-gray-200 rounded p-2 w-full">
                    @foreach ($facs as $fac)
                        <option value="{{$fac->id}}" {{old('user_id') == $fac->id? 'selected' : ''}}> {{$fac->name}}</option>
                    @endforeach
                </select>
                @else
                    <select class="border border-gray-200 rounded p-2 w-full" disabled>
                        <option> Faculty from department is empty. </option>
                    </select>
                @endunless
            </div>
        </header>
        <x-card>
            <table class="w-full table-auto rounded-sm">
                <tbody>
                    @unless($question->isEmpty())
                    <tr class="border-gray-300">
                        <th class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start">  </th>
                        <th  class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Worst </th>
                        <th  class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Bad </th>
                        <th  class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Average </th>
                        <th  class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Good </th>
                        <th  class="px-4 py-8 border-t border-b border-gray-300 text-lg text-start"> Best </th>
                    </tr>
                    @php
                        $count = 0;
                        $qnum = 1;
                        $prevCat = '';
                    @endphp
    
                    @foreach($question as $q)
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
                            <input type="hidden" name="{{'qID' . $qnum}}" value="{{$q->id}}"/>
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
            <div class="mb-6">
                <button
                    class="bg-laravel text-white rounded py-2 px-4 hover:bg-black"
                >
                    Submit
                </button>
            </div>
        </x-card>
    </form>
</x-layout>