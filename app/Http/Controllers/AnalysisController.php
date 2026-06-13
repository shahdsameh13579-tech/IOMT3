<?php

namespace App\Http\Controllers;

use App\Models\Analysis;
use App\Models\Finding;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function show(Request $request, Analysis $analysis)
    {
        $analysis->load('log.user');

        $query = Finding::where('analysis_id', $analysis->id);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('ip', 'like', "%{$search}%")
                  ->orWhere('request_uri', 'like', "%{$search}%")
                  ->orWhere('attack_type', 'like', "%{$search}%");
            });
        }

        // Severity filter
        if ($request->filled('severity')) {
            $query->where('severity', $request->input('severity'));
        }

        // Attack type filter
        if ($request->filled('attack_type')) {
            $query->where('attack_type', $request->input('attack_type'));
        }

        $findings = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        // Get unique attack types and severities for filtering
        $allAttackTypes = Finding::where('analysis_id', $analysis->id)
            ->select('attack_type')
            ->distinct()
            ->pluck('attack_type');

        $allSeverities = Finding::where('analysis_id', $analysis->id)
            ->select('severity')
            ->distinct()
            ->pluck('severity');

        return view('analysis.show', compact(
            'analysis',
            'findings',
            'allAttackTypes',
            'allSeverities'
        ));
    }
}
