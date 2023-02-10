<?php 
// menghubungkan dengan koneksi
include '../koneksi.php';
// menangkap data yang dikirim dari form
$pelanggan = $_POST['pelanggan'];
$berat = $_POST['banyak'];
$tgl_selesai = $_POST['tgl_selesai'];
$tgl_hari_ini = date('Y-m-d');
$status = 0;
// mengambil data harga per pcs dari database
$h = mysqli_query($koneksi,"select harga_per_pcs from harga");
$harga_per_pcs = mysqli_fetch_assoc($h);
// menghitung harga pesanan, harga per pcs x banyak pesanan
$harga = $berat * $harga_per_pcs['harga_per_pcs'];
// input data ke tabel transaksi
mysqli_query($koneksi,"insert into transaksi 
values('','$tgl_hari_ini','$pelanggan','$harga','$banyak','$tgl_selesai','$sta
tus')");
// menyimpan id dari data yang di simpan pada query insert data sebelumnya
$id_terakhir = mysqli_insert_id($koneksi);
// menangkap data form input array (jenis pakaian dan jumlah pakaian)
$jenis_pakaian = $_POST['jenis_pakaian'];
$jumlah_pakaian = $_POST['jumlah_pakaian'];
// input data pesanan berdasarkan id transaksi (invoice) ke table pakaian
for($x=0;$x<count($jenis_pakaian);$x++){
if($jenis_pakaian[$x] != ""){
mysqli_query($koneksi,"insert into pakaian 
values('','$id_terakhir','$jenis_pakaian[$x]','$jumlah_pakaian[$x]')");
}
}
header("location:transaksi.php");
?>