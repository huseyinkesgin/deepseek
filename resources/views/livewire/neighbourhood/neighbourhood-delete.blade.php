<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <x-dialog-modal wire:model.live="showModal" maxWidth="sm">
        <x-slot name="title">
            <div class="flex justify-between">
                <span class="font-bold text-red-600">Kayıt Silme</span>
                <button wire:click="close">
                    <i class="fa-solid fa-xmark fa-lg"></i>
                </button>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-3">
                <p class="text-gray-600">
                    <span class="font-bold">{{ $neighbourhoodName }}</span> mahallesini silmek istediğinize emin misiniz?
                </p>

                <div class="flex justify-end space-x-3 pt-5">
                    <button wire:click="close" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                        İptal
                    </button>
                    <button wire:click="delete" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                        Sil
                    </button>
                </div>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
