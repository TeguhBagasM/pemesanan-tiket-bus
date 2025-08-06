<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pesan Tiket Bus
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Search Form -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <form method="GET" action="{{ route('pemesanan.search') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rute Asal</label>
                        <input type="text" name="rute_asal" value="{{ request('rute_asal') }}" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Kota asal">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rute Tujuan</label>
                        <input type="text" name="rute_tujuan" value="{{ request('rute_tujuan') }}" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Kota tujuan">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Available Armada -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Armada Tersedia</h3>
                @if($armada->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($armada as $bus)
                            <div class="border rounded-lg p-6 hover:shadow-lg transition-shadow">
                                <div class="flex justify-between items-start mb-4">
                                    <h4 class="text-xl font-semibold text-gray-900">{{ $bus->no_unik }}</h4>
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                        {{ $bus->jumlah_kursi }} kursi
                                    </span>
                                </div>
                                
                                <div class="space-y-2 mb-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Rute:</span>
                                        <span class="font-medium">{{ $bus->rute_asal }} → {{ $bus->rute_tujuan }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Supir:</span>
                                        <span class="font-medium">{{ $bus->supir }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Berangkat:</span>
                                        <span class="font-medium">{{ $bus->jam_berangkat->format('H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">No Kendaraan:</span>
                                        <span class="font-medium">{{ $bus->no_kendaraan }}</span>
                                    </div>
                                </div>
                                
                                <div class="border-t pt-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($bus->harga_tiket) }}</p>
                                            <p class="text-sm text-gray-500">per tiket</p>
                                        </div>
                                        <a href="{{ route('pemesanan.create', $bus->id) }}" 
                                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Pesan Sekarang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6">
                        {{ $armada->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-500 text-lg">Tidak ada armada tersedia</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>