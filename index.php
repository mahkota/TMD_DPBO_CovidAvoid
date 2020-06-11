<?php

/**
 * Bagian dari CovidAvoid: A Social Distancing Game
 * Dikembangkan oleh Fachri Veryawan Mahkota, 2020
 * 
 * index.php
 * -> Halaman utama dari CovidAvoid.
 */

 
/* Include file-file kelas template */
    include("./model/DB.class.php");
    include("./model/Player.class.php");
    include("./model/View.class.php");

/* Inisialisasi database pemain untuk membaca daftar skor */
    $player = new Player("./TMD.db"); // File database SQLite dibuka
    $player->open(); // Buka akses database
    $dbdata = null;

/* Membuka template page utama */    
    $hof = new View("view/hall_of_fame.html");

$player->fetchPlayer();

/* Mengambil data daftar skor dari database */
    $rank = 1; // Variabel untuk menunjukkan peringkat pemain
    foreach($player->fetchResult() as $r) {
        $dbdata .= '<tr>
                        <td>'.$rank.'</td>
                        <td>'.$r['playername'].'</td>
                        <td>'.$r['trip'].'</td>
                    </tr>';
        $rank++;
    }

/* Tutup akses database */
    $player->close();

/* Ganti DATA_TBL dengan data tabel yang sudah diambil pada template dan tampilkan ke layar */
    $hof->replace("DATA_TBL", $dbdata);
    $hof->write();