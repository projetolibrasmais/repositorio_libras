@props(['name', 'title' => 'Confirmar Exclusão Permanente', 'message' => 'Tem certeza que deseja excluir este registro permanentemente? Esta ação não pode ser desfeita!'])

<x-modal :name="$name" maxWidth="md" focusable>
    <div class="p-6">
        <!-- Header -->
        <div class="flex items-center mb-4">
            <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                <i class="ph ph-warning text-red-600 text-2xl"></i>
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
                x-on:click="confirmForceDelete()"
                class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                <i class="ph ph-trash mr-2"></i>
                Excluir Permanentemente
            </button>
        </div>
    </div>
</x-modal>
