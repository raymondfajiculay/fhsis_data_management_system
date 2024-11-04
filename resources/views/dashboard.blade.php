<x-layout>
    <div class="mx-auto flex w-full  flex-col justify-center px-5">
        @if (auth()->user()->role === 'super_admin')
            <p>Admin</p>
        @endif

        {{-- LIST STYLES --}}
        @if (in_array(Auth::user()->role, ['super_admin', 'admin']))
            <div class="flex justify-end gap-2 mb-5">
                <img src="{{ asset('storage/images/list.png') }}" alt="table icon"
                    class="h-10 p-1 cursor-pointer hover:bg-slate-100 rounded" onclick="showTable('listTable')"
                    id="listIcon">
                <img src="{{ asset('storage/images/cells.png') }}" alt="table icon"
                    class="h-10 p-2 cursor-pointer hover:bg-slate-100 rounded" onclick="showTable('cellsTable')"
                    id="cellsIcon">
            </div>
        @endif

        {{-- ROW STYLE --}}
        <div class="relative flex w-full flex-col pt-[20px] md:pt-0" id="listTable" style="display: block;">
            <div class="flex justify-end items-center p-4">
                <form action="{{ route('home') }}" method="GET" class="flex space-x-2">
                    <select name="month" class="border rounded-md p-2 text-sm">
                        <option value="" disabled {{ request('month') ? '' : 'selected' }}>Filter by Report Month
                        </option>
                        @foreach ($months as $month)
                            <option value="{{ $month }}" {{ request('month') === $month ? 'selected' : '' }}>
                                {{ $month }}</option>
                        @endforeach
                    </select>
                    <select name="year" class="border rounded-md p-2 text-sm">
                        <option value="" disabled {{ request('year') ? '' : 'selected' }}>Filter by Report Year
                        </option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ request('year') === $year ? 'selected' : '' }}>
                                {{ $year }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-blue-500 text-white rounded p-2">Filter</button>
                </form>
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
                                        class="h-12 px-4 align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0 cursor-pointer pl-5 pr-4 pt-2 text-start border-zinc-800">
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



        @if (in_array(Auth::user()->role, ['admin', 'super_admin']))
            <div class="flex flex-col flex-grow bg-card text-card-foreground shadow-sm" id="cellsTable"
                style="display: none; height: 60vh;">
                <div class="flex justify-end items-center p-4">
                    <form action="{{ route('home') }}" method="GET" class="flex space-x-2">
                        <select name="year" class="border rounded-md text-sm">
                            <option value="" disabled {{ request('year') ? '' : 'selected' }}>Filter by Report
                                Year
                            </option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{ request('year') === $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-blue-500 text-white rounded p-2">Filter</button>
                    </form>
                </div>
                <div class="overflow-auto border-2 border-black" style="max-height: 100%;">
                    <table class="w-full table-auto">
                        <thead class="bg-slate-400 sticky top-0 left-0">
                            <tr>
                                <!-- Only show the "Municipality" header if the user is a super_admin -->
                                @if (auth()->user()->role === 'super_admin')
                                    <th class="p-4 border-3 border-zinc-800" style="width: 100px;">Municipality</th>
                                @endif

                                <!-- Display month headers for all users -->
                                @foreach ($months as $month)
                                    <th class="p-4 border-3 border-zinc-800" style="width: 100px;">
                                        {{ substr($month, 0, 3) }}
                                    </th>
                                @endforeach
                            </tr>

                        </thead>
                        <tbody>
                            @foreach ($municipalities as $municipality)
                                @if (auth()->user()->role === 'super_admin' || auth()->user()->municipality === $municipality)
                                    <tr>
                                        @if (auth()->user()->role === 'super_admin')
                                            <td class="p-4 border border-zinc-800" style="width: 200px;">
                                                {{ $municipality }}
                                            </td>
                                        @endif
                                        @foreach ($months as $month)
                                            <td class="p-4 text-center border border-zinc-800"
                                                style="width: 100px; background-color:
                                        @if (
                                            $files->contains(function ($file) use ($municipality, $month) {
                                                $selectedMonths = json_decode($file->selected_months, true);
                                                return $file->municipality === $municipality && in_array($month, $selectedMonths);
                                            })) green
                                        @elseif (
                                            \Carbon\Carbon::parse($month)->isFuture() &&
                                                !$files->contains(function ($file) use ($municipality, $month) {
                                                    $selectedMonths = json_decode($file->selected_months, true);
                                                    return $file->municipality === $municipality && in_array($month, $selectedMonths);
                                                })) grey
                                        @else red @endif;">
                                            </td>
                                        @endforeach
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif


    </div>

    <script>
        function showTable(tableId) {
            document.getElementById('listTable').style.display = 'none';
            document.getElementById('cellsTable').style.display = 'none';

            // Show the selected table
            document.getElementById(tableId).style.display = 'block';
        }
    </script>
</x-layout>
