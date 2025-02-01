<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <x-dialog-modal wire:model.live="showModal" maxWidth="sm">
        <x-slot name="title">
            <div class="flex justify-end">
                <div class="space-x-3">
                    <button wire:click="delete"><i class="fa-regular fa-trash-can fa-lg"></i></button>
                    <button wire:click="close"><i class="fa-solid fa-xmark fa-lg"></i></button>
                </div>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="p-3">
                <div class="mb-3">
                    <span class="font-semibold">{{ $code }}</span>
                    kodlu
                    <span class="font-semibold">{{ $name }} {{ $surname }}</span>
                    müşterisini silmek istediğinize emin misiniz?
                </div>
                <div class="text-sm text-red-500">
                    Bu işlem geri alınamaz!
                </div>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
