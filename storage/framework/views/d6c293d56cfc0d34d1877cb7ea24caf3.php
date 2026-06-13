<?php $__env->startSection('header_title'); ?>
    Analysis Detail: #<?php echo e($analysis->id); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">

    <!-- Header / Navigation Bar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-xl font-bold text-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-square-poll-vertical text-red-500"></i>
                Forensic Case Dossier
            </h3>
            <p class="text-xs text-slate-400 mt-1 font-mono">Log Source: <?php echo e($analysis->log->file_name); ?> | Ingested by <?php echo e($analysis->log->user->name); ?></p>
        </div>
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('dashboard')); ?>" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-xs font-semibold text-slate-300 rounded-lg transition border border-slate-700">
                <i class="fa-solid fa-circle-chevron-left mr-1"></i> Dashboard
            </a>
            <a href="<?php echo e(route('analysis.pdf', $analysis)); ?>" class="px-4 py-2 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 text-white font-extrabold text-xs uppercase tracking-wider rounded-lg transition shadow-[0_4px_15px_rgba(239,68,68,0.2)] border border-red-500/20">
                <i class="fa-solid fa-file-pdf mr-1"></i> Download PDF Audit
            </a>
        </div>
    </div>

    <!-- Diagnostic Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Metric 1 -->
        <div class="glass-panel p-5 rounded-xl border-l-4 border-blue-500">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Total Packets Scanned</span>
            <span class="text-2xl font-bold text-slate-200 font-mono block mt-1"><?php echo e(number_format($analysis->total_entries)); ?></span>
            <span class="text-[10px] text-slate-500 font-mono block mt-1">HTTP log lines parsed</span>
        </div>

        <!-- Metric 2 -->
        <div class="glass-panel p-5 rounded-xl border-l-4 border-red-500">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">AI Threat Detections</span>
            <span class="text-2xl font-bold text-red-400 font-mono block mt-1"><?php echo e(number_format($analysis->total_findings)); ?></span>
            <span class="text-[10px] text-red-500/60 font-semibold block mt-1">
                <?php if($analysis->total_entries > 0): ?>
                    <?php echo e(round(($analysis->total_findings / $analysis->total_entries) * 100, 2)); ?>% infection rate
                <?php else: ?>
                    0% infection rate
                <?php endif; ?>
            </span>
        </div>

        <!-- Metric 3 -->
        <div class="glass-panel p-5 rounded-xl border-l-4 border-purple-500">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">Zero-Day Anomaly Rate</span>
            <span class="text-2xl font-bold text-purple-400 font-mono block mt-1"><?php echo e($analysis->zero_day_rate); ?>%</span>
            <span class="text-[10px] text-purple-400/60 font-semibold block mt-1">Isolation Forest detections</span>
        </div>

        <!-- Metric 4 -->
        <div class="glass-panel p-5 rounded-xl border-l-4 border-emerald-500">
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">ML Classifier Confidence</span>
            <span class="text-2xl font-bold text-emerald-400 font-mono block mt-1"><?php echo e(round($analysis->accuracy * 100, 1)); ?>%</span>
            <span class="text-[10px] text-emerald-500/60 font-semibold block mt-1">Voting ensemble validation</span>
        </div>
    </div>

    <!-- Threat Diagnostics Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left: Model Metrics & Architecture -->
        <div class="glass-panel p-6 rounded-2xl space-y-5">
            <h4 class="text-sm font-extrabold uppercase tracking-wider text-slate-200 border-b border-slate-800 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-microchip text-red-500"></i>
                AI Engine Parameters
            </h4>
            
            <div class="space-y-4 text-xs">
                <div>
                    <span class="text-slate-400 font-semibold block">Model Stack:</span>
                    <p class="text-slate-300 font-mono mt-1">
                        1. Random Forest (50 estimators)<br>
                        2. XGBoost Classifier (50 estimators)<br>
                        3. LightGBM Classifier (50 estimators)<br>
                        4. Voting Ensemble (Soft Voting)<br>
                        5. Isolation Forest (Unsupervised Anomaly)
                    </p>
                </div>

                <div>
                    <span class="text-slate-400 font-semibold block">Classification Targets (7 Classes):</span>
                    <p class="text-slate-300 font-mono mt-1">
                        0 = Normal &nbsp;|&nbsp; 1 = SQLi &nbsp;|&nbsp; 2 = XSS<br>
                        3 = Directory Traversal / LFI &nbsp;|&nbsp; 4 = RCE<br>
                        5 = Credential Stuffing &nbsp;|&nbsp; 6 = Vuln Scan<br>
                        <span class="text-purple-400 font-bold">Anomaly</span> = IsolationForest outlier &amp; ensemble normal
                    </p>
                </div>

                <div>
                    <span class="text-slate-400 font-semibold block">Feature Vector (14 Dimensions):</span>
                    <ul class="list-disc list-inside text-slate-400 mt-1 space-y-1 font-mono">
                        <li>Path length &amp; query length</li>
                        <li>SQL Injection signatures</li>
                        <li>Cross-Site Scripting signatures</li>
                        <li>Directory Traversal bounds</li>
                        <li>Local / Remote File Inclusion</li>
                        <li>Remote Command injection matches</li>
                        <li>HTTP status codes (4xx / 5xx)</li>
                        <li>HTTP POST method flag</li>
                        <li>User Agent scanner detection</li>
                        <li>Credential Stuffing (login brute-force)</li>
                        <li>Suspicious extension requests (.env, .bak)</li>
                        <li>Malformed HTTP method detection</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Right: Log Findings Table with Filters -->
        <div class="lg:col-span-2 glass-panel p-6 rounded-2xl flex flex-col justify-between">
            <h4 class="text-sm font-extrabold uppercase tracking-wider text-slate-200 border-b border-slate-800 pb-3 flex items-center gap-2 mb-4">
                <i class="fa-solid fa-list-check text-red-500"></i>
                Security Audit Findings
            </h4>

            <!-- Interactive Filters Form -->
            <form method="GET" action="<?php echo e(route('analysis.show', $analysis)); ?>" class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
                <!-- Search Input -->
                <div class="sm:col-span-2">
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                        placeholder="Search IP, URI, or attack type..." 
                        class="w-full bg-slate-900 border border-slate-700/80 rounded-xl text-slate-200 text-xs px-3.5 py-2.5 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-150">
                </div>

                <!-- Severity Filter -->
                <div>
                    <select name="severity" onchange="this.form.submit()" 
                        class="w-full bg-slate-900 border border-slate-700/80 rounded-xl text-slate-300 text-xs px-3.5 py-2.5 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-150">
                        <option value="">All Severities</option>
                        <?php $__currentLoopData = $allSeverities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sev): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($sev); ?>" <?php echo e(request('severity') == $sev ? 'selected' : ''); ?>><?php echo e($sev); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Attack Type Filter -->
                <div>
                    <select name="attack_type" onchange="this.form.submit()" 
                        class="w-full bg-slate-900 border border-slate-700/80 rounded-xl text-slate-300 text-xs px-3.5 py-2.5 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-150">
                        <option value="">All Attacks</option>
                        <?php $__currentLoopData = $allAttackTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($type); ?>" <?php echo e(request('attack_type') == $type ? 'selected' : ''); ?>><?php echo e($type); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </form>

            <!-- Table of Findings -->
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-800 text-[10px] font-bold uppercase tracking-wider text-slate-400 bg-slate-950/40">
                            <th class="px-4 py-3">IP Address</th>
                            <th class="px-4 py-3">Attack Classification</th>
                            <th class="px-4 py-3">Severity</th>
                            <th class="px-4 py-3">Request URI</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3">Timestamp</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/50 text-xs text-slate-300">
                        <?php $__empty_1 = true; $__currentLoopData = $findings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $finding): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-900/10 transition duration-150">
                                <td class="px-4 py-3 font-mono font-semibold text-slate-200"><?php echo e($finding->ip); ?></td>
                                <td class="px-4 py-3 font-semibold text-slate-300"><?php echo e($finding->attack_type); ?></td>
                                <td class="px-4 py-3">
                                    <?php if($finding->severity === 'Critical'): ?>
                                        <span class="bg-red-500/10 text-red-500 border border-red-500/20 px-2 py-0.5 rounded font-bold uppercase tracking-wider text-[9px]">Critical</span>
                                    <?php elseif($finding->severity === 'High'): ?>
                                        <span class="bg-orange-500/10 text-orange-400 border border-orange-500/20 px-2 py-0.5 rounded font-bold uppercase tracking-wider text-[9px]">High</span>
                                    <?php elseif($finding->severity === 'Medium'): ?>
                                        <span class="bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 px-2 py-0.5 rounded font-bold uppercase tracking-wider text-[9px]">Medium</span>
                                    <?php else: ?>
                                        <span class="bg-blue-500/10 text-blue-400 border border-blue-500/20 px-2 py-0.5 rounded font-bold uppercase tracking-wider text-[9px]">Low</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 font-mono text-slate-400 max-w-[200px] truncate" title="<?php echo e($finding->request_uri); ?>">
                                    <?php echo e($finding->request_uri); ?>

                                </td>
                                <td class="px-4 py-3 text-center font-mono font-bold <?php echo e($finding->status >= 400 ? 'text-red-400' : 'text-emerald-400'); ?>"><?php echo e($finding->status); ?></td>
                                <td class="px-4 py-3 font-mono text-slate-500 text-[10px]"><?php echo e($finding->timestamp); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-slate-500 italic">No matching security anomalies found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($findings->hasPages()): ?>
                <div class="pt-4 border-t border-slate-800 bg-slate-950/20">
                    <?php echo e($findings->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\moza1\Desktop\project1.final\resources\views/analysis/show.blade.php ENDPATH**/ ?>