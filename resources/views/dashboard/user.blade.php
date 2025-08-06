<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Pengguna
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('pemesanan.index') }}" class="block w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                            Pesan Tiket Bus
                        </a>
                        <a href="{{ route('pemesanan.my-orders') }}" class="block w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                            Lihat Pesanan Saya
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pesanan Terakhir</h3>
                    @if($pemesanan->count() > 0)
                        <div class="space-y-3">
                            @foreach($pemesanan as $order)
                                <div class="border-l-4 border-blue-400 pl-4">
                                    <p class="font-semibold">{{ $order->id_pemesanan }}</p>
                                    <p class="text-sm text-gray-600">{{ $order->jumlah_tiket }} tiket - Rp {{ number_format($order->total_harga) }}</p>
                                    <p class="text-xs text-gray-500">
                                        Status: <span class="font-semibold">{{ ucfirst($order->status_pembayaran) }}</span>
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">Belum ada pesanan</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Available Armada -->
        <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Armada Tersedia</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($armada as $bus)
                        <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                            <h4 class="font-semibold">{{ $bus->no_unik }}</h4>
                            <p class="text-sm text-gray-600">{{ $bus->rute_asal }} → {{ $bus->rute_tujuan }}</p>
                            <p class="text-sm">Kursi: {{ $bus->jumlah_kursi }}</p>
                            <p class="text-sm">Berangkat: {{ $bus->jam_berangkat->format('H:i') }}</p>
                            <p class="text-lg font-bold text-blue-600">Rp {{ number_format($bus->harga_tiket) }}</p>
                            <a href="{{ route('pemesanan.create', $bus->id) }}" class="mt-2 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                Pesan
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>