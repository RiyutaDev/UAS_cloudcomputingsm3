<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <!-- FILTER FORM -->
    <div class="card shadow mb-4">
        <div class="card-body">

            <form method="GET" action="<?= base_url('report'); ?>">

                <div class="row">

                    <!-- FILTER TANGGAL -->
                    <div class="col-md-3">
                        <label>Dari Tanggal</label>
                        <input type="date" name="from"
                               value="<?= isset($_GET['from']) ? $_GET['from'] : '' ?>"
                               class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label>Sampai Tanggal</label>
                        <input type="date" name="to"
                               value="<?= isset($_GET['to']) ? $_GET['to'] : '' ?>"
                               class="form-control">
                    </div>

                    <!-- FILTER SALES -->
                    <div class="col-md-3">
                        <label>Sales</label>
                        <select class="form-control" name="sales_id">
                            <option value="">-- Semua Sales --</option>
                            <?php foreach($sales as $s): ?>
                                <option value="<?= $s->id ?>"
                                    <?= (isset($_GET['sales_id']) && $_GET['sales_id']==$s->id) ? 'selected' : '' ?>>
                                    <?= $s->name ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <!-- FILTER STATUS -->
                    <div class="col-md-3">
                        <label>Status Order</label>
                        <select class="form-control" name="status">
                            <option value="">-- Semua Status --</option>
                            <option value="draft"       <?= isset($_GET['status']) && $_GET['status']=='draft' ? 'selected':'' ?>>Draft</option>
                            <option value="dikirim"     <?= isset($_GET['status']) && $_GET['status']=='dikirim' ? 'selected':'' ?>>Dikirim</option>
                            <option value="selesai"     <?= isset($_GET['status']) && $_GET['status']=='selesai' ? 'selected':'' ?>>Selesai</option>
                            <option value="dibatalkan"  <?= isset($_GET['status']) && $_GET['status']=='dibatalkan' ? 'selected':'' ?>>Dibatalkan</option>
                        </select>
                    </div>

                </div>

                <div class="mt-3">
                    <button class="btn btn-primary">
                        <i class="fas fa-filter"></i> Terapkan Filter
                    </button>

                    <a href="<?= base_url('report'); ?>" class="btn btn-secondary">
                        Reset
                    </a>
                </div>

            </form>

        </div>
    </div>

    <!-- GRAFIK (LINE CHART) -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <strong>Grafik Total Order Berdasarkan Status</strong>
        </div>
        <div class="card-body" style="height:260px;">
            <canvas id="orderChart"></canvas>
        </div>
    </div>

    <!-- TABEL LAPORAN -->
    <div class="card shadow">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
                            <th>Kode Order</th>
                            <th>Customer</th>
                            <th>Sales</th>
                            <th>Status</th>
                            <th>Total Harga</th>
                            <th>Tanggal Order</th>
                            <th>Dikirim</th>
                            <th>Selesai</th>
                            <th>Dibatalkan</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($orders)): $no=1; ?>
                            <?php foreach ($orders as $o): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $o->order_code ?></td>
                                    <td><?= $o->customer_name ?></td>
                                    <td><?= $o->sales_name ?></td>
                                    <td>
                                        <span class="badge badge-<?= 
                                            ($o->status=='draft' ? 'secondary'
                                            : ($o->status=='dikirim' ? 'info'
                                            : ($o->status=='selesai' ? 'success'
                                            : 'danger'))) 
                                        ?>">
                                            <?= ucfirst($o->status) ?>
                                        </span>
                                    </td>
                                    <td>Rp <?= number_format($o->total_price,0,',','.') ?></td>
                                    <td><?= date('d-m-Y H:i:s', strtotime($o->order_date)) ?></td>
                                    <td><?= $o->sent_at ? date('d-m-Y H:i:s', strtotime($o->sent_at)) : '-' ?></td>
                                    <td><?= $o->completed_at ? date('d-m-Y H:i:s', strtotime($o->completed_at)) : '-' ?></td>
                                    <td><?= $o->canceled_at ? date('d-m-Y H:i:s', strtotime($o->canceled_at)) : '-' ?></td>
                                </tr>
                            <?php endforeach; ?>

                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let ctx = document.getElementById('orderChart').getContext('2d');

let orderChart = new Chart(ctx, {
    type: 'bar',  // <--- VERTICAL BAR CHART
    data: {
        labels: <?= json_encode($status_labels) ?>,
        datasets: [{
            label: 'Jumlah Order',
            data: <?= json_encode($status_totals) ?>,

            backgroundColor: [
                'yellow',   // draft
                'aqua',     // dikirim
                'green',    // selesai
                'red'       // dibatalkan
            ],
            borderColor: [
                'yellow',
                'aqua',
                'green',
                'red'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});
</script>
<!-- END CHART JS -->
