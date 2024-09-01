<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Asset Expirations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <table id="expirations-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Asset Name</th>
                            <th scope="col" class="px-6 py-3">Asset Type</th>
                            <th scope="col" class="px-6 py-3">Expiration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assetsWithExpiration as $asset)
                            @php
                                $expirationDate = $asset['expiration'];
                                $now = \Carbon\Carbon::now();
                                $oneWeekFromNow = $now->copy()->addWeek();
                                $rowClass = 'border-b dark:bg-gray-800 dark:border-gray-700';
                                if ($expirationDate->lte($now)) {
                                    $rowClass .= ' bg-red-100 dark:bg-red-900';
                                } elseif ($expirationDate->lte($oneWeekFromNow)) {
                                    $rowClass .= ' bg-yellow-100 dark:bg-yellow-900';
                                } else {
                                    $rowClass .= ' bg-green-100 dark:bg-green-900';
                                }
                            @endphp
                            <tr class="{{ $rowClass }}" onclick="window.location='{{ route('structure.asset.show', [$asset['type_id'], $asset['id']]) }}'" style="cursor: pointer;">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $asset['name'] ?? $asset['id'] }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $asset['type'] }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $asset['expiration']->diffForHumans() }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const expirationsTable = new DataTable('#expirations-table', {
            responsive: true
        });
    </script>
</x-app-layout>