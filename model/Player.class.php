<?php

/**
 * Bagian dari CovidAvoid: A Social Distancing Game
 * Dikembangkan oleh Fachri Veryawan Mahkota, 2020
 * 
 * Player.class.php
 * -> Kelas untuk mengakses tabel data pemain (cavoid).
 */

 
class Player extends DB {
    /* Ambil data pemain dari tabel */
        function fetchPlayer($playername = '') {

            if ($playername == '') {

                $query = "SELECT * FROM cavoid ORDER BY trip DESC";
            } else {

                $query = "SELECT * FROM cavoid WHERE player = $playername";
            }

            return $this->execute($query);
        }

    /* Memasukkan atau memperbarui data pemain pada tabel */
        function interactPlayer($playername = '', $trip = 0) {

            /**
             * REPLACE akan memasukkan record baru jika tidak ada data username sebelumnya, dan
             * memperbarui jika sudah ada.
             */
            $query = "REPLACE INTO cavoid(playername, trip) VALUES ('$playername', $trip)";
            $this->execute($query);
        }
}