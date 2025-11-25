<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Daftar Produk</h1>
    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
        <?= $this->session->flashdata('success'); ?>
    </div>
    <?php endif; ?>


    <a href="<?= site_url('product/create'); ?>" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Tambah Produk
    </a>

    <table class="table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th width="50">No</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): ?>
                <?php $no = 1; foreach ($products as $p): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($p->product_code); ?></td>
                    <td><?= htmlspecialchars($p->name); ?></td>
                    <td>Rp <?= number_format($p->price, 2, ',', '.'); ?></td>
                    <td>
                        <?php
                            $stock = $p->stock;

                            if ($stock <= 5) {
                                $badge = 'badge badge-danger';   // merah
                            } elseif ($stock <= 10) {
                                $badge = 'badge badge-warning';  // kuning
                            } else {
                                $badge = 'badge badge-success';  // hijau
                            }
                        ?>
                        <span class="<?= $badge; ?>"><?= htmlspecialchars($stock); ?></span>
                    </td>

                    <td>
                        <a href="<?= site_url('product/edit/'.$p->id); ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <a href="<?= site_url('product/delete/'.$p->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus produk ini?');"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Belum ada data produk.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>
