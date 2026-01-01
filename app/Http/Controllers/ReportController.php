<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // inisialisasi query
        $query = Rental::with(['car', 'user']);

        // filter berdasarkan role user
        $user = auth()->user();
        if ($user->role === 'pelanggan') {
            $query->where('user_id', $user->id);
        }

        // filter tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_sewa', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_sewa', '<=', $request->end_date);
        }

        // filter status
        if ($request->filled('status')) {
            $query->where('status_transaksi', $request->status);
        }

        // fiilter pelanggan (hanya untuk admin/petugas)
        if ($request->filled('user_id') && in_array($user->role, ['admin', 'petugas'])) {
            $query->where('user_id', $request->user_id);
        }

        // filter mobil
        if ($request->filled('car_id')) {
            $query->where('car_id', $request->car_id);
        }

        // ambil data rental
        $rentals = $query->orderBy('tanggal_sewa', 'desc')->paginate(15);

        // statistik
        $stats = $this->generateStats($request);

        // data untuk dropdown filter
        $users = User::where('role', 'pelanggan')->get();
        $cars = Car::all();

        return view('reports.index', [
            'rentals' => $rentals,
            'stats' => $stats,
            'users' => $users,
            'cars' => $cars,
        ]);
    }

    private function generateStats(Request $request)
    {
        $query = Rental::query();

        // apply same filter dor stats
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_sewa', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_sewa', '<=', $request->end_date);
        }

        if ($request->filled('status')) {
            $query->where('status_transaksi', $request->status);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('car_id')) {
            $query->where('car_id', $request->car_id);
        }

        return [
            'total_rentals' => $query->count(),
            'total_revenue' => $query->sum('total_bayar'),
            'completed_rentals' => (clone $query)->where('status_transaksi', 'selesai')->count(),
            'active_rentals' => (clone $query)->whereIn('status_transaksi', ['booking', 'diambil', 'kembali'])->count(),
            'avg_rental_duration' => $query->avg('lama_sewa'),
            'most_rented_car' => $this->getMostRentedCar(clone $query),
            'top_customer' => $this->getTopCustomer(clone $query),
        ];
    }

    private function getMostRentedCar($query)
    {
        return $query->select('car_id')
            ->selectRaw('COUNT(*) as rental_count')
            ->with('car')
            ->groupBy('car_id')
            ->orderBy('rental_count', 'desc')
            ->first();
    }

    private function getTopCustomer($query)
    {
        return $query->select('user_id')
            ->selectRaw('COUNT(*) as rental_count')
            ->selectRaw('SUM(total_bayar) as total_spent')
            ->with('user')
            ->groupBy('user_id')
            ->orderBy('rental_count', 'desc')
            ->first();
    }

    public function exportPdf(Request $request)
    {
        // Get same data as index method
        $query = Rental::with(['car', 'user']);
        
        // Apply same filters
        $user = auth()->user();
        if ($user->role === 'pelanggan') {
            $query->where('user_id', $user->id);
        }
        
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_sewa', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_sewa', '<=', $request->end_date);
        }
        
        if ($request->filled('status')) {
            $query->where('status_transaksi', $request->status);
        }
        
        if ($request->filled('user_id') && in_array($user->role, ['admin', 'petugas'])) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->filled('car_id')) {
            $query->where('car_id', $request->car_id);
        }
        
        // Get all data (no pagination for PDF)
        $rentals = $query->orderBy('tanggal_sewa', 'desc')->get();
        
        // Generate stats
        $stats = $this->generateStats($request);
        
        // Generate PDF
        $pdf = Pdf::loadView('reports.pdf', compact('rentals', 'stats', 'request'));
        
        // Set paper and orientation
        $pdf->setPaper('A4', 'landscape');
        
        // Generate filename with timestamp
        $filename = 'laporan-rental-' . date('Y-m-d-H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }

    public function exportExcel(Request $request)
    {
        // Get same data as index method
        $query = Rental::with(['car', 'user']);
        
        // Apply same filters
        $user = auth()->user();
        if ($user->role === 'pelanggan') {
            $query->where('user_id', $user->id);
        }
        
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_sewa', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_sewa', '<=', $request->end_date);
        }
        
        if ($request->filled('status')) {
            $query->where('status_transaksi', $request->status);
        }
        
        if ($request->filled('user_id') && in_array($user->role, ['admin', 'petugas'])) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->filled('car_id')) {
            $query->where('car_id', $request->car_id);
        }
        
        // Get all data (no pagination for Excel)
        $rentals = $query->orderBy('tanggal_sewa', 'desc')->get();
        
        // Generate stats
        $stats = $this->generateStats($request);
        
        // Generate filename with timestamp
        $filename = 'laporan-rental-' . date('Y-m-d-H-i-s') . '.xlsx';
        
        return Excel::download(new \App\Exports\RentalReportExport($rentals, $stats), $filename);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
