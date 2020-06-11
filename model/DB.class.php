<?php

/**
 * Bagian dari CovidAvoid: A Social Distancing Game
 * Dikembangkan oleh Fachri Veryawan Mahkota, 2020
 * 
 * DB.class.php
 * -> Kelas untuk mengakses file database SQLite.
 */

 
class DB {
    /* Deklarasi variabel yang dibutuhkan */
        var $db_file    = ''; // Nama file (direktori) database SQLite
        var $db_conn    = ''; // Koneksi dengan database
        var $result     = 0;  // Hasil dari query

    /* Konstruktor */    
        function DB($db_file = '') {
            $this->db_file = $db_file;
        }

    /* Mulai koneksi dengan database */    
        function open() {
            $this->db_conn = new SQLite3($this->db_file); // Inisialisasi koneksi SQLite

            // Buat tabel jika sebelumnya file database belum ada (baru dibuat)
            $query = 'CREATE TABLE IF NOT EXISTS cavoid (
                        id INTEGER PRIMARY KEY,
                        playername TEXT UNIQUE,
                        trip INTEGER
                    )';
            $this->db_conn->exec($query);
        }

    /* Eksekusi query */
        function execute($query = '') {
            $this->result = $this->db_conn->query($query);
            return $this->result;
        }

    /* Ambil hasil eksekusi query */
        function fetchResult() {
            $res = array();
            while ($r = $this->result->fetchArray()) {
                array_push($res, $r);
            }

            return $res;
        }

    /* Akhiri koneksi dengan database */
        function close() {
            $this->db_conn->close();
        }
}