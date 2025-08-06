<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Verifikasi Pembayaran
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                @if($pembayaran->count() > 0)
                    <div class="space-y-4">
                        @foreach($pembayaran as $payment)
                            <div class="border rounded-lg p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h4 class="font-semibold text-lg mb-2">{{ $payment->id_pembayaran }}</h4>
                                        <div class="space-y-2 text-sm">
                                            <p><span class="text-gray-600">Pengguna:</span> {{ $payment->pemesanan->pengguna->name }}</p>
                                            <p><span class="text-gray-600">ID Pemesanan:</span> {{ $payment->pemesanan->id_pemesanan }}</p>
                                            <p><span class="text-gray-600">Metode:</span> {{ ucfirst($payment->metode_pembayaran) }}</p>
                                            <p><span class="text-gray-600">Nominal:</span> Rp {{ number_format($payment->nominal) }}</p>
                                            <p><span class="text-gray-600">Tanggal:</span> {{ $payment->tgl_pembayaran->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        @if($payment->bukti_pembayaran)
                                            <p class="text-sm text-gray-600 mb-2">Bukti Pembayaran:</p>
                                            <img src="{{ Storage::url($payment->bukti_pembayaran) }}" 
                                                 alt="Bukti Pembayaran" 
                                                 class="w-full max-w-sm h-48 object-cover rounded-lg">
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="mt-4 flex space-x-3">
                                    <form method="POST" action="{{ route('pembayaran.verify', $payment->id) }}">
                                        @csrf
                                        <button type="submit" 
                                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                            Verifikasi
                                        </button>
                                    </form>
                                    
                                    <form method="POST" action="{{ route('pembayaran.reject', $payment->id) }}">
                                        @csrf
                                        <button type="submit" 
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                                onclick="return confirm('Yakin ingin menolak pembayaran ini?')">
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6">
                        {{ $pembayaran->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-500 text-lg">Tidak ada pembayaran yang perlu diverifikasi</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>