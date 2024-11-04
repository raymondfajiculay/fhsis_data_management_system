<x-layout>
    <div class="flex flex-col items-center justify-center mt-5">
        <h1 class="text-3xl font-bold">Ms Access File Upload</h1>

        <div class="flex flex-col w-1/2 mt-5">
            <form action="/file-upload" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- 
                <!-- Date Submitted Field -->
                <div class="mb-4 flex flex-col">
                    <label for="start_date" class="block text-sm font-medium leading-6 text-gray-900">Date
                        Submitted:</label>
                    <input type="date" name="date_submitted" id="start_date"
                        class="block w-full rounded-md border-0 py-1.5 pl-3 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        value="{{ old('date_submitted') }}">
                    @error('date_submitted')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div> --}}

                <!-- Report Month Checkboxes -->
                <div class="mb-4 flex flex-col gap-4">
                    <h2 for="start_date" class="block text-sm font-medium leading-6 text-gray-900">Report Month/s:</h2>
                    <div class="flex gap-6">
                        <!-- First Column -->
                        <div class="flex flex-col gap-2">
                            @foreach (['January', 'February', 'March'] as $month)
                                <div>
                                    <input type="checkbox" id="{{ strtolower($month) }}" name="selected_months[]"
                                        value="{{ $month }}"
                                        {{ in_array($month, old('selected_months', [])) ? 'checked' : '' }}>
                                    <label for="{{ strtolower($month) }}">{{ $month }}</label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Second Column -->
                        <div class="flex flex-col gap-2">
                            @foreach (['April', 'May', 'June'] as $month)
                                <div>
                                    <input type="checkbox" id="{{ strtolower($month) }}" name="selected_months[]"
                                        value="{{ $month }}"
                                        {{ in_array($month, old('selected_months', [])) ? 'checked' : '' }}>
                                    <label for="{{ strtolower($month) }}">{{ $month }}</label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Third Column -->
                        <div class="flex flex-col gap-2">
                            @foreach (['July', 'August', 'September'] as $month)
                                <div>
                                    <input type="checkbox" id="{{ strtolower($month) }}" name="selected_months[]"
                                        value="{{ $month }}"
                                        {{ in_array($month, old('selected_months', [])) ? 'checked' : '' }}>
                                    <label for="{{ strtolower($month) }}">{{ $month }}</label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Fourth Column -->
                        <div class="flex flex-col gap-2">
                            @foreach (['October', 'November', 'December'] as $month)
                                <div>
                                    <input type="checkbox" id="{{ strtolower($month) }}" name="selected_months[]"
                                        value="{{ $month }}"
                                        {{ in_array($month, old('selected_months', [])) ? 'checked' : '' }}>
                                    <label for="{{ strtolower($month) }}">{{ $month }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @error('selected_months')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Report Year Field -->
                <div class="mb-4 flex flex-col">
                    <label for="report_year" class="block text-sm font-medium leading-6 text-gray-900">Report
                        Year:</label>
                    <select name="report_year" id="report_year"
                        class="block w-full rounded-md border-0 py-1.5 pl-3 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <option value="" disabled selected>Select a year</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ old('report_year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                    @error('report_year')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- MDB File Upload -->
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium" for="mdbFile">Upload MDB File</label>
                    <input
                        class="block w-full text-lg text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:placeholder-gray-400"
                        id="mdbFile" type="file" name="mdbFile" accept=".mdb">
                    @error('mdbFile')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <input
                    class="mt-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                    type="submit" value="Upload">
            </form>
        </div>
    </div>
</x-layout>
