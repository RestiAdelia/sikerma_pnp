<?php
$koneksi = mysqli_connect("localhost", "root", "", "db_pbl",3307);

if (!$koneksi) {
    die("Connection failed: " . mysqli_connect_error());
}
?>