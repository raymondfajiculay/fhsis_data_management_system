<x-layout>
    <div class="flex flex-col flex-grow rounded-lg border bg-card text-card-foreground shadow-sm p-4 border-zinc-800">
        <div class="overflow-auto" style="max-height: 100%;"> <!-- Make the table scrollable here -->
            <table class="w-full table-auto">
                <thead class="bg-white sticky top-0 z-10">
                    <tr>
                        <th class="text-left p-4 bg-white" style="width: 200px;">Municipality</th>
                        <!-- Set a width to align with tbody -->
                        @foreach ($months as $month)
                            <th class="text-center p-4 bg-white" style="width: 100px;">{{ substr($month, 0, 3) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($municipalities as $municipality)
                        <tr>
                            <td class="p-4 border border-zinc-800" style="width: 200px;">{{ $municipality }}</td>
                            <!-- Keep width consistent -->
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
