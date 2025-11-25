<div class="container-fluid">

  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= $this->session->flashdata('success'); ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  <?php endif; ?>

  <a href="<?= base_url('customer/create'); ?>" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Tambah Pelanggan
  </a>

  <div class="card shadow">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
          <thead class="bg-primary text-white text-center">
            <tr>
              <th>No</th>
              <th>Kode</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Telepon</th>
              <th>Email</th>
              <th width="150px">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($customers)): ?>
              <?php $no=1; foreach($customers as $c): ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $c->customer_code; ?></td>
                  <td><?= $c->name; ?></td>
                  <td><?= $c->address; ?></td>
                  <td><?= $c->phone; ?></td>
                  <td><?= $c->email; ?></td>
                  <td class="text-center">
                    <a href="<?= base_url('customer/edit/'.$c->id); ?>" class="btn btn-warning btn-sm">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="<?= base_url('customer/delete/'.$c->id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus pelanggan ini?')">
                      <i class="fas fa-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="7" class="text-center text-muted">Belum ada data pelanggan</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
