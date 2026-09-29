@props([
    'roles',
    'selected' => [],
    'disabled' => false,
])

@php
    $selectedRoles = collect($selected)->filter()->values()->all();
@endphp

<div x-data="{
        open: false,
        selected: @js($selectedRoles),
        toggle(role) {
            if (this.selected.includes(role)) {
                this.selected = this.selected.filter(item => item !== role);
            } else {
                this.selected.push(role);
            }
        }
    }"
    @click.outside="open = false"
    class="relative">

    @if ($disabled)
        @foreach ($selectedRoles as $selectedRole)
            <input type="hidden" name="roles[]" value="{{ $selectedRole }}">
        @endforeach
    @endif

    <button id="roles" type="button"
        @click="if (!@js($disabled)) open = !open"
        :aria-expanded="open.toString()"
        aria-haspopup="listbox"
        {{ $disabled ? 'disabled' : '' }}
        class="min-h-[46px] w-full flex items-center justify-between gap-3 pl-10 pr-4 py-2 bg-white border border-gray-300 rounded-lg text-left focus:ring-2 focus:ring-logo-sky focus:border-logo-sky disabled:bg-gray-100 disabled:text-gray-500 disabled:cursor-not-allowed @error('roles') border-red-500 @enderror">
        <span x-show="selected.length === 0" class="text-gray-500">Selecione uma ou mais funções</span>
        <span x-show="selected.length > 0" class="flex flex-wrap gap-1.5">
            <template x-for="role in selected" :key="role">
                <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-brand-100 text-brand-800 text-sm font-medium" x-text="role"></span>
            </template>
        </span>
        <i class="ph ph-caret-down shrink-0 text-gray-500 transition-transform" :class="open && 'rotate-180'" aria-hidden="true"></i>
    </button>

    @unless ($disabled)
        <div x-show="open" x-transition x-cloak
            class="absolute z-[100] mt-2 w-full overflow-hidden rounded-lg border border-gray-200 bg-white shadow-xl"
            role="listbox" aria-multiselectable="true">
            <div class="max-h-64 overflow-y-auto p-2 space-y-1">
                @forelse ($roles as $role)
                    <label class="flex items-center gap-3 px-3 py-2.5 rounded-md cursor-pointer hover:bg-brand-50 transition-colors"
                        :class="selected.includes(@js($role->name)) && 'bg-brand-50'">
                        <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                            x-model="selected"
                            class="rounded border-gray-300 text-brand-600 focus:ring-logo-sky">
                        <span class="flex-1 text-sm font-medium text-gray-800">{{ $role->name }}</span>
                        <i x-show="selected.includes(@js($role->name))" class="ph ph-check text-brand-600" aria-hidden="true"></i>
                    </label>
                @empty
                    <p class="px-3 py-4 text-sm text-gray-500 text-center">Nenhuma função cadastrada.</p>
                @endforelse
            </div>
        </div>
    @endunless
</div>
