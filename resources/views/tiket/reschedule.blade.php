<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reschedule Tiket - {{ $tiket->id_tiket }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">Detail Tiket</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p><span class="font-medium">ID Tiket:</span> {{ $tiket->id_tiket }}</p>
                        <p><span class="font-medium">Jadwal Saat Ini:</span> {{ $tiket->pembayaran->pemesanan->jadwal_pemesanan }}</p>
                        <p><span class="font-medium">Harga:</span> Rp {{ number_format($tiket->harga_tiket) }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('tiket.reschedule.store') }}">
                    @csrf
                    <input type="hidden" name="tiket_id" value="{{ $tiket->id }}">
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jadwal Baru</label>
                        <input type="date" name="jadwal_baru" required
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        @error('jadwal_baru')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <p class="text-sm text-yellow-700">
                            <strong>Catatan:</strong> Permintaan reschedule akan diproses oleh admin. 
                            Tidak ada biaya tambahan untuk reschedule.
                        </p>
                    </div>

                    <div class="flex items-center justify-end space-x-4">
                        <a href="{{ route('dashboard') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Batal
                        </a>
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Ajukan Reschedule
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>