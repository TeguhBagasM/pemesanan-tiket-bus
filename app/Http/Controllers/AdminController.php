<?php
namespace App\Http\Controllers;

use App\Models\Armada;
use App\Models\Pembayaran;
use App\Models\Reschedule;
use App\Models\Pembatalan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isAdmin() && !auth()->user()->isOwner()) {
                abort(403);
            }
            return $next($request);
        });
    }

    public function armadaIndex()
    {
        $armada = Armada::with('admin')->latest()->paginate(10);
        return view('admin.armada.index', compact('armada'));
    }

    public function armadaCreate()
    {
        return view('admin.armada.create');
    }

    public function armadaStore(Request $request)
    {
        $request->validate([
            'no_unik' => 'required|unique:armada,no_unik',
            'supir' => 'required|string|max:255',
            'jumlah_kursi' => 'required|integer|min:1',
            'no_kendaraan' => 'required|string',
            'rute_asal' => 'required|string',
            'rute_tujuan' => 'required|string',
            'harga_tiket' => 'required|numeric|min:0',
            'jam_berangkat' => 'required'
        ]);

        Armada::create([
            'no_unik' => $request->no_unik,
            'id_admin' => auth()->id(),
            'supir' => $request->supir,
            'jumlah_kursi' => $request->jumlah_kursi,
            'no_kendaraan' => $request->no_kendaraan,
            'rute_asal' => $request->rute_asal,
            'rute_tujuan' => $request->rute_tujuan,
            'harga_tiket' => $request->harga_tiket,
            'jam_berangkat' => $request->jam_berangkat
        ]);

        return redirect()->route('admin.armada.index')
            ->with('success', 'Armada berhasil ditambahkan.');
    }

    public function pembayaranIndex()
    {
        $pembayaran = Pembayaran::with(['pemesanan.pengguna'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);
            
        return view('admin.pembayaran.index', compact('pembayaran'));
    }

    public function rescheduleIndex()
    {
        $reschedule = Reschedule::with(['tiket.pembayaran.pemesanan.pengguna'])
            ->where('status_reschedule', 'pending')
            ->latest()
            ->paginate(10);
            
        return view('admin.reschedule.index', compact('reschedule'));
    }

    public function rescheduleApprove($id)
    {
        $reschedule = Reschedule::findOrFail($id);
        $reschedule->update(['status_reschedule' => 'approved']);
        
        return back()->with('success', 'Reschedule berhasil disetujui.');
    }

    public function pembatalanIndex()
    {
        $pembatalan = Pembatalan::with(['tiket.pembayaran.pemesanan.pengguna'])
            ->where('status_pembatalan', 'pending')
            ->latest()
            ->paginate(10);
            
        return view('admin.pembatalan.index', compact('pembatalan'));
    }

    public function pembatalanApprove($id)
    {
        $pembatalan = Pembatalan::findOrFail($id);
        $pembatalan->update(['status_pembatalan' => 'approved']);
        
        return back()->with('success', 'Pembatalan berhasil disetujui.');
    }
}

