<x-layout>
    <div class="mx-auto flex w-full  flex-col justify-center px-5">
        <h1 class="text-4xl font-bold text-center mt-5">Dashboard</h1>
        {{-- TABLE STYLE --}}

        <div class="flex flex-col flex-grow bg-card text-card-foreground shadow-sm" id="cellsTable" style=" height: 80vh;">
            <div class="flex justify-end items-center p-4">
                <form action="{{ route('dashboard') }}" method="GET" class="flex space-x-2">
                    <select name="year" class="border rounded-md p-2 text-sm">
                        <option value="" disabled {{ !$selectedYear ? 'selected' : '' }}>Filter by Report Year
                            @foreach ($years as $year)
                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                            {{ $year }}</option>
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
                                        <td class="p-2 text-center border border-zinc-800 bg-slate-200"
                                            style="width: 100px;">

                                            @if (
                                                $files->contains(function ($file) use ($municipality, $month) {
                                                    $selectedMonths = json_decode($file->selected_months, true);
                                                    return $file->municipality === $municipality && in_array($month, $selectedMonths);
                                                }))
                                                <img src="{{ asset('storage/images/checked.png') }}" alt="Check"
                                                    style="width: 20px; height: 20px;" class="mx-auto" />
                                            @else
                                                <img src="{{ asset('storage/images/cancel.png') }}" alt="Check"
                                                    style="width: 20px; height: 20px;" class="mx-auto" />
                                            @endif
                                        </td>
                                    @endforeach

                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</x-layout>
