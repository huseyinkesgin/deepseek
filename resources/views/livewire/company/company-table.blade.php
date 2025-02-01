<div x-data @keydown.window="$wire.handleKeyDown({ key: $event.key })">
    <div class="p-3 flex justify-between">
        <div class="flex space-x-3">
            <div class="pt-2">
                @livewire('company.company-create')
            </div>
            <button wire:click="openEditModal" @if (!$selectedRow) disabled @endif
                class="@if (!$selectedRow) opacity-50 cursor-not-allowed @endif">
                <i class="fa-regular fa-edit fa-lg" style="color:maroon"></i>
            </button>
            <button wire:click="openDeleteModal" @if (!$selectedRow) disabled @endif
                class="@if (!$selectedRow) opacity-50 cursor-not-allowed @endif">
                <i class="fa-regular fa-trash-can fa-lg" style="color:maroon"></i>
            </button>
        </div>

        <div class="flex items-center space-x-4">
            <!-- Arama -->
            <div>
                <x-input-text type="text" wire:model.live.debounce.300ms="search" placeholder="Ara..." />
            </div>

            <!-- Aktif/Pasif Filtresi -->
            <x-select-box wire:model.live="activeFilter" :options="[
                '' => 'Tümü',
                '1' => 'Aktif',
                '0' => 'Pasif',
            ]" />

            <!-- Sayfa Başına Kayıt -->
            <x-select-box wire:model.live="perPage" :options="[
                '10' => '10',
                '25' => '25',
                '50' => '50',
                '100' => '100',
            ]" />
        </div>
    </div>

    @livewire('company.company-delete')
    @livewire('company.company-edit')

    <div class="bg-white py-2">
        <div class="px-3">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th wire:click="sortBy('code')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase border cursor-pointer">
                            Kod
                            @if ($sortField === 'code')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('name')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase border cursor-pointer">
                            Firma Adı
                            @if ($sortField === 'name')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('tax_name')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase border cursor-pointer">
                            Fatura Adı
                            @if ($sortField === 'tax_name')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('city_id')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase border cursor-pointer">
                            İl
                            @if ($sortField === 'city_id')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('district_id')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase border cursor-pointer">
                            İlçe
                            @if ($sortField === 'district_id')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('neighbourhood_id')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase border cursor-pointer">
                            Mahalle
                            @if ($sortField === 'neighbourhood_id')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('tax_number')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase border cursor-pointer">
                            Vergi No
                            @if ($sortField === 'tax_number')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('tax_office')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase border cursor-pointer">
                            Vergi Dairesi
                            @if ($sortField === 'tax_office')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('phone')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase border cursor-pointer">
                            Telefon
                            @if ($sortField === 'phone')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('status')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase border cursor-pointer">
                            Durum
                            @if ($sortField === 'status')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('created_at')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase border cursor-pointer">
                            Oluşturulma Tarihi
                            @if ($sortField === 'created_at')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </th>
                        <th wire:click="sortBy('updated_at')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase border cursor-pointer">
                            Güncellenme Tarihi
                            @if ($sortField === 'updated_at')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($companies as $company)
                        <tr wire:key="row-{{ $company->id }}" wire:click="setSelectedRow({{ $company->id }})"
                            @dblclick="$wire.openEditModal({{ $company->id }})" tabindex="0"
                            class="hover:bg-gray-50 cursor-pointer {{ $selectedRow === $company->id ? 'bg-blue-50 ring-2 ring-blue-400' : '' }}">
                            <td class="px-6 py-2 border">{{ $company->code }}</td>
                            <td class="px-6 py-2 border">{{ $company->name }}</td>
                            <td class="px-6 py-2 border">{{ $company->tax_name }}</td>
                            <td class="px-6 py-2 border">{{ $company->city->name }}</td>
                            <td class="px-6 py-2 border">{{ $company->district->name }}</td>
                            <td class="px-6 py-2 border">{{ $company->neighbourhood->name }}</td>
                            <td class="px-6 py-2 border">{{ $company->tax_number }}</td>
                            <td class="px-6 py-2 border">{{ $company->tax_office }}</td>
                            <td class="px-6 py-2 border">{{ $company->phone }}</td>
                            <td class="px-6 py-2 border">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $company->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $company->status ? 'Aktif' : 'Pasif' }}
                                </span>
                            </td>
                            <td class="px-6 py-2 border">{{ $company->attributeCreatedAt($company->created_at) }}</td>
                            <td class="px-6 py-2 border">{{ $company->attributeUpdatedAt($company->updated_at) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-4 text-center text-gray-500 border">
                                Kayıt bulunamadı.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $companies->links() }}
            </div>
        </div>
    </div>
</div>
