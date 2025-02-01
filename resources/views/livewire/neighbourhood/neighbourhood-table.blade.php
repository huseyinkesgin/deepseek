<div x-data @keydown.window="$wire.handleKeyDown({ key: $event.key })">
    <div class="p-3 flex justify-between">
        <div class="flex space-x-3">
            <div class="pt-2">
                @livewire('neighbourhood.neighbourhood-create')
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

        <div class="flex justify-end">
            <!-- Arama -->

        
                <x-input-text type="text" wire:model.live.debounce.300ms="search" placeholder="Ara..."
                   />
        

        
                <!-- Aktif/Pasif Filtresi -->
                <x-select-box wire:model.live="activeFilter" class="" :options="[
                    '1' => 'Aktif',
                    '0' => 'Pasif',
                ]" />
         


         
                <!-- Sayfa Başına Kayıt -->
                <x-select-box wire:model.live="perPage" :options="[
                    '10' => '10',
                    '20' => '20',
                    '50' => '50',
                    '100' => '100',
                ]" />
        
        </div>
    </div>

    @livewire('neighbourhood.neighbourhood-delete')
    @livewire('neighbourhood.neighbourhood-edit')

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
                        <th wire:click="sortBy('name')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase border cursor-pointer">
                            Mahalle Adı
                            @if ($sortField === 'name')
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
                        <th wire:click="sortBy('description')"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase border cursor-pointer">
                            Açıklama
                            @if ($sortField === 'description')
                                <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                            @endif
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($neighbourhoods as $neighbourhood)
                        <tr wire:key="row-{{ $neighbourhood->id }}" wire:click="setSelectedRow({{ $neighbourhood->id }})"
                            @dblclick="$wire.openEditModal({{ $neighbourhood->id }})" tabindex="0"
                            class="hover:bg-gray-50 cursor-pointer {{ $selectedRow === $neighbourhood->id ? 'bg-blue-50 ring-2 ring-blue-400' : '' }}">
                            <td class="px-6 py-2 border">{{ $neighbourhood->code }}</td>
                            <td class="px-6 py-2 border">{{ $neighbourhood->district->city->name }}</td>
                            <td class="px-6 py-2 border">{{ $neighbourhood->district->name }}</td>
                            <td class="px-6 py-2 border">{{ $neighbourhood->name }}</td>
                            <td class="px-6 py-2 border">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $neighbourhood->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $neighbourhood->status ? 'Aktif' : 'Pasif' }}
                                </span>
                            </td>
                            <td class="px-6 py-2 border">{{ $neighbourhood->attributeCreatedAt($neighbourhood->created_at) }}</td>
                            <td class="px-6 py-2 border">{{ $neighbourhood->attributeUpdatedAt($neighbourhood->updated_at) }}</td>
                            <td class="px-6 py-2 border">{{ $neighbourhood->description }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500 border">
                                Kayıt bulunamadı.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $neighbourhoods->links() }}
            </div>
        </div>
    </div>
</div>
