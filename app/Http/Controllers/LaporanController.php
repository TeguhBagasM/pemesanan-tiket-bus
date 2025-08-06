<?php
namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Tiket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isOwner()) {
                abort(403);
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $startDate = $request->start_date ?? Carbon::now()->startOfMonth()->toDateString();
        $endDate = $request->end_date ?? Carbon::now()->endOfMonth()->toDateString();

        $data = [
            'total_pemesanan' => Pemesanan::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_revenue' => Pemesanan::where('status_pembayaran', 'paid')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('total_harga'),
            'total_tiket_terjual' => Tiket::whereHas('pembayaran.pemesanan', function($query) use ($startDate, $endDate) {
                $query->where('status_pembayaran', 'paid')
                      ->whereBetween('created_at', [$startDate, $endDate]);
            })->count(),
            'new_users' => User::where('role', 'user')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count()
        ];

        $pemesanan_harian = Pemesanan::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('laporan.index', compact('data', 'pemesanan_harian', 'startDate', 'endDate'));
    }
}
