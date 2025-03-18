<?php
namespace App\Http\Controllers\Dashboard;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class ChartController extends Controller
{
    public function grossAmount(Request $request) 
    {
        $month = $request->input('month', Carbon::now()->format('Y-m'));

        $query = Pemesanan::selectRaw("SUM(gross_amount) as total, DATE(created_at) as date")
            ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month])
            ->groupBy('date')
            ->orderBy('date');

        $data = $query->get();

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }
}
