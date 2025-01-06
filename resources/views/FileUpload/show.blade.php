<x-layout>
    <div class="mx-auto flex w-full flex-col justify-center px-5">
        <h1 class="text-2xl font-bold text-center mt-5">File Directory</h1>
        <div class="relative flex w-full flex-col pt-[20px] md:pt-0" id="listTable" style="display: block;">
            <div class="flex justify-end items-center p-4">
                <form action="{{ route('files') }}" method="GET" class="flex space-x-2" id="filterForm">
                    @unless (auth()->user()->role !== 'super_admin')
                        <select name="municipality" class="border rounded-md p-2 text-sm">
                            <option value="" disabled {{ request('municipality') ? '' : 'selected' }}>Filter by
                                Municipality</option>
                            @foreach ($municipalities as $municipality)
                                <option value="{{ $municipality }}"
                                    {{ request('municipality') === $municipality ? 'selected' : '' }}>
                                    {{ $municipality }}
                                </option>
                            @endforeach
                        </select>
                    @endunless

                    <select name="month" class="border rounded-md p-2 text-sm">
                        <option value="" disabled {{ request('month') ? '' : 'selected' }}>Filter by Report Month
                        </option>
                        @foreach ($months as $month)
                            <option value="{{ $month }}" {{ request('month') === $month ? 'selected' : '' }}>
                                {{ $month }}
                            </option>
                        @endforeach
                    </select>

                    <select name="year" class="border rounded-md p-2 text-sm">
                        <option value="" disabled {{ !request('year') ? 'selected' : '' }}>Filter by Report Year
                        </option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="bg-blue-500 text-white rounded p-2">Filter</button>
                </form>

                <button type="button" class="bg-gray-500 text-white rounded p-2 ml-2" onclick="clearFilters()">Clear
                    Filter</button>
            </div>
            <div class="h-full w-full rounded-lg">
                <div
                    class="rounded-lg border bg-card text-card-foreground shadow-sm h-full w-full p-0 border-zinc-800 sm:overflow-auto">
                    <div class="relative w-full overflow-auto">
                        <table class="caption-bottom text-sm w-full">
                            <thead class="[&amp;_tr]:border-b border-b-[1px] p-6 border-zinc-800">
                                <tr class="border-zinc-800">
                                    <th
                                        class="h-12 px-4 align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 cursor-pointer pl-5 pr-4 pt-2 text-start border-zinc-800">
                                        <p class="text-xs font-semibold">DATE SUBMITTED</p>
                                    </th>
                                    <th
                                        class="h-12 px-4 align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 cursor-pointer pl-5 pr-4 pt-2 text-start border-zinc-800">
                                        <p class="text-xs font-semibold">REPORT MONTHS</p>
                                    </th>
                                    <th
                                        class="h-12 px-4 align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 cursor-pointer pl-5 pr-4 pt-2 text-start border-zinc-800">
                                        <p class="text-xs font-semibold">REPORT YEAR</p>
                                    </th>
                                    <th
                                        class="h-12 px-4 align-middle font-medium text-muted-foreground cursor-pointer pl-5 pr-4 pt-2 text-start border-zinc-800">
                                        <p class="text-xs font-semibold">MUNICIPALITY</p>
                                    </th>
                                    <th class="h-12 px-4 align-middle font-medium text-muted-foreground cursor-pointer pl-5 pr-4 pt-2 text-start border-zinc-800"
                                        style="width: 100px;">
                                        <p class="text-xs font-semibold"></p>
                                    </th>
                                    <th class="h-12 px-4 align-middle font-medium text-muted-foreground cursor-pointer pl-5 pr-4 pt-2 text-start border-zinc-800"
                                        style="width: 100px;">
                                        <p class="text-xs font-semibold"></p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($files as $file)
                                    <tr
                                        class="border-b border-zinc-800 transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted px-6">
                                        <td
                                            class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 w-max border-b-[1px] py-5 pl-5 pr-4 border-white/10">
                                            <p class="text-sm font-medium">{{ $file->date_submitted }}</p>
                                        </td>
                                        <td
                                            class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 w-max border-b-[1px] py-5 pl-5 pr-4 border-white/10">
                                            <div class="flex w-full items-center gap-[14px]">
                                                <p class="text-sm font-medium">
                                                    {{ implode(', ', json_decode($file->selected_months)) }}</p>
                                            </div>
                                        </td>
                                        <td
                                            class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 w-max border-b-[1px] py-5 pl-5 pr-4 border-white/10">
                                            <div class="flex w-full items-center gap-[14px]">
                                                <p class="text-sm font-medium">{{ $file->report_year }}</p>
                                            </div>
                                        </td>
                                        <td
                                            class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0 w-max border-b-[1px] py-5 pl-5 pr-4 border-white/10">
                                            <div class="flex w-full items-center gap-[14px]">
                                                <p class="text-sm font-medium">{{ $file->municipality }}</p>
                                            </div>
                                        </td>
                                        <td class="p-4 font-bold align-middle border-b-[1px] border-white/10"
                                            style="width: 100px;">
                                            <a href="{{ route('file.download', $file->id) }}"
                                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded text-xs px-3 py-1 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                                Download
                                            </a>
                                        </td>
                                        <td class="p-4 font-bold align-middle border-b-[1px] border-white/10"
                                            style="width: 100px;">
                                            <form action="{{ route('file-upload.destroy', $file->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this file?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-blue-300 font-medium rounded text-xs px-3 py-1 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<script>
    function clearFilters() {
        // Reset the form values
        document.getElementById('filterForm').reset();

        // Optionally, redirect to the page without filters
        window.location.href = "{{ route('files') }}";
    }
</script>
