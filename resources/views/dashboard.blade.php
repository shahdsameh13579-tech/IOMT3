@extends('layouts.app')

@section('header_title', 'Security Operations Center (SOC) Terminal')

@section('content')
<div class="space-y-8">

    <!-- Top Alert Banner -->
    <div class="glass-panel p-6 rounded-2xl border-l-4 border-red-600 flex items-center justify-between shadow-[0_0_20px_rgba(239,68,68,0.05)]">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-600/10 flex items-center justify-center border border-red-500/30 text-red-500 text-xl animate-pulse">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-100 uppercase tracking-wider">AI intrusion Detection Shield Active</h3>
                <p class="text-xs text-slate-400 mt-0.5">Continuous packet anomaly scanning and log analysis engines are running on node <span class="font-mono text-slate-300">127.0.0.1:8000</span>.</p>
            </div>
        </div>
        <div class="text-xs text-slate-500 font-mono">
            Model Version: <span class="text-slate-300">Ensemble-V2.1</span>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Stat 1 -->
        <div class="glass-panel p-6 rounded-2xl relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Logs Analyzed</span>
                <i class="fa-solid fa-folder-open text-slate-500"></i>
            </div>
            <div class="mt-2">
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-100 font-mono">{{ number_format($totalAnalyzedEntries) }}</h2>
                <p class="text-[10px] text-slate-500 mt-1 uppercase tracking-wider">Accumulated HTTP Requests</p>
            </div>
            <div class="absolute bottom-0 right-0 w-24 h-1 bg-gradient-to-r from-blue-500 to-indigo-500"></div>
        </div>

        <!-- Stat 2 -->
        <div class="glass-panel p-6 rounded-2xl relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Security Findings</span>
                <i class="fa-solid fa-biohazard text-red-500"></i>
            </div>
            <div class="mt-2">
                <h2 class="text-3xl font-extrabold tracking-tight text-red-400 font-mono">{{ number_format($totalFindings) }}</h2>
                <p class="text-[10px] text-red-500/80 mt-1 uppercase tracking-wider font-semibold">Attacks detected by AI</p>
            </div>
            <div class="absolute bottom-0 right-0 w-24 h-1 bg-gradient-to-r from-red-600 to-rose-500"></div>
        </div>

        <!-- Stat 3 -->
        <div class="glass-panel p-6 rounded-2xl relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Zero-Day Attacks</span>
                <i class="fa-solid fa-mask text-purple-400"></i>
            </div>
            <div class="mt-2">
                <h2 class="text-3xl font-extrabold tracking-tight text-purple-400 font-mono">{{ $avgZeroDayRate }}%</h2>
                <p class="text-[10px] text-purple-400/80 mt-1 uppercase tracking-wider font-semibold">Outlier anomaly rate</p>
            </div>
            <div class="absolute bottom-0 right-0 w-24 h-1 bg-gradient-to-r from-purple-500 to-pink-500"></div>
        </div>

        <!-- Stat 4 -->
        <div class="glass-panel p-6 rounded-2xl relative overflow-hidden flex flex-col justify-between h-32">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Model Accuracy</span>
                <i class="fa-solid fa-bullseye text-emerald-500"></i>
            </div>
            <div class="mt-2">
                <h2 class="text-3xl font-extrabold tracking-tight text-emerald-400 font-mono">{{ $avgAccuracy }}%</h2>
                <p class="text-[10px] text-emerald-500/80 mt-1 uppercase tracking-wider font-semibold">Test Validation Score</p>
            </div>
            <div class="absolute bottom-0 right-0 w-24 h-1 bg-gradient-to-r from-emerald-500 to-teal-500"></div>
        </div>
    </div>

    <!-- Main Ingestion and Charts Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left: Upload Ingestion Panel -->
        <div class="glass-panel p-6 rounded-2xl flex flex-col justify-between h-[450px]">
            <div>
                <h4 class="text-sm font-extrabold uppercase tracking-wider text-slate-200 flex items-center gap-2 mb-2">
                    <i class="fa-solid fa-cloud-arrow-up text-red-500"></i>
                    Ingest Forensic Data
                </h4>
                <p class="text-xs text-slate-400 mb-6">Upload Apache/Nginx combined access log payloads or CSV audits for real-time model extraction.</p>
            </div>

            <form method="POST" action="{{ route('log.upload') }}" enctype="multipart/form-data" class="flex-1 flex flex-col justify-between">
                @csrf
                <div class="flex-1 flex flex-col items-center justify-center border-2 border-dashed border-slate-700 hover:border-red-500/60 rounded-xl cursor-pointer p-4 hover:bg-slate-900/10 transition group" onclick="document.getElementById('file-upload').click()">
                    <input type="file" id="file-upload" name="log_file" class="hidden" onchange="updateFileInfo(this)" required>
                    <i class="fa-solid fa-file-shield text-slate-500 group-hover:text-red-500 text-4xl mb-4 transition duration-200"></i>
                    <p class="text-xs font-semibold text-slate-300" id="upload-filename">Select log file payload</p>
                    <span class="text-[10px] text-slate-500 mt-1">Accepts: .log, .csv, .txt (Max 15MB)</span>
                </div>

                <button type="submit" class="w-full mt-4 py-3 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 text-white font-extrabold text-xs uppercase tracking-widest rounded-xl transition duration-200 shadow-[0_4px_20px_rgba(239,68,68,0.25)] border border-red-500/20 cursor-pointer">
                    Initiate Neural Scan
                </button>
            </form>
        </div>

        <!-- Middle & Right: Attack Types and Timelines -->
        <div class="lg:col-span-2 glass-panel p-6 rounded-2xl h-[450px] flex flex-col justify-between">
            <div>
                <h4 class="text-sm font-extrabold uppercase tracking-wider text-slate-200 flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-wave-square text-red-500"></i>
                    Threat Timeline & Detections
                </h4>
            </div>
            <div class="flex-1 flex items-center justify-center">
                <div id="timeline-chart" class="w-full h-full min-h-[320px]"></div>
            </div>
        </div>

    </div>

    <!-- Bottom Charts: Attack Types vs Suspicious IPs -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Attack Types Chart -->
        <div class="glass-panel p-6 rounded-2xl min-h-[380px] flex flex-col">
            <h4 class="text-sm font-extrabold uppercase tracking-wider text-slate-200 flex items-center gap-2 mb-4">
                <i class="fa-solid fa-pie-chart text-red-500"></i>
                Classifier Classification Breakdown
            </h4>
            <div class="flex-1 flex items-center justify-center">
                <div id="attack-types-chart" class="w-full max-w-[400px]"></div>
            </div>
        </div>

        <!-- Suspicious IPs Chart -->
        <div class="glass-panel p-6 rounded-2xl min-h-[380px] flex flex-col">
            <h4 class="text-sm font-extrabold uppercase tracking-wider text-slate-200 flex items-center gap-2 mb-4">
                <i class="fa-solid fa-network-wired text-red-500"></i>
                Top Alerting Host IP Nodes
            </h4>
            <div class="flex-1 flex items-center justify-center">
                <div id="top-ips-chart" class="w-full h-full min-h-[280px]"></div>
            </div>
        </div>

    </div>

    <!-- Forensic Registry List -->
    <div class="glass-panel rounded-2xl overflow-hidden shadow-xl">
        <div class="p-6 border-b border-slate-800 flex items-center justify-between">
            <h4 class="text-sm font-extrabold uppercase tracking-wider text-slate-200 flex items-center gap-2">
                <i class="fa-solid fa-box-archive text-red-500"></i>
                Log Audit Ledger
            </h4>
            <span class="text-xs text-slate-500 font-mono">Page: {{ $analyses->currentPage() }} of {{ $analyses->lastPage() }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-800 text-xs font-bold uppercase tracking-wider text-slate-400 bg-slate-950/40">
                        <th class="px-6 py-4">Analyzed Log Name</th>
                        <th class="px-6 py-4">Operator</th>
                        <th class="px-6 py-4 text-center">Entries</th>
                        <th class="px-6 py-4 text-center">Threat Detections</th>
                        <th class="px-6 py-4 text-center">Zero-Day Rate</th>
                        <th class="px-6 py-4 text-center">Neural Confidence</th>
                        <th class="px-6 py-4">Ingestion Date</th>
                        <th class="px-6 py-4 text-right">Reports</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-sm text-slate-300">
                    @forelse($analyses as $analysis)
                        <tr class="hover:bg-slate-900/20 transition duration-150">
                            <td class="px-6 py-4 font-semibold text-slate-200">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-file-medical text-red-500/80"></i>
                                    <span class="truncate max-w-[200px]" title="{{ $analysis->log->file_name }}">{{ $analysis->log->file_name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-400">
                                {{ $analysis->log->user->name }}
                            </td>
                            <td class="px-6 py-4 text-center font-mono font-semibold">
                                {{ number_format($analysis->total_entries) }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($analysis->total_findings > 0)
                                    <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-500/10 text-red-400 border border-red-500/20">
                                        {{ $analysis->total_findings }} alerts
                                    </span>
                                @else
                                    <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        Clean
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center font-mono text-purple-400 font-bold">
                                {{ $analysis->zero_day_rate }}%
                            </td>
                            <td class="px-6 py-4 text-center font-mono text-emerald-400 font-bold">
                                {{ round($analysis->accuracy * 100, 1) }}%
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-slate-400">
                                {{ $analysis->created_at->format('Y-m-d H:i:s') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('analysis.show', $analysis) }}" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-xs font-semibold text-slate-200 rounded-lg transition duration-150 border border-slate-700">
                                        <i class="fa-solid fa-eye mr-1"></i> Inspect
                                    </a>
                                    <a href="{{ route('analysis.pdf', $analysis) }}" class="px-3 py-1.5 bg-red-600/10 hover:bg-red-600/20 text-xs font-semibold text-red-400 rounded-lg transition duration-150 border border-red-500/20">
                                        <i class="fa-solid fa-file-pdf mr-1"></i> PDF
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-500 font-medium italic">
                                No logs ingested yet. Upload an access log above to launch AI modeling.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($analyses->hasPages())
            <div class="px-6 py-4 border-t border-slate-800 bg-slate-950/20">
                {{ $analyses->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    function updateFileInfo(input) {
        const filename = input.files[0] ? input.files[0].name : "Select log file payload";
        document.getElementById('upload-filename').innerText = filename;
    }

    document.addEventListener("DOMContentLoaded", function () {
        // Theme color definitions
        const redColor = '#ef4444';
        const blueColor = '#3b82f6';
        const purpleColor = '#a855f7';
        const greenColor = '#10b981';
        const orangeColor = '#f97316';
        const slateColor = '#64748b';

        // 1. Timeline Area Chart
        const timelineData = @json($timelineData);
        const dates = Object.keys(timelineData);
        const totals = Object.values(timelineData);

        const timelineOptions = {
            chart: {
                type: 'area',
                height: 320,
                toolbar: { show: false },
                background: 'transparent',
                foreColor: '#94a3b8'
            },
            stroke: {
                curve: 'smooth',
                width: 2,
                colors: [redColor]
            },
            colors: [redColor],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.35,
                    opacityTo: 0.05,
                    stops: [0, 95, 100]
                }
            },
            grid: {
                borderColor: '#1e293b',
                strokeDashArray: 4
            },
            series: [{
                name: 'Detected Threats',
                data: totals.length > 0 ? totals : [0]
            }],
            xaxis: {
                categories: dates.length > 0 ? dates : ['No Data'],
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            tooltip: {
                theme: 'dark'
            }
        };
        new ApexCharts(document.querySelector("#timeline-chart"), timelineOptions).render();

        // 2. Classifier Classification Breakdown (Pie)
        const attackTypes = @json($attackTypes);
        const typeLabels = Object.keys(attackTypes);
        const typeValues = Object.values(attackTypes);

        const pieOptions = {
            chart: {
                type: 'donut',
                height: 280,
                background: 'transparent',
                foreColor: '#94a3b8'
            },
            series: typeValues.length > 0 ? typeValues : [1],
            labels: typeLabels.length > 0 ? typeLabels : ['No threats'],
            colors: [redColor, orangeColor, purpleColor, blueColor, greenColor],
            legend: {
                position: 'bottom',
                horizontalAlign: 'center'
            },
            stroke: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        background: 'transparent',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '12px',
                                fontWeight: 'bold',
                                color: '#94a3b8'
                            },
                            value: {
                                show: true,
                                fontSize: '18px',
                                fontWeight: 'extrabold',
                                color: '#f1f5f9'
                            },
                            total: {
                                show: true,
                                label: 'Threats',
                                color: '#94a3b8'
                            }
                        }
                    }
                }
            },
            tooltip: {
                theme: 'dark'
            }
        };
        new ApexCharts(document.querySelector("#attack-types-chart"), pieOptions).render();

        // 3. Top Host IP Nodes (Bar Chart)
        const topIps = @json($topIps);
        const ipLabels = Object.keys(topIps);
        const ipValues = Object.values(topIps);

        const barOptions = {
            chart: {
                type: 'bar',
                height: 280,
                toolbar: { show: false },
                background: 'transparent',
                foreColor: '#94a3b8'
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    barHeight: '40%',
                    borderRadius: 4,
                    colors: {
                        backgroundBarColors: ['rgba(255,255,255,0.02)']
                    }
                }
            },
            colors: [orangeColor],
            series: [{
                name: 'Attacks Triggered',
                data: ipValues.length > 0 ? ipValues : [0]
            }],
            xaxis: {
                categories: ipLabels.length > 0 ? ipLabels : ['None'],
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            grid: {
                borderColor: '#1e293b',
                strokeDashArray: 4
            },
            tooltip: {
                theme: 'dark'
            }
        };
        new ApexCharts(document.querySelector("#top-ips-chart"), barOptions).render();
    });
</script>
@endsection
