<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penyewaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .filter-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .filter-info h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #333;
        }
        
        .filter-item {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 5px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            border-left: 4px solid #007bff;
        }
        
        .stat-card h4 {
            margin: 0 0 5px 0;
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
        }
        
        .stat-card .value {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        
        .additional-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .additional-stats .stat-card {
            border-left-color: #28a745;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .status {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            text-align: center;
        }
        
        .status.booking {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status.diambil {
            background-color: #cce5ff;
            color: #004085;
        }
        
        .status.kembali {
            background-color: #ffe6cc;
            color: #cc6600;
        }
        
        .status.selesai {
            background-color: #d4edda;
            color: #155724;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENYEWAAN MOBIL</h1>
        <p>Tanggal Cetak: {{ date('d F Y H:i:s') }}</p>
        <p>Dicetak oleh: {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</p>
    </div>

    {{-- Filter Information --}}
    <div class="filter-info">
        <h3>Filter yang Diterapkan:</h3>
        @if($request->filled('start_date') || $request->filled('end_date'))
            <div class="filter-item">
                <strong>Periode:</strong> 
                {{ $request->start_date ? \Carbon\Carbon::parse($request->start_date)->format('d/m/Y') : 'Awal' }} 
                - 
                {{ $request->end_date ? \Carbon\Carbon::parse($request->end_date)->format('d/m/Y') : 'Akhir' }}
            </div>
        @endif
        
        @if($request->filled('status'))
            <div class="filter-item">
                <strong>Status:</strong> {{ ucfirst($request->status) }}
            </div>
        @endif
        
        @if($request->filled('user_id'))
            <div class="filter-item">
                <strong>Pelanggan:</strong> Pelanggan Tertentu
            </div>
        @endif
        
        @if($request->filled('car_id'))
            <div class="filter-item">
                <strong>Mobil:</strong> Mobil Tertentu
            </div>
        @endif
        
        @if(!$request->filled('start_date') && !$request->filled('end_date') && !$request->filled('status') && !$request->filled('user_id') && !$request->filled('car_id'))
            <div class="filter-item">Semua Data</div>
        @endif
    </div>

    {{-- Statistics --}}
    <div class="stats-grid">
        <div class="stat-card">
            <h4>Total Rental</h4>
            <div class="value">{{ $stats['total_rentals'] }}</div>
        </div>
        <div class="stat-card">
            <h4>Total Pendapatan</h4>
            <div class="value">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <h4>Rental Aktif</h4>
            <div class="value">{{ $stats['active_rentals'] }}</div>
        </div>
        <div class="stat-card">
            <h4>Rental Selesai</h4>
            <div class="value">{{ $stats['completed_rentals'] }}</div>
        </div>
    </div>

    <div class="additional-stats">
        <div class="stat-card">
            <h4>Rata-rata Lama Sewa</h4>
            <div class="value">{{ number_format($stats['avg_rental_duration'], 1) }} Hari</div>
        </div>
        <div class="stat-card">
            <h4>Mobil Terfavorit</h4>
            <div class="value">
                @if($stats['most_rented_car'])
                    {{ $stats['most_rented_car']->car->nama }}<br>
                    <small>({{ $stats['most_rented_car']->rental_count }} kali)</small>
                @else
                    Tidak ada data
                @endif
            </div>
        </div>
        <div class="stat-card">
            <h4>Customer Terbaik</h4>
            <div class="value">
                @if($stats['top_customer'])
                    {{ $stats['top_customer']->user->name }}<br>
                    <small>({{ $stats['top_customer']->rental_count }} rental)</small>
                @else
                    Tidak ada data
                @endif
            </div>
        </div>
    </div>

    {{-- Data Table --}}
    @if($rentals->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pelanggan</th>
                    <th>Mobil</th>
                    <th>Tanggal Sewa</th>
                    <th>Durasi</th>
                    <th>Total Bayar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rentals as $rental)
                    <tr>
                        <td>#{{ $rental->id }}</td>
                        <td>
                            <strong>{{ $rental->user->name }}</strong><br>
                            <small>{{ $rental->user->email }}</small>
                        </td>
                        <td>
                            <strong>{{ $rental->car->nama }}</strong><br>
                            <small>{{ $rental->car->nopol }}</small>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($rental->tanggal_sewa)->format('d/m/Y') }}</td>
                        <td>{{ $rental->lama_sewa }} Hari</td>
                        <td>Rp {{ number_format($rental->total_bayar, 0, ',', '.') }}</td>
                        <td>
                            <span class="status {{ $rental->status_transaksi }}">
                                {{ ucfirst($rental->status_transaksi) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <p>Tidak ada data rental yang sesuai dengan filter yang diterapkan.</p>
        </div>
    @endif

    <div class="footer">
        <p>Laporan ini digenerate secara otomatis oleh Sistem Rental Mobil</p>
        <p>Total {{ $rentals->count() }} data rental</p>
    </div>
</body>
</html>