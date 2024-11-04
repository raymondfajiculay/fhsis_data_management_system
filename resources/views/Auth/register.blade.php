<x-layout>
    <div class="mx-auto max-w-xl px-4 py-6 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-center">Register User</h1>

        {{-- Add the form action to point to the registration route --}}
        <form action="{{ route('register') }}" method="POST" class="mt-5">
            @csrf
            {{-- First Name --}}
            <div class="mb-4">
                <label for="first_name" class="block text-sm font-medium leading-6 text-gray-900">First Name:</label>
                <input type="text" name="first_name" id="first_name"
                    class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    value="{{ old('first_name') }}" required>
                @error('first_name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Last Name --}}
            <div class="mb-4">
                <label for="last_name" class="block text-sm font-medium leading-6 text-gray-900">Last Name:</label>
                <input type="text" name="last_name" id="last_name"
                    class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    value="{{ old('last_name') }}" required>
                @error('last_name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

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

            @can('select-municipality')
                {{-- Municipality --}}
                <div class="mb-4">
                    <label for="municipality"
                        class="block text-sm font-medium leading-6 text-gray-900">Municipalities</label>
                    <select name="municipality" id="municipality"
                        class="block w-full rounded-md border-0
                        py-1.5 pl-3 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400
                        focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <option value="" disabled selected>Select a municipality</option>
                        @foreach ($municipalities as $municipality)
                            <option value="{{ $municipality }}">{{ $municipality }}</option>
                        @endforeach
                    </select>
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @else
                {{-- Display Current Municipality for Non-Admin Roles --}}
                <div class="mb-4">
                    <label for="municipality" class="block text-sm font-medium leading-6 text-gray-900">Municipality</label>
                    <input type="text" value="{{ Auth::user()->municipality }}" name="municipality"
                        class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        disabled>
                    <input type="hidden" name="municipality" value="{{ Auth::user()->municipality }}">
                </div>
            @endcan

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password:</label>

                <div class="mt-2 flex gap-2"><input type="text" name="password" id="password"
                        class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        readonly required>
                    <button id="generatePassword" type="button" class="px-4 py-2 bg-indigo-500 text-white rounded">
                        Generate
                    </button>
                    <button id="copyPassword" type="button" class="px-4 py-2 bg-green-500 text-white rounded">
                        Copy
                    </button>
                </div>
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <div class="mt-6 text-center">
                <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Register
                </button>
            </div>
        </form>
    </div>
</x-layout>
<script>
    document.getElementById('generatePassword').addEventListener('click', function() {
        fetch('/generate-password')
            .then(response => response.json())
            .then(data => {
                document.getElementById('password').value = data.password;
            })
            .catch(error => console.error('Error:', error));
    });

    document.getElementById('copyPassword').addEventListener('click', function() {
        const passwordField = document.getElementById('password');
        passwordField.select(); // Select the password text
        document.execCommand('copy'); // Copy the selected text

        // Optionally, show an alert or notification
        alert('Password copied to clipboard!');
    });
</script>
