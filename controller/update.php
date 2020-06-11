<?php

/**
 * Bagian dari CovidAvoid: A Social Distancing Game
 * Dikembangkan oleh Fachri Veryawan Mahkota, 2020
 * 
 * update.php
 * -> Controller untuk memasukkan data pemain setelah permainan berakhir.
 */


/* Jalankan session untuk membaca data */
session_start();

/* Jika session memiliki data di dalamnya */
if(isset($_SESSION['playerName'])) {

    /* Include file-file kelas template */
        include("../model/DB.class.php");
        include("../model/Player.class.php");
        include("../model/View.class.php");

    /* Inisialisasi database dan update data */
        $player = new Player("../TMD.db"); // File database SQLite dibuka
        $player->open(); // Buka akses database
        $player->interactPlayer($_SESSION['playerName'], $_GET['trip']); // Update skor baru pada username
        $player->close(); // Tutup akses database
    }

session_destroy(); // Hancurkan session
header("Location: ../index.php"); // Kembali ke halaman awal