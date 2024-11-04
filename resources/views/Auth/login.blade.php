<x-layout>
    <div class="mx-auto max-w-xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-center">Login Account</h1>

        {{-- Add the form action to point to the login route --}}
        <form action="{{ route('login') }}" method="POST" class="mt-5">
            @csrf
            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email:</label>
                <input type="email" name="email" id="email"
                    class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    value="{{ old('email') }}" required>
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password:</label>
                <input type="password" name="password" id="password"
                    class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    required>
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="mt-6 text-center">
                <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Login
                </button>
            </div>
        </form>
    </div>
</x-layout>
