<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use App\Models\Finding;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Global aggregate metrics
        $totalLogs = Log::count();
        $totalFindings = Finding::count();
        
        $totalAnalyzedEntries = Analysis::sum('total_entries');
        
        // Calculate average zero-day rate
        $avgZeroDayRate = Analysis::count() > 0 
            ? round(Analysis::avg('zero_day_rate'), 1) 
            : 0.0;
            
        // Calculate average model accuracy
        $avgAccuracy = Analysis::count() > 0 
            ? round(Analysis::avg('accuracy') * 100, 1) 
            : 94.0;

        // Attack types breakdown for Pie/Doughnut chart
        $attackTypes = Finding::select('attack_type', DB::raw('count(*) as total'))
            ->groupBy('attack_type')
            ->orderBy('total', 'desc')
            ->get()
            ->pluck('total', 'attack_type')
            ->toArray();

        // Top suspicious IPs for Bar chart
        $topIps = Finding::select('ip', DB::raw('count(*) as total'))
            ->groupBy('ip')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get()
            ->pluck('total', 'ip')
            ->toArray();

        // Timeline data (group findings by day/date)
        // Grouping by date in SQLite is done with strftime
        $timelineData = Finding::select(
            DB::raw("strftime('%Y-%m-%d', created_at) as date"), 
            DB::raw('count(*) as total')
        )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->limit(14)
            ->get()
            ->pluck('total', 'date')
            ->toArray();

        // Recent analyses list
        $analyses = Analysis::with(['log.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dashboard', compact(
            'totalLogs',
            'totalFindings',
            'totalAnalyzedEntries',
            'avgZeroDayRate',
            'avgAccuracy',
            'attackTypes',
            'topIps',
            'timelineData',
            'analyses'
        ));
    }
}
