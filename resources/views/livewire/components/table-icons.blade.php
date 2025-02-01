<div class="flex justify-center space-x-2">
    {{-- Oluştur Butonu --}}
    <button wire:click="create" 
            id="create"
            class="text-green-600 hover:text-green-900"
            title="Yeni {{ $model }} Ekle">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M12 4v16m8-8H4" />
        </svg>
    </button>

    @if($row)
        {{-- Düzenle Butonu --}}
        <button wire:click="edit({{ $row->id }})" 
                id="edit"
                class="text-indigo-600 hover:text-indigo-900"
                title="Düzenle">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
            </svg>
        </button>

        {{-- Sil Butonu --}}
        <button wire:click="delete({{ $row->id }})" 
                id="delete"
                class="text-red-600 hover:text-red-900"
                title="Sil">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </button>

        {{-- Detay Butonu --}}
        <button wire:click="show({{ $row->id }})" 
                id="show"
                class="text-blue-600 hover:text-blue-900"
                title="Detay">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </button>
    @endif
</div> 