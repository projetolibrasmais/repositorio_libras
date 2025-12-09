@props(['sortableColumns' => [], 'currentSort' => null, 'currentDirection' => 'asc'])

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                {{ $slot }}
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            {{ $body ?? '' }}
        </tbody>
    </table>
</div>
