/**
 * Bagian dari CovidAvoid: A Social Distancing Game
 * Dikembangkan oleh Fachri Veryawan Mahkota, 2020
 *
 * cavoid.js
 * -> Script game utama dari CovidAvoid.
 */


/* Variabel-variabel yang dibutuhkan oleh script */
    var kotakKu; // Karakter dari pemain
    var kotakBatur = []; // Karakter rintangan/lawan
    var trip; // Penampung skor pemain
    var intvl = 20; // Interval update game area (kecepatan game)
    var stop = 0; // Penanda game berhenti
    var bgm; // Background music

/* Mulai game */
    function startGame() {

        kotakKu = new component(10, 10, "red", 10, 120); // Komponen baru karakter pemain
        trip = new component("15px", "Trebuchet MS", "white", 670, 250, "text"); // Komponen baru teks skor
        
        bgm = new Audio("../assets/audio/bgm.mp3"); // Inisialisasi background music
        bgm.loop = true; // Musik di loop
        bgm.play(); // Mulai mainkan musik

        myGameArea.start(); // Jalankan game
    }

/* Variabel buat canvas */
    var myGameArea = {
        
    /* Buat canvas baru */
        canvas: document.createElement("canvas"),

    /* Fungsi untuk membuat tampilan awal */
        start: function () {

            this.canvas.width = 960; // Lebar canvas
            this.canvas.height = 270; // Tinggi canvas
            this.context = this.canvas.getContext("2d"); // Buat canvas

            this.frameNo = -900; // Frame number mulai dari negatif karena rintangan masih jauh
            this.interval = setInterval(updateGameArea, intvl); // Set kecepatan game (interval)

            /* Buat event listener untuk kontrol keyboard */
            window.addEventListener('keydown', function (e) {
                myGameArea.keys = (myGameArea.keys || []);
                myGameArea.keys[e.keyCode] = (e.type == "keydown");
            })
            window.addEventListener('keyup', function (e) {
                myGameArea.keys[e.keyCode] = (e.type == "keydown");
            })

            /* Penempatan canvas */
            div = document.getElementById("here"); // Ambil div di html dengan id "here"
            div.appendChild(this.canvas); // Taruh canvas di dalam div tersebut
        },

    /* Hapus objek di canvas */
        clear: function () {
            this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
        }
    }

/* Fungsi untuk membuat komponen */
    function component(width, height, color, x, y, type) {

        this.type = type; // Tipe komponen
        this.score = 0;
        this.width = width; // Lebar komponen
        this.height = height; // Tinggi komponen
        this.speedX = 0; // Kecepatan komponen di sumbu x
        this.speedY = 0; // Kecepatan komponen di sumbu y
        this.x = x; // Posisi awal komponen di sumbu x
        this.y = y; // Posisi awal komponen di sumbu y

    /* Update game per frame */
        this.update = function () {

            ctx = myGameArea.context;
            if (this.type == "text") {

                ctx.font = this.width + " " + this.height;
                ctx.fillStyle = color;
                ctx.fillText(this.text, this.x, this.y);
            } else {
                
                ctx.fillStyle = color;
                ctx.fillRect(this.x, this.y, this.width, this.height);
            }
        }

    /* Uoodate posisi komponen */
        this.newPos = function () {

            this.x += this.speedX;
            this.y += this.speedY;
            this.hitBottom();
        }

    /* Cek apakah kompoenen menyentuh dasar canvas */
        this.hitBottom = function () {

            var rockbottom = myGameArea.canvas.height - this.height;
            if (this.y > rockbottom) {
                this.y = rockbottom;
            }
        }

    /* Cek apakah komponen bertabrakan dengan komponen lain */
        this.crashWith = function (otherobj) {

            var myleft = this.x;
            var myright = this.x + (this.width);
            var mytop = this.y;
            var mybottom = this.y + (this.height);
            var otherleft = otherobj.x;
            var otherright = otherobj.x + (otherobj.width);
            var othertop = otherobj.y;
            var otherbottom = otherobj.y + (otherobj.height);
            var crash = true;

            /* Jika player tidak menabrak rintangan */
            if ((mybottom < othertop) || (mytop > otherbottom) || (myright < otherleft) || (myleft >
                otherright)) {
                crash = false;
            }

            return crash;
        }
    }

