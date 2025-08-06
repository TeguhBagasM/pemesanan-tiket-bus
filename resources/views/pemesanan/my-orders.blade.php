<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pesanan Saya
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                @if($pemesanan->count() > 0)
                    <div class="space-y-4">
                        @foreach($pemesanan as $order)
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <h4 class="font-semibold text-lg">{{ $order->id_pemesanan }}</h4>
                                        <p class="text-sm text-gray-600">{{ $order->tgl_pemesanan }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Jadwal Keberangkatan</p>
                                        <p class="font-medium">{{ $order->jadwal_pemesanan }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">{{ $order->jumlah_tiket }} tiket</p>
                                        <p class="font-bold text-blue-600">Rp {{ number_format($order->total_harga) }}</p>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span @class([
                                            'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                            'bg-green-100 text-green-800' => $order->status_pembayaran === 'paid',
                                            'bg-yellow-100 text-yellow-800' => $order->status_pembayaran === 'pending',
                                            'bg-red-100 text-red-800' => !in_array($order->status_pembayaran, ['paid', 'pending']),
                                        ])>
                                            {{ ucfirst($order->status_pembayaran) }}
                                        </span>

                                        <a href="{{ route('pemesanan.show', $order->id) }}" 
                                           class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                            Detail
                                        </a>
                                    </div>
                                </div>
                                
                                @if($order->pembayaran && $order->pembayaran->tiket->count() > 0)
                                    <div class="mt-4 pt-4 border-t">
                                        <h5 class="font-medium mb-2">Tiket Tersedia:</h5>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($order->pembayaran->tiket as $tiket)
                                                <div class="flex items-center space-x-2">
                                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                                        {{ $tiket->id_tiket }}
                                                    </span>
                                                    @if($tiket->status_tiket == 'active')
                                                        <a href="{{ route('tiket.reschedule', $tiket->id) }}" 
                                                           class="text-xs text-blue-600 hover:underline">Reschedule</a>
                                                        <a href="{{ route('tiket.cancel', $tiket->id) }}" 
                                                           class="text-xs text-red-600 hover:underline">Batal</a>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6">
                        {{ $pemesanan->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-500 text-lg mb-4">Belum ada pesanan</p>
                        <a href="{{ route('pemesanan.index') }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Pesan Tiket Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>