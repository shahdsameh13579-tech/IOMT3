<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use App\Models\Finding;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function download(Analysis $analysis)
    {
        $analysis->load(['log.user']);
        
        // Fetch up to 100 findings for the PDF tables (to avoid huge files if there are thousands)
        $findings = Finding::where('analysis_id', $analysis->id)
            ->orderBy('severity', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get();
            
        // Get attack distribution stats
        $attackDistribution = Finding::where('analysis_id', $analysis->id)
            ->select('attack_type', \DB::raw('count(*) as total'))
            ->groupBy('attack_type')
            ->get()
            ->pluck('total', 'attack_type')
            ->toArray();

        $pdf = Pdf::loadView('reports.forensic', compact('analysis', 'findings', 'attackDistribution'))
            ->setPaper('a4', 'portrait')
            ->setOption([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

        return $pdf->download("Cyber_Forensics_AI_Report_Log_{$analysis->id}.pdf");
    }
}
