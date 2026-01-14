@props(['name', 'title' => 'Confirmar Restauração', 'message' => 'Tem certeza que deseja restaurar este registro?'])

<x-modal :name="$name" maxWidth="md" focusable>
    <div class="p-6">
        <!-- Header -->
        <div class="flex items-center mb-4">
            <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                <i class="ph ph-arrow-counter-clockwise text-green-600 text-2xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
            </div>
        </div>

        <!-- Message -->
        <div class="mb-6">
            <p class="text-gray-600">{{ $message }}</p>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3">
            <button 
                type="button"
                x-on:click="$dispatch('close-modal', '{{ $name }}')"
                class="px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                Cancelar
            </button>
            <button 
                type="button"
                x-on:click="confirmRestore()"
                class="px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                <i class="ph ph-arrow-counter-clockwise mr-2"></i>
                Restaurar
            </button>
        </div>
    </div>
</x-modal>
