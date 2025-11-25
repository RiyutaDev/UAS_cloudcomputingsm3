<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
  <?php endif; ?>

  <a href="<?= base_url('orders/create'); ?>" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Tambah Order
  </a>

  <div class="card shadow">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th>No</th>
              <th>Kode</th>
              <th>Customer</th>
              <th>Sales</th>
              <th>Status</th>
              <th>Total</th>
              <th>Tanggal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no=1; foreach($orders as $o): ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $o->order_code; ?></td>
              <td><?= $o->customer_name; ?></td>
              <td><?= $o->sales_name; ?></td>
              <td>
                  <?php 
                  $badge = 'secondary';
                  if ($o->status == 'draft') $badge = 'warning';
                  if ($o->status == 'dikirim') $badge = 'info';
                  if ($o->status == 'selesai') $badge = 'success';
                  if ($o->status == 'dibatalkan') $badge = 'danger';
                  ?>
                  <span class="badge badge-<?= $badge; ?>">
                      <?= ucfirst($o->status); ?>
                  </span>
              </td>
              <td>Rp <?= number_format($o->total_price,0,',','.'); ?></td>
              <td><?= date('d-m-Y', strtotime($o->order_date)); ?></td>
              <td>
                  <?php if ($this->session->userdata('role') == 'admin'): ?>
                  
                      <!-- Dropdown Ubah Status -->
                      <form action="<?= base_url('orders/update_status/'.$o->id); ?>" method="post" class="d-inline">
                      <input type="hidden" 
                        name="<?= $this->security->get_csrf_token_name(); ?>" 
                        value="<?= $this->security->get_csrf_hash(); ?>">   
                      <select name="status" class="form-control form-control-sm d-inline" style="width:120px;">
                              <option value="draft"      <?= $o->status=='draft' ? 'selected':'' ?>>Draft</option>
                              <option value="dikirim"    <?= $o->status=='dikirim' ? 'selected':'' ?>>Dikirim</option>
                              <option value="selesai"    <?= $o->status=='selesai' ? 'selected':'' ?>>Selesai</option>
                              <option value="dibatalkan" <?= $o->status=='dibatalkan' ? 'selected':'' ?>>Dibatalkan</option>
                          </select>

                          <button class="btn btn-success btn-sm">
                              <i class="fas fa-sync"></i>
                          </button>
                      </form>

                      <!-- Tombol Hapus -->
                      <a href="<?= base_url('orders/delete/'.$o->id); ?>" class="btn btn-danger btn-sm"
                          onclick="return confirm('Yakin ingin menghapus order ini?')">
                          <i class="fas fa-trash"></i>
                      </a>

                  <?php else: ?>
                      <span class="badge badge-secondary">Tidak dapat diubah</span>
                  <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
