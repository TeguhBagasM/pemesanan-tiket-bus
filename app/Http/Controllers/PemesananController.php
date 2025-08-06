<?php
namespace App\Http\Controllers;

use App\Models\Armada;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    public function index()
    {
        // Search armada
        $armada = Armada::latest()->paginate(10);
        return view('pemesanan.index', compact('armada'));
    }

    public function search(Request $request)
    {
        $query = Armada::query();
        
        if ($request->rute_asal) {
            $query->where('rute_asal', 'like', '%' . $request->rute_asal . '%');
        }
        
        if ($request->rute_tujuan) {
            $query->where('rute_tujuan', 'like', '%' . $request->rute_tujuan . '%');
        }
        
        if ($request->tanggal) {
            // Filter berdasarkan tanggal jika diperlukan
        }
        
        $armada = $query->paginate(10);
        return view('pemesanan.index', compact('armada'));
    }

    public function create($armada_id)
    {
        $armada = Armada::findOrFail($armada_id);
        return view('pemesanan.create', compact('armada'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'armada_id' => 'required|exists:armada,id',
            'jumlah_tiket' => 'required|integer|min:1|max:10',
            'jadwal_pemesanan' => 'required|date|after:today'
        ]);

        $armada = Armada::findOrFail($request->armada_id);
        $total_harga = $armada->harga_tiket * $request->jumlah_tiket;

        DB::beginTransaction();
        try {
            // Create pemesanan
            $pemesanan = Pemesanan::create([
                'id_admin' => $armada->id_admin,
                'id_pengguna' => auth()->id(),
                'tgl_pemesanan' => now()->toDateString(),
                'jadwal_pemesanan' => $request->jadwal_pemesanan,
                'jumlah_tiket' => $request->jumlah_tiket,
                'total_harga' => $total_harga,
                'status_pembayaran' => 'pending'
            ]);

            DB::commit();
            
            return redirect()->route('pembayaran.create', $pemesanan->id)
                ->with('success', 'Pemesanan berhasil dibuat. Silakan lakukan pembayaran.');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat membuat pemesanan.');
        }
    }

    public function show($id)
    {
        $pemesanan = Pemesanan::with(['pengguna', 'admin', 'pembayaran', 'pembayaran.tiket'])
            ->findOrFail($id);
            
        // Check authorization
        if (auth()->user()->isUser() && $pemesanan->id_pengguna != auth()->id()) {
            abort(403);
        }
        
        return view('pemesanan.show', compact('pemesanan'));
    }

    public function myOrders()
    {
        $pemesanan = Pemesanan::where('id_pengguna', auth()->id())
            ->with(['pembayaran', 'pembayaran.tiket'])
            ->latest()
            ->paginate(10);
            
        return view('pemesanan.my-orders', compact('pemesanan'));
    }
}