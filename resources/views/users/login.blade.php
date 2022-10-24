<x-layout>
    <x-card>
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Login
            </h2>
            <p class="mb-4">Log into your account</p>
        </header>
        
        <form action="/users/auth" method="POST">
            @csrf
        
            <div class="mb-6">
                <label for="email" class="inline-block text-lg mb-2"
                    >E-mail</label
                >
                <input
                    type="text"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="email"
                    value="{{old('email')}}"
                />
        
                @error('email')
                    <p class="text-red-500 text-xs mt-1">
                        {{$message}}
                    </p>
                @enderror
            </div>
        
            <div class="mb-6">
                <label
                    for="password"
                    class="inline-block text-lg mb-2"
                >
                    Password
                </label>
                <input
                    type="password"
                    class="border border-gray-200 rounded p-2 w-full"
                    name="password"
                    value="{{old('password')}}"
                />
                @error('password')
                    <p class="text-red-500 text-xs mt-1">
                        {{$message}}
                    </p>
                @enderror
            </div>
        
            <div class="mb-6">
                <button
                    type="submit"
                    class=" text-dark rounded py-2 px-4 hover:bg-black"
                >
                    Login
                </button>
            </div>
        
            <div class="mt-8">
            </div>
        </form>
    </x-card>
</x-layout>