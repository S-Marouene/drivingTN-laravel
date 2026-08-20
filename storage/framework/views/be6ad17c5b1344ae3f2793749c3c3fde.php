<!doctype html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($title ?? 'Permis TN'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
      :root{--tn-red:#d71920;--tn-navy:#12233f;--tn-gold:#f5c542} body{background:#f5f7fb;color:#1f2937}.navbar{background:var(--tn-navy)}.brand-dot{color:var(--tn-red)}.hero{background:linear-gradient(135deg,#12233f 0%,#1e4772 100%);color:#fff;border-radius:0 0 2rem 2rem}.card{border:0;box-shadow:0 8px 24px #12233f12}.arabic{direction:rtl;text-align:right;font-family:Arial,Tahoma,sans-serif;line-height:1.8}.btn-primary{background:var(--tn-red);border-color:var(--tn-red)}.btn-primary:hover{background:#b81319;border-color:#b81319}.progress{height:9px}.question-card img{max-height:230px;object-fit:contain}.option{border:1px solid #d9e0ea;border-radius:.75rem;padding:1rem;cursor:pointer;transition:.2s}.option:hover{border-color:var(--tn-red);background:#fff7f7}.option input:checked + span{font-weight:700;color:var(--tn-red)}
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark"><div class="container"><a class="navbar-brand fw-bold" href="<?php echo e(route('home')); ?>"><i class="bi bi-sign-turn-right-fill brand-dot"></i> Permis TN</a><div class="ms-auto d-flex gap-2"><a class="btn btn-sm btn-outline-light" href="<?php echo e(route('home')); ?>">Accueil</a><a class="btn btn-sm btn-warning" href="<?php echo e(route('admin.index')); ?>"><i class="bi bi-shield-lock"></i> Administration</a></div></div></nav>
<main><?php if(session('success')): ?><div class="container mt-3"><div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?><button class="btn-close" data-bs-dismiss="alert"></button></div></div><?php endif; ?> <?php if($errors->any()): ?><div class="container mt-3"><div class="alert alert-danger"><strong>Veuillez corriger :</strong><ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div></div><?php endif; ?> <?php echo $__env->yieldContent('content'); ?></main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script><?php echo $__env->yieldContent('scripts'); ?>
</body></html>
<?php /**PATH D:\www\drivingTN-laravel\resources\views/layout.blade.php ENDPATH**/ ?>