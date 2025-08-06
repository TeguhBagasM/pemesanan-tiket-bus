<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pesan Tiket - {{ $armada->no_unik }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Armada Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Armada</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">No Unik:</span>
                            <span class="font-medium">{{ $armada->no_unik }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Rute:</span>
                            <span class="font-medium">{{ $armada->rute_asal }} → {{ $armada->rute_tujuan }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Supir:</span>
                            <span class="font-medium">{{ $armada->supir }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jam Berangkat:</span>
                            <span class="font-medium">{{ $armada->jam_berangkat->format('H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jumlah Kursi:</span>
                            <span class="font-medium">{{ $armada->jumlah_kursi }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Harga per Tiket:</span>
                            <span class="font-medium text-blue-600 text-lg">Rp {{ number_format($armada->harga_tiket) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Form Pemesanan</h3>
                    
                    <form method="POST" action="{{ route('pemesanan.store') }}">
                        @csrf
                        <input type="hidden" name="armada_id" value="{{ $armada->id }}">
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Tiket</label>
                            <input type="number" name="jumlah_tiket" min="1" max="10" value="1" required
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                id="jumlah_tiket">
                            @error('jumlah_tiket')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Keberangkatan</label>
                            <input type="date" name="jadwal_pemesanan" required
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            @error('jadwal_pemesanan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-semibold text-gray-900 mb-2">Ringkasan Pemesanan</h4>
                            <div class="flex justify-between mb-2">
                                <span>Jumlah Tiket:</span>
                                <span id="display_jumlah">1</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span>Harga per Tiket:</span>
                                <span>Rp {{ number_format($armada->harga_tiket) }}</span>
                            </div>
                            <div class="flex justify-between font-bold text-lg border-t pt-2">
                                <span>Total:</span>
                                <span class="text-blue-600" id="display_total">Rp {{ number_format($armada->harga_tiket) }}</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded">
                            Lanjut ke Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('jumlah_tiket').addEventListener('input', function() {
            const jumlah = parseInt(this.value) || 1;
            const harga = {{ $armada->harga_tiket }};
            const total = jumlah * harga;
            
            document.getElementById('display_jumlah').textContent = jumlah;
            document.getElementById('display_total').textContent = 'Rp ' + total.toLocaleString('id-ID');
        });
    </script>
</x-app-layout>