<?php
namespace App\Http\Controllers;

use App\Models\Tiket;
use App\Models\Reschedule;
use App\Models\Pembatalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TiketController extends Controller
{
    public function reschedule($tiket_id)
    {
        $tiket = Tiket::with(['pembayaran.pemesanan'])
            ->whereHas('pembayaran.pemesanan', function($query) {
                $query->where('id_pengguna', auth()->id());
            })
            ->findOrFail($tiket_id);
            
        if ($tiket->status_tiket != 'active') {
            return back()->with('error', 'Tiket tidak dapat direschedule.');
        }
        
        return view('tiket.reschedule', compact('tiket'));
    }

    public function storeReschedule(Request $request)
    {
        $request->validate([
            'tiket_id' => 'required|exists:tiket,id',
            'jadwal_baru' => 'required|date|after:today'
        ]);

        $tiket = Tiket::findOrFail($request->tiket_id);
        
        // Check authorization
        if ($tiket->pembayaran->pemesanan->id_pengguna != auth()->id()) {
            abort(403);
        }

        DB::beginTransaction();
        try {
            Reschedule::create([
                'id_tiket' => $tiket->id,
                'jadwal_lama' => $tiket->pembayaran->pemesanan->jadwal_pemesanan,
                'jadwal_baru' => $request->jadwal_baru,
                'status_reschedule' => 'pending'
            ]);

            $tiket->update(['status_tiket' => 'rescheduled']);
            
            DB::commit();
            
            return redirect()->route('dashboard')
                ->with('success', 'Permintaan reschedule berhasil diajukan.');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat mengajukan reschedule.');
        }
    }

    public function cancel($tiket_id)
    {
        $tiket = Tiket::with(['pembayaran.pemesanan'])
            ->whereHas('pembayaran.pemesanan', function($query) {
                $query->where('id_pengguna', auth()->id());
            })
            ->findOrFail($tiket_id);
            
        if ($tiket->status_tiket != 'active') {
            return back()->with('error', 'Tiket tidak dapat dibatalkan.');
        }
        
        return view('tiket.cancel', compact('tiket'));
    }

    public function storeCancel(Request $request)
    {
        $request->validate([
            'tiket_id' => 'required|exists:tiket,id',
            'alasan' => 'required|string|max:255'
        ]);

        $tiket = Tiket::findOrFail($request->tiket_id);
        
        // Check authorization
        if ($tiket->pembayaran->pemesanan->id_pengguna != auth()->id()) {
            abort(403);
        }

        $refund = $tiket->harga_tiket * 0.8; // 80% refund

        DB::beginTransaction();
        try {
            Pembatalan::create([
                'id_tiket' => $tiket->id,
                'alasan' => $request->alasan,
                'tgl_pembatalan' => now(),
                'refund' => $refund,
                'status_pembatalan' => 'pending'
            ]);

            $tiket->update(['status_tiket' => 'cancelled']);
            
            DB::commit();
            
            return redirect()->route('dashboard')
                ->with('success', 'Permintaan pembatalan berhasil diajukan. Refund: Rp ' . number_format($refund));
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat mengajukan pembatalan.');
        }
    }
}