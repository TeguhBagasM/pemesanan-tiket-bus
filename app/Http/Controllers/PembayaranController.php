<?php
namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Pembayaran;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function create($pemesanan_id)
    {
        $pemesanan = Pemesanan::where('id_pengguna', auth()->id())
            ->where('id', $pemesanan_id)
            ->firstOrFail();
            
        if ($pemesanan->status_pembayaran != 'pending') {
            return redirect()->route('pemesanan.show', $pemesanan->id)
                ->with('error', 'Pemesanan ini sudah diproses.');
        }
        
        return view('pembayaran.create', compact('pemesanan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pemesanan_id' => 'required|exists:pemesanan,id',
            'metode_pembayaran' => 'required|in:transfer,cash,ewallet',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $pemesanan = Pemesanan::findOrFail($request->pemesanan_id);
        
        // Check authorization
        if ($pemesanan->id_pengguna != auth()->id()) {
            abort(403);
        }

        DB::beginTransaction();
        try {
            // Upload bukti pembayaran
            $buktiPath = $request->file('bukti_pembayaran')
                ->store('bukti-pembayaran', 'public');

            // Create pembayaran
            $pembayaran = Pembayaran::create([
                'id_pemesanan' => $pemesanan->id,
                'nominal' => $pemesanan->total_harga,
                'metode_pembayaran' => $request->metode_pembayaran,
                'bukti_pembayaran' => $buktiPath,
                'tgl_pembayaran' => now(),
                'status' => 'pending'
            ]);

            // Generate tiket
            for ($i = 1; $i <= $pemesanan->jumlah_tiket; $i++) {
                Tiket::create([
                    'id_pembayaran' => $pembayaran->id,
                    'harga_tiket' => $pemesanan->total_harga / $pemesanan->jumlah_tiket,
                    'no_kursi' => 'K' . sprintf('%02d', $i),
                    'status_tiket' => 'active'
                ]);
            }

            DB::commit();
            
            return redirect()->route('pemesanan.show', $pemesanan->id)
                ->with('success', 'Pembayaran berhasil diupload. Menunggu verifikasi admin.');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat memproses pembayaran.');
        }
    }

    public function verify($pembayaran_id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $pembayaran = Pembayaran::findOrFail($pembayaran_id);
        
        DB::beginTransaction();
        try {
            $pembayaran->update(['status' => 'verified']);
            $pembayaran->pemesanan->update(['status_pembayaran' => 'paid']);
            
            DB::commit();
            
            return back()->with('success', 'Pembayaran berhasil diverifikasi.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat verifikasi.');
        }
    }

    public function reject($pembayaran_id)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
        
        $pembayaran = Pembayaran::findOrFail($pembayaran_id);
        
        DB::beginTransaction();
        try {
            $pembayaran->update(['status' => 'rejected']);
            $pembayaran->pemesanan->update(['status_pembayaran' => 'failed']);
            
            DB::commit();
            
            return back()->with('success', 'Pembayaran berhasil ditolak.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat menolak pembayaran.');
        }
    }
}