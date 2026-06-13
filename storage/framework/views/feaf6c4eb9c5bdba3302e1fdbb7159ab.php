<?php $__env->startSection('header_title', 'User Access & Policy Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    
    <!-- Header banner -->
    <div class="glass-panel p-6 rounded-2xl border-l-4 border-red-500 flex items-center justify-between">
        <div>
            <h3 class="text-xl font-bold text-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-users-gear text-red-500"></i>
                SOC Analyst Access Policies
            </h3>
            <p class="text-sm text-slate-400 mt-1">Review registered operations profiles, elevate authorizations, or audit analysts on this terminal node.</p>
        </div>
        <div class="px-4 py-2 bg-red-500/10 border border-red-500/20 text-red-400 font-mono text-xs rounded-lg uppercase tracking-wider">
            Clearance Level: Admin Only
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="glass-panel rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-slate-800 flex items-center justify-between">
            <h4 class="text-md font-semibold text-slate-200">Terminal Operators Registry</h4>
            <span class="text-xs text-slate-500 font-mono">Nodes Connected: <?php echo e($users->count()); ?></span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-800 text-xs font-bold uppercase tracking-wider text-slate-400 bg-slate-950/40">
                        <th class="px-6 py-4">Operator Name</th>
                        <th class="px-6 py-4">Security Identifier (Email)</th>
                        <th class="px-6 py-4">Role Clearance</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-sm text-slate-300">
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-slate-900/20 transition duration-150">
                            <!-- Name -->
                            <td class="px-6 py-4 font-semibold text-slate-200">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-slate-400 font-mono text-xs">
                                        <?php echo e(strtoupper(substr($user->name, 0, 2))); ?>

                                    </div>
                                    <div>
                                        <span><?php echo e($user->name); ?></span>
                                        <?php if($user->id === Auth::id()): ?>
                                            <span class="ml-2 text-[9px] bg-slate-800 text-slate-400 border border-slate-700 px-1.5 py-0.5 rounded font-bold">YOU</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Email -->
                            <td class="px-6 py-4 font-mono text-slate-400">
                                <?php echo e($user->email); ?>

                            </td>
                            
                            <!-- Role badge -->
                            <td class="px-6 py-4">
                                <?php if($user->role === 'admin'): ?>
                                    <span class="inline-flex items-center gap-1.5 text-xs bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2 py-1 rounded-full font-bold uppercase tracking-wide">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        ADMIN
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 text-xs bg-blue-500/10 text-blue-400 border border-blue-500/20 px-2 py-1 rounded-full font-bold uppercase tracking-wide">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                        ANALYST
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Update role -->
                            <td class="px-6 py-4 text-right">
                                <?php if($user->id !== Auth::id()): ?>
                                    <form method="POST" action="<?php echo e(route('admin.users.update', $user)); ?>" class="inline-flex items-center gap-2">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <select name="role" onchange="this.form.submit()" 
                                            class="bg-slate-900 border border-slate-700 rounded-lg text-xs px-2.5 py-1.5 text-slate-300 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-150">
                                            <option value="analyst" <?php echo e($user->role === 'analyst' ? 'selected' : ''); ?>>Demote Analyst</option>
                                            <option value="admin" <?php echo e($user->role === 'admin' ? 'selected' : ''); ?>>Elevate Admin</option>
                                        </select>
                                    </form>
                                <?php else: ?>
                                    <span class="text-xs text-slate-500 italic">Self operations locked</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\moza1\Desktop\project1.final\resources\views/admin/users.blade.php ENDPATH**/ ?>