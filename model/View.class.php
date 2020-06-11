<?php

/**
 * Bagian dari CovidAvoid: A Social Distancing Game
 * Dikembangkan oleh Fachri Veryawan Mahkota, 2020
 * 
 * DB.class.php
 * -> Kelas untuk membaca dan merombak file html tampilan.
 */

 
class View {

        var $filename   = ''; // Handle file
        var $content    = ''; // Handle isi file

    /* Konstruktor */
        function View($filename='') {

            $this->filename = $filename;

            /* Baca file html tampilan */
            $this->content = implode('', @file($filename));
        }

    /* Membersihkan DATA_... pada file */
        function clear() {

            $this->content = preg_replace("/DATA_[A-Z]_[0-9]+/", "", $this->content);
        }

    /* Menuliskan isi file tampilan pada layar */
        function write() {

            // Menghapus DATA_... yang belum diganti
            $this->clear();

            // Tampilkan hasil perubahan di layar
            print $this->content;
        }

    /* Ambil isi file tampilan yang sudah diproses */
        function getContent() {

            // Menghapus DATA_... yang belum diganti
            $this->clear();

            // Lempar isi tampilan pada pemanggil fungsi
            return $this->content;
        }

    /* Menggantikan DATA_... dengan penggantinya */
        function replace($old='', $new='') {

            /* Jika pengganti merupakan bilangan bulat */
            if (is_int($new)) {

                $value = sprintf("%d", $new);
            }
           /* Jika pengganti merupakan bilangan riil */
            else if (is_float($new)) {

                $value = sprintf("%f", $new);
            }
            /* Jika pengganti merupakan larik */
            else if (is_array($new)) {

                $value = '';

                foreach ($new as $item) {
                    $value .= $item.' ';
                }
            }
            /* Jika tidak termasuk ketiga tipe di atas, langsung digantikan tanpa dimodifikasi */
            else {

                $value = $new;
            }

            /* Mengganti DATA_... dengan penggantinya */
            $this->content = preg_replace("~$old~", $value, $this->content);
        }

}