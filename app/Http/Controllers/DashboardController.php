<?php
namespace App\Http\Controllers;

use App\Models\Armada;
use App\Models\Pemesanan;
use App\Models\Tiket;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isUser()) {
            return $this->userDashboard();
        } elseif ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isOwner()) {
            return $this->ownerDashboard();
        }
    }

    private function userDashboard()
    {
        $pemesanan = Pemesanan::where('id_pengguna', auth()->id())
            ->with(['pembayaran', 'pembayaran.tiket'])
            ->latest()
            ->take(5)
            ->get();
            
        $armada = Armada::latest()->take(6)->get();
        
        return view('dashboard.user', compact('pemesanan', 'armada'));
    }

    private function adminDashboard()
    {
        $stats = [
            'total_pemesanan' => Pemesanan::count(),
            'pemesanan_pending' => Pemesanan::where('status_pembayaran', 'pending')->count(),
            'pemesanan_paid' => Pemesanan::where('status_pembayaran', 'paid')->count(),
            'total_tiket' => Tiket::count()
        ];
        
        $recent_pemesanan = Pemesanan::with(['pengguna', 'pembayaran'])
            ->latest()
            ->take(10)
            ->get();
            
        return view('dashboard.admin', compact('stats', 'recent_pemesanan'));
    }

    private function ownerDashboard()
    {
        $stats = [
            'total_revenue' => Pemesanan::where('status_pembayaran', 'paid')->sum('total_harga'),
            'total_pemesanan' => Pemesanan::count(),
            'total_armada' => Armada::count(),
            'total_pengguna' => \App\Models\User::where('role', 'user')->count()
        ];
        
        return view('dashboard.owner', compact('stats'));
    }
}
