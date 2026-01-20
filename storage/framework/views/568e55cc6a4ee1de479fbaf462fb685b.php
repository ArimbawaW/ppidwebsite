<div class="ppid-section">
    <div class="container">
        <h2 class="ppid-title">PPID PELAKSANA PUSAT</h2>

        <?php
            $ppidItems = [
                [
                    'label' => ['Sekretariat Jenderal'],
                    'url' => 'https://pkp.go.id/'
                ],
                [
                    'label' => ['Inspektorat Jenderal'],
                    'url' => 'https://pkp.go.id/'
                ],
                [
                    'label' => ['Direktorat Jenderal', 'Kawasan Permukiman'],
                    'url' => 'https://pkp.go.id/'
                ],
                [
                    'label' => ['Direktorat Jenderal', 'Perumahan Perdesaan'],
                    'url' => 'https://pkp.go.id/unor/direktorat-jenderal-perumahan-perdesaan'
                ],
                [
                    'label' => ['Direktorat Jenderal', 'Perumahan Perkotaan'],
                    'url' => 'https://pkp.go.id/'
                ],
                [
                    'label' => ['Direktorat Jenderal', 'Tata Kelola dan', 'Pengendalian Risiko'],
                    'url' => 'https://pkp.go.id/unor/direktorat-jenderal-tata-kelola-dan-pengendalian-risiko'
                ],
            ];
        ?>

        <div class="row g-4 mb-4">
            <?php $__currentLoopData = array_slice($ppidItems, 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4">
                    <?php if($item['url']): ?>
                        <a href="<?php echo e($item['url']); ?>" target="_blank" class="ppid-link">
                    <?php endif; ?>

                    <div class="ppid-card <?php echo e($item['url'] ? 'ppid-card-clickable' : ''); ?>">
                        <h5><?php echo implode('<br>', $item['label']); ?></h5>
                    </div>

                    <?php if($item['url']): ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="row g-4">
            <?php $__currentLoopData = array_slice($ppidItems, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4">
                    <?php if($item['url']): ?>
                        <a href="<?php echo e($item['url']); ?>" target="_blank" class="ppid-link">
                    <?php endif; ?>

                    <div class="ppid-card <?php echo e($item['url'] ? 'ppid-card-clickable' : ''); ?>">
                        <h5><?php echo implode('<br>', $item['label']); ?></h5>
                    </div>

                    <?php if($item['url']): ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php /**PATH C:\ppid\resources\views/components/ppid-section.blade.php ENDPATH**/ ?>