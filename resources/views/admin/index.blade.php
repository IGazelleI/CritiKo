<title> Home </title>
<x-layout>
    <div class="grid grid-cols-6 grid-flow-row gap-1 justify-items-stretch mt-10 p-0">
        <div>
            <x-card class="bg-laravel text-white mx-4">
                <a href="user/manage/0" class="hover:bg-black"> User </a>: {{$users}}
            </x-card>
        </div>
        <div>
            <x-card class="bg-laravel text-white mx-4">
                <a href="user/manage/1" class="hover:bg-black"> Admin </a>: {{$admins}}
            </x-card>
        </div>
        <div>
            <x-card class="bg-laravel text-white mx-4">
                <a href="user/manage/2" class="hover:bg-black"> SAST </a>: {{$sasts}}
            </x-card>
        </div>
        <div>
            <x-card class="bg-laravel text-white mx-4">
                <a href="user/manage/5" class="hover:bg-black"> Dean </a>: {{($deans == $depts)? $deans : $deans . ' of ' . $depts}}
            </x-card>
        </div>
        <div>
            <x-card class="bg-laravel text-white mx-4">
                <a href="user/manage/3" class="hover:bg-black"> Faculty </a>: {{$faculty}}
            </x-card>
        </div>
        <div>
            <x-card class="bg-laravel text-white mx-4">
                <a href="user/manage/4" class="hover:bg-black"> Student </a>: {{$students}}
            </x-card>
        </div>
    </div>
</x-layout>