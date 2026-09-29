@props(['sortableColumns' => [], 'currentSort' => null, 'currentDirection' => 'asc'])

<div class="admin-table-scroll max-w-full overflow-x-auto bg-white rounded-lg shadow" tabindex="0" aria-label="Tabela com rolagem horizontal em telas pequenas">
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
