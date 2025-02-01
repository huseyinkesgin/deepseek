<div class="bg-white py-2">
    <div class="px-3 flex space-x-3 justify-start">
        <!-- Yeni Ekle Butonu -->
        <button wire:click="$dispatch('showForm', { component: '{{ $formComponent }}', mode: 'create' })" id="create">
            <i class="fa-regular fa-file fa-2xl" style="color:maroon"></i>
        </button>

        @if($row)
            <!-- Düzenle Butonu -->
            <button wire:click="$dispatch('showForm', { component: '{{ $formComponent }}', mode: 'edit', id: {{ $row->id }} })" id="edit">
                <i class="fa-regular fa-pen-to-square fa-2xl" style="color:maroon"></i>
            </button>

            <!-- Sil Butonu -->
            <button wire:click="$dispatch('showDeleteModal', { component: '{{ $formComponent }}', id: {{ $row->id }} })" id="delete">
                <i class="fa-regular fa-trash-can fa-2xl" style="color:maroon"></i>
            </button>

            <!-- Diğer Butonlar -->
            <button id="approve">
                <i class="fa-solid fa-check fa-2xl" style="color:maroon"></i>
            </button>

            <button id="filter">
                <i class="fa-solid fa-filter fa-2xl" style="color:maroon"></i>
            </button>

            <button id="print">
                <i class="fa-solid fa-print fa-2xl" style="color:maroon"></i>
            </button>

            <button id="export">
                <i class="fa-solid fa-file-export fa-2xl" style="color:maroon"></i>
            </button>
        @endif
    </div>
</div>
