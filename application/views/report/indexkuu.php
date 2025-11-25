<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Laporan Penjualan</h6>
        </div>
        <div class="card-body">

            <div class="table-responsive">
            <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode Order</th>
                            <th>Customer</th>
                            <th>Sales</th>
                            <th>Status</th>
                            <th>Tanggal Order</th>
                            <th>Dikirim Pada</th>
                            <th>Selesai Pada</th>
                            <th>Dibatalkan Pada</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($orders as $o): ?>
                        <tr>
                            <td><?= $o->order_code ?></td>
                            <td><?= $o->customer_name ?></td>
                            <td><?= $o->sales_name ?></td>

                            <!-- STATUS -->
                            <td>
                                <?php if ($o->status == 'draft'): ?>
                                    <span class="badge bg-secondary">Draft</span>
                                <?php elseif ($o->status == 'dikirim'): ?>
                                    <span class="badge bg-info">Dikirim</span>
                                <?php elseif ($o->status == 'selesai'): ?>
                                    <span class="badge bg-success">Selesai</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Dibatalkan</span>
                                <?php endif; ?>
                            </td>

                            <td><?= $o->order_date ?></td>
                            <td><?= $o->sent_at ?: '-' ?></td>
                            <td><?= $o->completed_at ?: '-' ?></td>
                            <td><?= $o->canceled_at ?: '-' ?></td>
                            <td>Rp <?= number_format($o->total_price, 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</div>
