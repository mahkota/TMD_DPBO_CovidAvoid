<?php

/**
 * Bagian dari CovidAvoid: A Social Distancing Game
 * Dikembangkan oleh Fachri Veryawan Mahkota, 2020
 * 
 * play.php
 * -> Controller untuk memulai permainan.
 */


/**
 * Jika ada data POST dari form maka controller akan menjalankan perintah.
 * Jika tidak, controller akan mengembalikan user ke halaman utama (index.php)
 */
if ($_POST['playerName'] != '') {

    /* Jalankan session untuk menyimpan data */
        session_start();

    /* Include file-file kelas template */
        include("../model/DB.class.php");
        include("../model/Player.class.php");
        include("../model/View.class.php");

    /* Inisialisasi database pemain untuk membuat pemain baru */
        $player = new Player("../TMD.db"); // File database SQLite dibuka
        $player->open(); // Buka akses database
        $_SESSION['playerName'] = $_POST['playerName']; // Masukkan nama player dari POST ke dalam session
        $player->interactPlayer($_POST['playerName']); // INSERT/UPDATE (REPLACE) data nama player ke dalam DB
        $player->close(); //Tutup akses database

    /* Membuka template page game */
        $game = new View("../view/game.html");
        // $game->replace("PLAYERNAME", $_SESSION['playerName']);
        $game->write();
} else {
    
    header("Location: ../index.php"); // Arahkan user ke halaman utama
}