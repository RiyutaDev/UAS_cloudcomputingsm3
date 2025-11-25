<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-body">

            <!-- FILTER FORM -->
            <form class="form-inline mb-3" method="GET" action="<?= base_url('audit_log') ?>">

                <div class="form-group mr-2">
                    <input type="date" name="start_date" class="form-control"
                        value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>">
                </div>

                <div class="form-group mr-2">
                    <input type="date" name="end_date" class="form-control"
                        value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : '' ?>">
                </div>

                <div class="form-group mr-2">
                    <select name="user_id" class="form-control">
                        <option value="">-- Semua User --</option>
                        <?php foreach ($users as $u): ?>
                            <option value="<?= $u->id ?>"
                                <?= (isset($_GET['user_id']) && $_GET['user_id'] == $u->id) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($u->fullname . ' (' . $u->username . ')') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group mr-2">
                    <select name="action" class="form-control">
                        <option value="">-- Semua Aksi --</option>
                        <option value="login"  <?= (@$_GET['action']=='login')?'selected':'' ?>>Login</option>
                        <option value="logout" <?= (@$_GET['action']=='logout')?'selected':'' ?>>Logout</option>
                        <option value="create" <?= (@$_GET['action']=='create')?'selected':'' ?>>Create</option>
                        <option value="update" <?= (@$_GET['action']=='update')?'selected':'' ?>>Update</option>
                        <option value="delete" <?= (@$_GET['action']=='delete')?'selected':'' ?>>Delete</option>
                        <option value="error"  <?= (@$_GET['action']=='error')?'selected':'' ?>>Error</option>
                    </select>
                </div>

                <div class="form-group mr-2">
                    <input type="text" name="q" class="form-control" placeholder="Cari..."
                        value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>">
                </div>

                <button class="btn btn-primary mr-2"><i class="fas fa-filter"></i> Tampilkan</button>

                <a class="btn btn-secondary mr-2" href="<?= base_url('audit_log') ?>">
                    <i class="fas fa-sync"></i> Reset
                </a>

                <a class="btn btn-success mr-2"
                    href="<?= site_url('audit_log/export_csv') . '?' . $_SERVER['QUERY_STRING'] ?>">
                    <i class="fas fa-file-csv"></i> Export CSV
                </a>

                <?php if ($this->session->userdata('role_id') == 1): ?>
                    <form method="post" action="<?= site_url('audit_log/truncate') ?>" style="display:inline;">
                        <input type="hidden" 
                            name="<?= $this->security->get_csrf_token_name(); ?>" 
                            value="<?= $this->security->get_csrf_hash(); ?>">

                        <button class="btn btn-danger"
                            onclick="return confirm('Yakin ingin menghapus semua log?')">
                            <i class="fas fa-trash"></i> Hapus Semua
                        </button>
                    </form>
                <?php endif; ?>

            </form>

            <!-- CHART SECTION -->
            <div class="mb-4">
                <canvas id="logChart" height="110"></canvas>
            </div>

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Waktu</th>
                            <th>User</th>
                            <th>Aksi</th>
                            <th>Detail</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($logs)): $no=1; foreach ($logs as $log): ?>
                        <tr class="<?= ($log->action == 'error') ? 'table-danger' : '' ?>">
                            <td><?= $no++; ?></td>
                            <td><?= date('d-m-Y H:i:s', strtotime($log->created_at)) ?></td>
                            <td><?= htmlspecialchars($log->fullname . ' (' . $log->username . ')') ?></td>

                            <td>
                                <?php
                                    $badge = [
                                        'login'  => 'success',
                                        'logout' => 'secondary',
                                        'create' => 'primary',
                                        'update' => 'warning',
                                        'delete' => 'danger',
                                        'error'  => 'dark'
                                    ][$log->action] ?? 'secondary';
                                ?>
                                <span class="badge badge-<?= $badge ?>">
                                    <?= ucfirst($log->action) ?>
                                </span>
                            </td>

                            <td title="<?= htmlspecialchars($log->detail) ?>">
                                <?= (strlen($log->detail) > 90) ? htmlspecialchars(substr($log->detail, 0, 90)) . '...' : htmlspecialchars($log->detail) ?>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Belum ada data log.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const ctx = document.getElementById('logChart').getContext('2d');

    const labels = <?= $chart_labels ?>;

    const chartData = {
        labels: labels,
        datasets: [
            {
                label: 'Login',
                data: <?= $chart_login ?>,
                backgroundColor: 'rgba(40, 167, 69, 0.7)',
                borderColor: 'rgb(40, 167, 69)',
                borderWidth: 1
            },
            {
                label: 'Logout',
                data: <?= $chart_logout ?>,
                backgroundColor: 'rgba(23, 162, 184, 0.7)',
                borderColor: 'rgb(23, 162, 184)',
                borderWidth: 1
            },
            {
                label: 'Create',
                data: <?= $chart_create ?>,
                backgroundColor: 'rgba(0, 123, 255, 0.7)',
                borderColor: 'rgb(0, 123, 255)',
                borderWidth: 1
            },
            {
                label: 'Update',
                data: <?= $chart_update ?>,
                backgroundColor: 'rgba(255, 193, 7, 0.7)',
                borderColor: 'rgb(255, 193, 7)',
                borderWidth: 1
            },
            {
                label: 'Delete',
                data: <?= $chart_delete ?>,
                backgroundColor: 'rgba(220, 53, 69, 0.7)',
                borderColor: 'rgb(220, 53, 69)',
                borderWidth: 1
            },
            {
                label: 'Error',
                data: <?= $chart_error ?>,
                backgroundColor: 'rgba(52, 58, 64, 0.7)',
                borderColor: 'rgb(52, 58, 64)',
                borderWidth: 1
            }
        ]
    };

    new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

});
</script>
