<div class="container-fluid">
  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
  <?php endif; ?>

  <a href="<?= base_url('sales/create'); ?>" class="btn btn-primary mb-3">
    <i class="fas fa-plus"></i> Tambah Sales
  </a>

  <div class="card shadow">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th>No</th>
              <th>Kode Sales</th>
              <th>Nama</th>
              <th>Telepon</th>
              <th>Email</th>
              <th>Catatan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no=1; foreach($sales as $row): ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $row->sales_code; ?></td>
              <td><?= $row->name; ?></td>
              <td><?= $row->phone; ?></td>
              <td><?= $row->email; ?></td>
              <td><?= $row->note; ?></td>
              <td>
                <a href="<?= base_url('sales/edit/'.$row->id); ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                <a href="<?= base_url('sales/delete/'.$row->id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')"><i class="fas fa-trash"></i></a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
