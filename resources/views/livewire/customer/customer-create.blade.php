<div>
    <button wire:click="openModal">
        <i class="fa-regular fa-plus fa-lg" style="color:maroon"></i>
    </button>

    <x-dialog-modal wire:model.live="showModal" maxWidth="2xl" focusInput="name">
        <x-slot name="title">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-700">Yeni Müşteri Kaydı</h2>
                <div class="space-x-3">
                    <button wire:click="save" class="hover:text-green-500">
                        <i class="fa-regular fa-save fa-lg"></i>
                    </button>
                    <button wire:click="resetForm" class="hover:text-blue-500">
                        <i class="fa-solid fa-delete-left fa-lg"></i>
                    </button>
                    <button wire:click="close" class="hover:text-red-500">
                        <i class="fa-solid fa-xmark fa-lg"></i>
                    </button>
                </div>
            </div>
        </x-slot>

        <x-slot name="content">
            <div class="bg-white p-4 rounded-lg">
                <div class="grid grid-cols-2 gap-6">
                    <!-- Kişisel Bilgiler -->
                    <fieldset class="border border-gray-300 rounded-lg p-4">
                        <legend class="text-sm font-semibold px-2 text-maroon-600">Kişisel Bilgiler</legend>
                        <div class="space-y-3">
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

                            <div class="grid grid-cols-3 gap-4 items-start">
                                <label class="block text-sm font-medium text-red-800">
                                    Firma <span class="text-red-500">*</span>
                                </label>
                                <div class="col-span-2 flex items-center space-x-1">
                                    <x-select-box-o
                                        wire:model="company_id"
                                        name="company_id"
                                        :options="$companies"
                                        required
                                        class="w-full"
                                    />
                                    <button class="p-1.5 hover:text-maroon-600" wire:click="$dispatch('showCompanyCreateModal')">
                                        <i class="fa-regular fa-plus fa-lg"></i>
                                    </button>
                                </div>
                            </div>

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
                        </div>
                    </fieldset>

                    <!-- Adres Bilgileri -->
                    <fieldset class="border border-gray-300 rounded-lg p-4">
                        <legend class="text-sm font-semibold px-2 text-maroon-600">Adres Bilgileri</legend>
                        <div class="space-y-3">
                            <div class="grid grid-cols-3 gap-4 items-start">
                                <label class="block text-sm font-medium text-red-800">
                                    İl <span class="text-red-500">*</span>
                                </label>
                                <div class="col-span-2 flex items-center space-x-1">
                                    <x-select-box-o
                                        wire:model.live="city_id"
                                        name="city_id"
                                        :options="$cities"
                                        required
                                        class="w-full"
                                    />
                                    <button class="p-1.5 hover:text-maroon-600" wire:click="$dispatch('showCityCreateModal')">
                                        <i class="fa-regular fa-plus fa-lg"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4 items-start">
                                <label class="block text-sm font-medium text-red-800">
                                    İlçe <span class="text-red-500">*</span>
                                </label>
                                <div class="col-span-2 flex items-center space-x-1">
                                    <x-select-box-o
                                        wire:model.live="district_id"
                                        name="district_id"
                                        :options="$districts"
                                        required
                                        :disabled="!$city_id"
                                        class="w-full {{ !$city_id ? 'bg-gray-100' : '' }}"
                                    />
                                    <button class="p-1.5 hover:text-maroon-600"
                                            wire:click="$dispatch('showDistrictCreateModal')"
                                            @if(!$city_id) disabled @endif>
                                        <i class="fa-regular fa-plus fa-lg"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4 items-start">
                                <label class="block text-sm font-medium text-red-800">
                                    Mahalle <span class="text-red-500">*</span>
                                </label>
                                <div class="col-span-2 flex items-center space-x-1">
                                    <x-select-box-o
                                        wire:model="neighbourhood_id"
                                        name="neighbourhood_id"
                                        :options="$neighbourhoods"
                                        required
                                        :disabled="!$district_id"
                                        class="w-full {{ !$district_id ? 'bg-gray-100' : '' }}"
                                    />
                                    <button class="p-1.5 hover:text-maroon-600"
                                            wire:click="$dispatch('showNeighbourhoodCreateModal')"
                                            @if(!$district_id) disabled @endif>
                                        <i class="fa-regular fa-plus fa-lg"></i>
                                    </button>
                                </div>
                            </div>

                            <x-text-area
                                wire:model="address"
                                name="address"
                                label="Açık Adres"
                            />
                        </div>
                    </fieldset>

                    <!-- Vergi Bilgileri -->
                    <fieldset class="border border-gray-300 rounded-lg p-4">
                        <legend class="text-sm font-semibold px-2 text-maroon-600">Vergi Bilgileri</legend>
                        <div class="space-y-3">
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
                        </div>
                    </fieldset>

                    <!-- Diğer Bilgiler -->
                    <fieldset class="border border-gray-300 rounded-lg p-4">
                        <legend class="text-sm font-semibold px-2 text-maroon-600">Diğer Bilgiler</legend>
                        <div class="space-y-3">
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
                    </fieldset>
                </div>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>
