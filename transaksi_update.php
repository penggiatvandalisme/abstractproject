<?php 
// menghubungkan dengan koneksi
include '../koneksi.php';
// menangkap data yang dikirim dari form
$id = $_POST['id'];
$pelanggan = $_POST['pelanggan'];
$banyak = $_POST['banyak'];
$tgl_selesai = $_POST['tgl_selesai'];
$status = $_POST['status'];
// mengambil data harga per pcs dari database
$h = mysqli_query($koneksi,"select harga_per_pcs from harga");
$harga_per_pcs = mysqli_fetch_assoc($h);
// menghitung harga pakaian, harga per pcs x banyak pakaian
$harga = $banyak * $harga_per_pcs['harga_per_pcs'];
// update data transaksi
mysqli_query($koneksi,"update transaksi set transaksi_pelanggan='$pelanggan', 
transaksi_harga='$harga', transaksi_banyak='$banyak', 
transaksi_tgl_selesai='$tgl_selesai', transaksi_status='$status' where 
transaksi_id='$id'");
// menangkap data form input array (jenis pakaian dan jumlah pakaian)
$jenis_pakaian = $_POST['jenis_pakaian'];
$jumlah_pakaian = $_POST['jumlah_pakaian'];
// menghapus semua pakaian dalam transaksi ini
mysqli_query($koneksi,"delete from pakaian where pakaian_transaksi='$id'");
// input ulang data pakaian berdasarkan id transaksi (invoice) ke table pakaian
for($x=0;$x<count($jenis_pakaian);$x++){
if($jenis_pakaian[$x] != ""){
mysqli_query($koneksi,"insert into pakaian 
values('','$id','$jenis_pakaian[$x]','$jumlah_pakaian[$x]')");
}
}
header("location:transaksi.php");
?>