<div>
    <button wire:click="openModal">
        <i class="fa-regular fa-plus fa-lg" style="color:maroon"></i>
    </button>

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
                        label="Firma Adı"
                        required
                    />

                    <x-input-text
                        wire:model="order_name"
                        name="order_name"
                        label="Sipariş Adı"
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
                    <div class="flex items-center space-x-2">
                        <div class="flex-grow">
                            <x-select-box-o
                                wire:model.live="city_id"
                                name="city_id"
                                label="İl"
                                :options="$cities"
                            />
                        </div>
                        <div class="pt-1">
                            @livewire('city.city-create')
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <div class="flex-grow">
                            <x-select-box-o
                                wire:model.live="district_id"
                                name="district_id"
                                label="İlçe"
                                :options="$districts"
                                :disabled="!$city_id"
                                class="{{ !$city_id ? 'bg-gray-100' : '' }}"
                            />
                        </div>
                        <div class="pt-1">
                            @livewire('district.district-create')
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <div class="flex-grow">
                            <x-select-box-o
                                wire:model="neighbourhood_id"
                                name="neighbourhood_id"
                                label="Mahalle"
                                :options="$neighbourhoods"
                                :disabled="!$district_id"
                                class="{{ !$district_id ? 'bg-gray-100' : '' }}"
                            />
                        </div>
                        <div class="pt-1">
                            @livewire('neighbourhood.neighbourhood-create')
                        </div>
                    </div>

                    <x-input-text
                        wire:model="mersis_no"
                        name="mersis_no"
                        label="Mersis No"
                    />

                    <x-input-text
                        wire:model="kep_address"
                        name="kep_address"
                        label="KEP Adresi"
                    />

                    <x-input-text
                        wire:model="iban"
                        name="iban"
                        label="IBAN"
                    />

                    <x-input-text
                        wire:model="bank_name"
                        name="bank_name"
                        label="Banka Adı"
                    />

                    <x-input-text
                        wire:model="bank_account_no"
                        name="bank_account_no"
                        label="Banka Hesap No"
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