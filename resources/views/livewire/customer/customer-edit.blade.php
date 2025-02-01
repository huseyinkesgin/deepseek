<div>
    <x-dialog-modal wire:model.live="showModal" maxWidth="2xl" focusInput="name">
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
            <div class="grid grid-cols-2 gap-4">
                <!-- Sol Kolon -->
                <div class="space-y-2">
                    <x-input-text
                        wire:model="code"
                        name="code"
                        label="Kod"
                        required
                        disabled
                    />

                    <x-input-text
                        wire:model="name"
                        name="name"
                        label="Ad"
                        required
                    />

                    <x-input-text
                        wire:model="surname"
                        name="surname"
                        label="Soyad"
                        required
                    />

                    <x-select-box-o
                        wire:model="company_id"
                        name="company_id"
                        label="Firma"
                        :options="$companies"
                        required
                    />

                    <x-input-text
                        wire:model="phone"
                        name="phone"
                        label="Telefon"
                    />

                    <x-input-text
                        wire:model="email"
                        name="email"
                        label="E-posta"
                    />

                    <x-text-area
                        wire:model="address"
                        name="address"
                        label="Adres"
                    />
                </div>

                <!-- Sağ Kolon -->
                <div class="space-y-2">
                    <x-select-box-o
                        wire:model.live="city_id"
                        name="city_id"
                        label="İl"
                        :options="$cities"
                        required
                    />

                    <x-select-box-o
                        wire:model.live="district_id"
                        name="district_id"
                        label="İlçe"
                        :options="$districts"
                        required
                        :disabled="!$city_id"
                        class="{{ !$city_id ? 'bg-gray-100' : '' }}"
                    />

                    <x-select-box-o
                        wire:model="neighbourhood_id"
                        name="neighbourhood_id"
                        label="Mahalle"
                        :options="$neighbourhoods"
                        required
                        :disabled="!$district_id"
                        class="{{ !$district_id ? 'bg-gray-100' : '' }}"
                    />

                    <x-input-text
                        wire:model="identity_number"
                        name="identity_number"
                        label="TC Kimlik No"
                    />

                    <x-input-text
                        wire:model="tax_number"
                        name="tax_number"
                        label="Vergi No"
                    />

                    <x-input-text
                        wire:model="tax_office"
                        name="tax_office"
                        label="Vergi Dairesi"
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
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
