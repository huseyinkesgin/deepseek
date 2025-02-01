<div>
    <x-dialog-modal wire:model.live="showModal" maxWidth="sm" focusInput="name">
        <x-slot name="title">
            <div class="flex justify-end">
                <div class="space-x-3">
                    <button wire:click="save"><i class="fa-regular fa-save fa-lg"></i></button>
                    <button wire:click="resetForm"><i class="fa-solid fa-delete-left fa-lg"></i></button>
                    <button wire:click="close"><i class="fa-solid fa-xmark fa-lg"></i></button>
                </div>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="space-y-2"
            >
                <x-input-text
                    wire:model="code"
                    name="code"
                    label="Kod"
                    disabled
                />

                <x-input-text
                    wire:model="name"
                    name="name"
                    label="İl Adı"
                    required
                />

                <x-select-box
                wire:model="status"
                name="status"
                label="Durum"
                :options="[
                    '1' => 'AKTİF',
                    '0' => 'PASİF'
                ]"
            />

                <x-text-area
                    wire:model="description"
                    name="description"
                    label="Açıklama"
                />
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
