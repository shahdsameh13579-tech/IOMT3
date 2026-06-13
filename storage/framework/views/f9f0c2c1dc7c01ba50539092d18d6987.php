<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CyberForensics AI Platform - Security Incident Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333333;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        @page {
            margin: 50px 40px 60px 40px;
        }
        .header {
            border-bottom: 2px solid #ef4444;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .logo-title {
            float: left;
        }
        .logo-title h1 {
            font-size: 20px;
            margin: 0;
            color: #ef4444;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .logo-title span {
            font-size: 9px;
            color: #777777;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
        }
        .meta-info {
            float: right;
            text-align: right;
            font-size: 10px;
            color: #555555;
        }
        .clear {
            clear: both;
        }
        .section-title {
            font-size: 14px;
            color: #111111;
            border-bottom: 1px solid #dddddd;
            padding-bottom: 5px;
            margin-top: 25px;
            margin-bottom: 12px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .summary-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #ef4444;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .summary-card p {
            margin: 0;
            font-size: 11.5px;
            color: #475569;
        }
        /* Metrics Table Grid */
        .metrics-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .metrics-table td {
            width: 25%;
            padding: 12px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            text-align: center;
        }
        .metrics-table .val {
            font-size: 18px;
            font-weight: bold;
            color: #1e293b;
            margin-top: 4px;
        }
        .metrics-table .lbl {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
        }
        /* Details Table */
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .details-table th {
            background-color: #0f172a;
            color: #ffffff;
            font-size: 9px;
            text-transform: uppercase;
            padding: 8px 10px;
            text-align: left;
        }
        .details-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10.5px;
            vertical-align: top;
        }
        .details-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 8px;
            font-weight: bold;
            border-radius: 3px;
            text-transform: uppercase;
        }
        .badge-critical { background-color: #fee2e2; color: #ef4444; }
        .badge-high { background-color: #ffedd5; color: #f97316; }
        .badge-medium { background-color: #fef9c3; color: #ca8a04; }
        .badge-low { background-color: #dbeafe; color: #3b82f6; }
        
        .recommendation-list {
            margin: 0;
            padding-left: 20px;
        }
        .recommendation-list li {
            margin-bottom: 8px;
            font-size: 11px;
            color: #334155;
        }
        .footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 20px;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 5px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div class="logo-title">
            <h1>Forensic Audit Report</h1>
            <span>AI Intrusion Detection System</span>
        </div>
        <div class="meta-info">
            <strong>Case ID:</strong> #<?php echo e($analysis->id); ?><br>
            <strong>Date:</strong> <?php echo e($analysis->created_at->format('Y-m-d H:i:s')); ?><br>
            <strong>Investigator:</strong> <?php echo e($analysis->log->user->name); ?>

        </div>
        <div class="clear"></div>
    </div>

    <!-- Executive Summary Card -->
    <div class="section-title">1. Executive Summary</div>
    <div class="summary-card">
        <p>
            An automated forensic analysis has been performed on the web server log package <strong><?php echo e($analysis->log->file_name); ?></strong>. 
            The detection layer utilized a supervised voting ensemble classifier (Random Forest, XGBoost, LightGBM) for signature recognition, alongside 
            an Isolation Forest model to detect anomalous patterns and zero-day threat variants. 
            Out of <strong><?php echo e(number_format($analysis->total_entries)); ?></strong> parsed requests, 
            <strong><?php echo e(number_format($analysis->total_findings)); ?></strong> potential attack instances were classified as malicious.
        </p>
    </div>

    <!-- Metrics Block -->
    <table class="metrics-table">
        <tr>
            <td>
                <div class="lbl">Threat Detections</div>
                <div class="val" style="color: #ef4444;"><?php echo e($analysis->total_findings); ?></div>
            </td>
            <td>
                <div class="lbl">Zero-Day Rate</div>
                <div class="val" style="color: #a855f7;"><?php echo e($analysis->zero_day_rate); ?>%</div>
            </td>
            <td>
                <div class="lbl">Model Accuracy</div>
                <div class="val" style="color: #10b981;"><?php echo e(round($analysis->accuracy * 100, 1)); ?>%</div>
            </td>
            <td>
                <div class="lbl">Log Entries</div>
                <div class="val"><?php echo e(number_format($analysis->total_entries)); ?></div>
            </td>
        </tr>
    </table>

    <!-- Threat Breakdown -->
    <div class="section-title">2. Threat Classification Breakdown</div>
    <table class="details-table">
        <thead>
            <tr>
                <th style="width: 70%;">Attack Classification Type</th>
                <th style="width: 30%; text-align: right;">Occurrences Detected</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $attackDistribution; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="font-weight: bold; color: #475569;"><?php echo e($type); ?></td>
                    <td style="text-align: right; font-weight: bold; font-family: monospace;"><?php echo e($count); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if(empty($attackDistribution)): ?>
                <tr>
                    <td colspan="2" style="text-align: center; color: #777777; font-style: italic;">No malicious patterns detected.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Security Recommendations -->
    <div class="section-title">3. Security Action Plan</div>
    <ul class="recommendation-list">
        <?php if(isset($attackDistribution['SQLi']) && $attackDistribution['SQLi'] > 0): ?>
            <li><strong>Mitigate SQL Injection (SQLi)</strong>: Enforce parameterized queries or prepared statements across all database endpoints. Review logs for unauthorized database calls returning status code 200.</li>
        <?php endif; ?>
        <?php if(isset($attackDistribution['XSS']) && $attackDistribution['XSS'] > 0): ?>
            <li><strong>Mitigate Cross-Site Scripting (XSS)</strong>: Implement strong Context-Aware Output Encoding. Configure a strict Content Security Policy (CSP) header to disable inline scripts.</li>
        <?php endif; ?>
        <?php if(isset($attackDistribution['Directory Traversal']) && $attackDistribution['Directory Traversal'] > 0): ?>
            <li><strong>Mitigate Directory Traversal</strong>: Restrict application file read permissions. Avoid passing direct file path parameters via GET inputs. Sanitize path paths against parent directory markers (`../`).</li>
        <?php endif; ?>
        <?php if(isset($attackDistribution['Command Injection']) && $attackDistribution['Command Injection'] > 0): ?>
            <li><strong>Mitigate Remote Command Injection</strong>: Do not use system execution operations (`exec`, `passthru`, `system`) on user-supplied inputs. If unavoidable, use strict whitelisting.</li>
        <?php endif; ?>
        <?php if(isset($attackDistribution['Credential Stuffing']) && $attackDistribution['Credential Stuffing'] > 0): ?>
            <li><strong>Mitigate Credential Stuffing / Brute Force</strong>: Enforce account lockout after repeated failed login attempts. Deploy CAPTCHA on login forms. Implement IP-based rate-limiting on authentication endpoints. Enable Multi-Factor Authentication (MFA) for all user accounts.</li>
        <?php endif; ?>
        <?php if(isset($attackDistribution['Vulnerability Scan']) && $attackDistribution['Vulnerability Scan'] > 0): ?>
            <li><strong>Mitigate Vulnerability Scanning</strong>: Remove or restrict access to sensitive files (.env, .git/config, backup archives). Return generic 404 responses for non-existent paths. Deploy intrusion prevention rules to block known scanner User-Agent strings (Zgrab, Masscan, Nikto). Disable directory listing on all web servers.</li>
        <?php endif; ?>
        <?php if(isset($attackDistribution['Zero-Day Anomaly']) && $attackDistribution['Zero-Day Anomaly'] > 0): ?>
            <li><strong>Mitigate Zero-Day Threats</strong>: Investigate suspicious traffic from the anomalous IPs immediately. Deploy a Web Application Firewall (WAF) in learning mode to capture and filter outlier request footprints.</li>
        <?php endif; ?>
        <li><strong>Continuous Monitoring</strong>: Restrict root or directory indexing access on Nginx/Apache. Audit and update host packages, and configure rate-limiting policies for all public-facing endpoints.</li>
    </ul>

    <!-- Page Break for Evidence Table if needed -->
    <div style="page-break-before: always;"></div>

    <div class="header">
        <div class="logo-title">
            <h1>Evidence Ledger</h1>
            <span>Auditable Attack Log Entries</span>
        </div>
        <div class="meta-info">
            <strong>Case ID:</strong> #<?php echo e($analysis->id); ?><br>
            <strong>Showing Top:</strong> <?php echo e(min(100, $findings->count())); ?> findings
        </div>
        <div class="clear"></div>
    </div>

    <!-- Evidence Table -->
    <table class="details-table">
        <thead>
            <tr>
                <th style="width: 15%;">Timestamp</th>
                <th style="width: 15%;">Source IP</th>
                <th style="width: 15%;">Attack Type</th>
                <th style="width: 10%;">Severity</th>
                <th style="width: 37%;">Request URI</th>
                <th style="width: 8%; text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $findings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $finding): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td style="font-size: 9.5px; font-family: monospace;"><?php echo e($finding->timestamp); ?></td>
                    <td style="font-weight: bold; font-family: monospace;"><?php echo e($finding->ip); ?></td>
                    <td><?php echo e($finding->attack_type); ?></td>
                    <td>
                        <?php if($finding->severity === 'Critical'): ?>
                            <span class="badge badge-critical">Critical</span>
                        <?php elseif($finding->severity === 'High'): ?>
                            <span class="badge badge-high">High</span>
                        <?php elseif($finding->severity === 'Medium'): ?>
                            <span class="badge badge-medium">Medium</span>
                        <?php else: ?>
                            <span class="badge badge-low">Low</span>
                        <?php endif; ?>
                    </td>
                    <td style="font-family: monospace; font-size: 9.5px; word-break: break-all;">
                        <?php echo e($finding->request_uri); ?>

                    </td>
                    <td style="text-align: center; font-weight: bold; font-family: monospace; color: <?php echo e($finding->status >= 400 ? '#ef4444' : '#10b981'); ?>"><?php echo e($finding->status); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: #777777; font-style: italic;">No specific threat entries documented.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        CONFIDENTIAL - CyberForensics AI Platform Security Audit Report - Page 2 of 2
    </div>

</body>
</html>
<?php /**PATH C:\Users\moza1\Desktop\project1.final\resources\views/reports/forensic.blade.php ENDPATH**/ ?>