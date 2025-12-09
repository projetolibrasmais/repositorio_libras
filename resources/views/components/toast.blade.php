<!-- Toast Container -->
<div x-data="toastManager()" 
     @toast.window="addToast($event.detail)"
     class="fixed top-4 right-4 z-50 space-y-3 max-w-sm w-full">
    
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.show"
             x-transition:enter="transform transition ease-out duration-300"
             x-transition:enter-start="translate-x-full opacity-0"
             x-transition:enter-end="translate-x-0 opacity-100"
             x-transition:leave="transform transition ease-in duration-200"
             x-transition:leave-start="translate-x-0 opacity-100"
             x-transition:leave-end="translate-x-full opacity-0"
             :class="{
                'bg-green-50 border-green-200': toast.type === 'success',
                'bg-red-50 border-red-200': toast.type === 'error',
                'bg-yellow-50 border-yellow-200': toast.type === 'warning',
                'bg-blue-50 border-blue-200': toast.type === 'info'
             }"
             class="flex items-start gap-3 p-4 rounded-lg border shadow-lg">
            
            <!-- Icon -->
            <div class="flex-shrink-0">
                <template x-if="toast.type === 'success'">
                    <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="ph ph-check text-green-600 text-lg"></i>
                    </div>
                </template>
                <template x-if="toast.type === 'error'">
                    <div class="w-6 h-6 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="ph ph-x text-red-600 text-lg"></i>
                    </div>
                </template>
                <template x-if="toast.type === 'warning'">
                    <div class="w-6 h-6 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="ph ph-warning text-yellow-600 text-lg"></i>
                    </div>
                </template>
                <template x-if="toast.type === 'info'">
                    <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="ph ph-info text-blue-600 text-lg"></i>
                    </div>
                </template>
            </div>

            <!-- Content -->
            <div class="flex-1 min-w-0">
                <p x-text="toast.message" 
                   :class="{
                       'text-green-800': toast.type === 'success',
                       'text-red-800': toast.type === 'error',
                       'text-yellow-800': toast.type === 'warning',
                       'text-blue-800': toast.type === 'info'
                   }"
                   class="text-sm font-medium"></p>
            </div>

            <!-- Close Button -->
            <button @click="removeToast(toast.id)"
                    :class="{
                        'text-green-600 hover:text-green-800': toast.type === 'success',
                        'text-red-600 hover:text-red-800': toast.type === 'error',
                        'text-yellow-600 hover:text-yellow-800': toast.type === 'warning',
                        'text-blue-600 hover:text-blue-800': toast.type === 'info'
                    }"
                    class="flex-shrink-0 transition-colors">
                <i class="ph ph-x text-lg"></i>
            </button>
        </div>
    </template>
</div>

<script>
    function toastManager() {
        return {
            toasts: [],
            nextId: 1,

            addToast(data) {
                const id = this.nextId++;
                const toast = {
                    id: id,
                    message: data.message || 'Notificação',
                    type: data.type || 'info',
                    show: true
                };

                this.toasts.push(toast);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    this.removeToast(id);
                }, data.duration || 5000);
            },

            removeToast(id) {
                const index = this.toasts.findIndex(t => t.id === id);
                if (index > -1) {
                    this.toasts[index].show = false;
                    setTimeout(() => {
                        this.toasts.splice(index, 1);
                    }, 300);
                }
            }
        }
    }
</script>
