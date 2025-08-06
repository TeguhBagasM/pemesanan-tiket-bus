<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pembayaran - {{ $pemesanan->id_pemesanan }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Order Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">ID Pemesanan:</span>
                            <span class="font-medium">{{ $pemesanan->id_pemesanan }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal Pemesanan:</span>
                            <span class="font-medium">{{ $pemesanan->tgl_pemesanan }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jadwal Keberangkatan:</span>
                            <span class="font-medium">{{ $pemesanan->jadwal_pemesanan }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jumlah Tiket:</span>
                            <span class="font-medium">{{ $pemesanan->jumlah_tiket }}</span>
                        </div>
                        <div class="flex justify-between font-bold text-lg border-t pt-3">
                            <span>Total Pembayaran:</span>
                            <span class="text-blue-600">Rp {{ number_format($pemesanan->total_harga) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Form Pembayaran</h3>
                    
                    <form method="POST" action="{{ route('pembayaran.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="pemesanan_id" value="{{ $pemesanan->id }}">
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                            <select name="metode_pembayaran" required
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Pilih Metode Pembayaran</option>
                                <option value="transfer">Transfer Bank</option>
                                <option value="ewallet">E-Wallet</option>
                                <option value="cash">Cash</option>
                            </select>
                            @error('metode_pembayaran')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Pembayaran</label>
                            <input type="file" name="bukti_pembayaran" accept="image/*" required
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p class="mt-1 text-sm text-gray-500">Upload foto bukti pembayaran (JPG, PNG, max 2MB)</p>
                            @error('bukti_pembayaran')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <h4 class="font-semibold text-yellow-800 mb-2">Informasi Pembayaran</h4>
                            <div class="text-sm text-yellow-700 space-y-1">
                                <p><strong>Bank BCA:</strong> 1234-5678-9012 a.n. PT Bus Transport</p>
                                <p><strong>Bank Mandiri:</strong> 9876-5432-1098 a.n. PT Bus Transport</p>
                                <p><strong>Dana/OVO/GoPay:</strong> 0812-3456-7890</p>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-4 rounded">
                            Upload Bukti Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>