<?php $__env->startSection('title', 'Chi tiết khách hàng'); ?>

<?php $__env->startSection('page_title', $customer->full_name); ?>
<?php $__env->startSection('page_subtitle', 'Thông tin khách hàng và lịch sử đặt lịch'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row g-4 mb-4">
        <div class="col-lg-5">
            <div class="admin-card">
                <h5 class="fw-bold mb-3">Thông tin tài khoản</h5>
                <dl class="row mb-0 small">
                    <dt class="col-sm-4 text-muted">Email</dt>
                    <dd class="col-sm-8"><?php echo e($customer->email); ?></dd>
                    <dt class="col-sm-4 text-muted">SĐT</dt>
                    <dd class="col-sm-8"><?php echo e($customer->phone ?? '—'); ?></dd>
                    <dt class="col-sm-4 text-muted">Địa chỉ</dt>
                    <dd class="col-sm-8"><?php echo e($customer->address ?? '—'); ?></dd>
                    <dt class="col-sm-4 text-muted">Ngày tạo</dt>
                    <dd class="col-sm-8"><?php echo e($customer->created_at?->format('d/m/Y H:i')); ?></dd>
                    <dt class="col-sm-4 text-muted">Tổng lịch đặt</dt>
                    <dd class="col-sm-8"><strong><?php echo e($customer->bookings_count); ?></strong></dd>
                </dl>
                <div class="d-flex gap-2 mt-3">
                    <a href="<?php echo e(route('admin.customers.edit', $customer)); ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-pencil me-1"></i> Sửa
                    </a>
                    <a href="<?php echo e(route('admin.customers.index')); ?>" class="btn btn-light btn-sm">Quay lại</a>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-card p-0 overflow-hidden">
        <div class="p-3 border-bottom">
            <h5 class="fw-bold mb-0">Lịch sử đặt lịch</h5>
        </div>
        <div class="table-responsive">
            <table class="table admin-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Mã</th>
                        <th>HDV</th>
                        <th>Ngày tour</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>#<?php echo e($booking->id); ?></td>
                            <td><?php echo e($booking->guide?->full_name); ?></td>
                            <td class="small">
                                <?php echo e($booking->start_date->format('d/m/Y')); ?> — <?php echo e($booking->end_date->format('d/m/Y')); ?>

                                <span class="text-muted">(<?php echo e($booking->daysCount()); ?> ngày)</span>
                            </td>
                            <td class="fw-semibold"><?php echo e(number_format($booking->total_price, 0, ',', '.')); ?> đ</td>
                            <td><?php echo $__env->make('admin.partials.booking-status', ['status' => $booking->status], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></td>
                            <td class="text-end">
                                <a href="<?php echo e(route('admin.bookings.show', $booking)); ?>" class="btn btn-sm btn-light">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Chưa có lịch đặt.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($bookings->hasPages()): ?>
            <div class="p-3 border-top"><?php echo e($bookings->links()); ?></div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\webhdvdulich\resources\views/admin/customers/show.blade.php ENDPATH**/ ?>