/* Perbarui area game */
    function updateGameArea() {

        /* Jika variabel stop masih 0 (belum menabrak rintangan) */
        if (stop == 0) {

            for (i = 0; i < kotakBatur.length && stop == 0; i += 1) {

                /* Cek apakah player bertabrakan dengan rintangan */
                if (kotakKu.crashWith(kotakBatur[i])) {

                    alert("Game over! Your trip in this game is "+myGameArea.frameNo+"."); // Buat dialog di browser
                    stop = 1; // Tandai variabel game sudah berakhir
                    location.replace("../controller/update.php?trip=" + myGameArea.frameNo); // Arahkan ke controller update
                }
            }

            myGameArea.clear(); // Hapus game area yang sedang ditampilkan
            myGameArea.frameNo += 1; // Tambah satu frame baru

            /* Buat rintangan dengan interval random diantara 10 sampai 20 */
            if (myGameArea.frameNo == 1 || everyinterval(Math.floor(Math.random() * 20) + 10)) {

                /* Random warna rintangan */
                color = "";
                rand = Math.floor(Math.random() * 3) + 1;
                if (rand == 1) {
                    color = "green";
                } else if (rand == 2) {
                    color = "blue";
                } else {
                    color = "yellow";
                }

                /* Masukkan rintangan baru ke dalam canvas */
                kotakBatur.push(new component(10, 10, color, myGameArea.canvas.width,
                    Math.floor(Math.random() * 260)));
            }

            /* Gerakkan rintangan ke kiri */
            for (i = 0; i < kotakBatur.length; i += 1) {

                kotakBatur[i].x += -1;
                kotakBatur[i].update();
            }

            /* Tampilan skor/peran untuk player */
            if (myGameArea.frameNo >= -900 && myGameArea.frameNo < -600) { // Jika frame pada range ini, tampilkan nama game

                trip.text = "CovidAvoid: A Social Distancing Game";
            }
            else if (myGameArea.frameNo >= -600 && myGameArea.frameNo < -300) { // Jika frame pada range ini, tampilkan pesan untuk player

                trip.text = "Keep your distance to win the game!";
            }
            else if (myGameArea.frameNo >= -300 && myGameArea.frameNo < 0) { // Jika frame pada range ini, beri tahu player untuk bersiap

                trip.text = "Get ready...";
            }
            else { // Jika skor sudah lebih dari 0, tampilkan skor player saat ini
                trip.text = "TRIP: " + myGameArea.frameNo;
            }
            trip.update(); // Update tampilan skor

            /* Kontrol karakter pemain dengan keyboard */
            if (myGameArea.keys && myGameArea.keys[38]) {
                if (kotakKu.y > 0) {
                    kotakKu.y -= 2;
                }
            }
            if (myGameArea.keys && myGameArea.keys[40]) {
                kotakKu.y += 2;
            }

            kotakKu.newPos(); // Perbarui posisi
            kotakKu.update(); // Update posisi pada canvas

            /* Kurangi interval satu frame setiap kelipatan skor 2000, 4000, 8000. 16000 dst */
            if (myGameArea.frameNo > 0) {
                if (myGameArea.frameNo % (Math.pow(2, (20 - intvl)) * 2000) == 0) {
                    intvl -= 1;
                    myGameArea.interval = setInterval(updateGameArea, intvl);
                }
            }
        }
    }

    function everyinterval(n) {
        if ((myGameArea.frameNo / n) % 1 == 0) {
            return true;
        }
        return false;
    }