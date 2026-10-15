<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $nama      = $_POST['nama'];
    $alamat    = $_POST['alamat'];
    $notelp    = $_POST['notelp'];
    $catatan   = $_POST['catatan'];

    mysqli_query($koneksi, "INSERT INTO datapelanggan (nama, alamat, notelp, catatan) VALUES ('$nama', '$alamat', '$notelp', '$catatan')");
    header("Location: modul.php");
    exit;
}

if (isset($_POST['update'])) {
    $id_pelanggan = $_POST['id_pelanggan'];
    $nama         = $_POST['nama'];
    $alamat       = $_POST['alamat'];
    $notelp       = $_POST['notelp'];
    $catatan      = $_POST['catatan'];

    mysqli_query($koneksi, "UPDATE datapelanggan SET nama='$nama', alamat='$alamat', notelp='$notelp', catatan='$catatan' WHERE id_pelanggan='$id_pelanggan'");
    header("Location: modul.php");
    exit;
}


$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'read';


if ($aksi == 'hapus' && isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM datapelanggan WHERE id_pelanggan='$id'");
    header("Location: modul.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark"> <!-- Menambahkan data-bs-theme="dark" bawaan Bootstrap -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Modul Data Pelanggan</title>
</head>
<body>

<?php

switch ($aksi) {
    
    
    case 'read':
?>
    <div class="container">
        <h1>Data Pelanggan</h1>
        <div class="card-custom">
            <a href="modul.php?aksi=tambah" class="btn btn-primary mb-4">+ Tambah Data</a>
            
            <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">No</th>
                      <th scope="col">Nama</th>
                      <th scope="col">Alamat</th>
                      <th scope="col">No.Telpon</th>
                      <th scope="col">Catatan</th>
                      <th scope="col" class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $query = mysqli_query($koneksi, "SELECT * FROM datapelanggan");
                    while ($data = mysqli_fetch_array($query)) {
                    ?>
                    <tr>
                      <th scope="row"><?php echo $no++; ?></th>
                      <td><?php echo htmlspecialchars($data['nama']); ?></td>
                      <td><?php echo htmlspecialchars($data['alamat']); ?></td>
                      <td><?php echo htmlspecialchars($data['notelp']); ?></td>
                      <td><?php echo htmlspecialchars($data['catatan']); ?></td>
                      <td class="text-center">
                          <a href="modul.php?aksi=detail&id=<?php echo $data['id_pelanggan']; ?>" class="btn btn-secondary text-light btn-sm">Detail</a>
                          <a href="modul.php?aksi=edit&id=<?php echo $data['id_pelanggan']; ?>" class="btn btn-warning text-light btn-sm">Edit</a>
                          <a href="modul.php?aksi=hapus&id=<?php echo $data['id_pelanggan']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
            </div>
        </div>
    </div>
<?php
    break;

    case 'tambah':
?>
    <div class="container" style="max-width: 600px;">
        <h1>Tambah Data Pelanggan</h1>
        <div class="card-custom">
            <form method="POST" action="modul.php">
                <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama" required>
                </div>
                <div class="mb-3">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control" placeholder="Masukkan alamat lengkap" required>
                </div>
                <div class="mb-3">
                    <label>No. Telpon</label>
                    <input type="text" name="notelp" class="form-control" placeholder="Contoh: 08123456789" required> 
                </div>
                <div class="mb-4">
                    <label>Catatan</label>
                    <input type="text" name="catatan" class="form-control" placeholder="Tambahkan catatan (opsional)">
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" name="simpan" class="btn btn-primary w-100">Simpan Data</button>
                    <a href="modul.php" class="btn btn-secondary w-100">Batal</a>
                </div>
            </form>
        </div>
    </div>
<?php
    break;

    case 'edit':
        $id = $_GET['id'];
        $query = mysqli_query($koneksi, "SELECT * FROM datapelanggan WHERE id_pelanggan='$id'");
        $data = mysqli_fetch_array($query);
?>
    <div class="container" style="max-width: 600px;">
        <h1>Edit Data Pelanggan</h1>
        <div class="card-custom">
            <form method="POST" action="modul.php">
                <input type="hidden" name="id_pelanggan" value="<?php echo $data['id_pelanggan']; ?>">
                
                <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" value="<?php echo $data['nama']; ?>" required>
                </div>
                <div class="mb-3">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control" value="<?php echo $data['alamat']; ?>" required>
                </div>
                <div class="mb-3">
                    <label>No. Telpon</label>
                    <input type="text" name="notelp" class="form-control" value="<?php echo $data['notelp']; ?>" required>
                </div>
                <div class="mb-4">
                    <label>Catatan</label>
                    <input type="text" name="catatan" class="form-control" value="<?php echo $data['catatan']; ?>">
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" name="update" class="btn btn-primary w-100">Update Data</button>
                    <a href="modul.php" class="btn btn-secondary w-100">Batal</a>
                </div>
            </form>
        </div>
    </div>
<?php
    break;
    case 'detail':
        $id = $_GET['id'];
        $query = mysqli_query($koneksi, "SELECT * FROM datapelanggan WHERE id_pelanggan='$id'");
        $data = mysqli_fetch_array($query);
?>
    <div class="container" style="max-width: 800px;">
        <h1>Detail Pelanggan</h1>
        <div class="card-custom">
            <table class="table mb-4">
              <thead>
                <tr>
                  <th scope="col">Nama</th>
                  <th scope="col">Alamat</th>
                  <th scope="col">No. Telpon</th>
                  <th scope="col">Catatan</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><?php echo $data['nama']; ?></td>
                  <td><?php echo $data['alamat']; ?></td>
                  <td><?php echo $data['notelp']; ?></td>
                  <td><?php echo $data['catatan']; ?></td>
                </tr>
              </tbody>
            </table>
            <a href="modul.php" class="btn btn-secondary w-100">Kembali</a>
        </div>
    </div>
<?php
    break;
}
?>

</body>
</html>