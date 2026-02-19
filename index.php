<?php
// File: tesnya.php

// 1. KONFIGURASI SESSION
ini_set('session.cookie_lifetime', 0);
ini_set('session.gc_maxlifetime', 1800);
session_start();

// 2. KONFIGURASI LOGIN
$valid_username = 'COBA';
$valid_password = 'COBA123';

// 3. PROSES LOGIN
if (isset($_POST['login'])) {
    // Ganti operator ?? dengan isset() untuk kompatibilitas PHP 5.x
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    } else {
        $login_error = "Username atau password salah! silahkan hubungi penyedia layanan";
    }
}

// 4. PROSES LOGOUT
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ".strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

// 5. CEK JIKA BELUM LOGIN, TAMPILKAN FORM LOGIN
if (!isset($_SESSION['loggedin'])) {
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rumah Anti Fraud</title>
    <link rel="icon" type="image/png" href="icon_buku_pensil.png">  
    <link rel="icon" type="image/png" href="https://img.icons8.com/?size=100&id=123742&format=png&color=000000">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- style untuk GIF bergerak 1 -->
    <style>    
        .floating-gif1 {
            position: fixed;
            width: 200px;
            height: 200px;
            cursor: grab;
            animation: float 3s ease-in-out infinite;
            user-select: none; /* agar teks tidak terseleksi saat drag */
            z-index: 10;
            transition: top 0.1s ease, left 0.1s ease; /* Tambahan: transisi halus saat pindah posisi */
        }
        .floating-gif1:active {
            cursor: grabbing;
            animation-play-state: paused; /* pause animasi saat drag */
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        .content {
            text-align: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 40px auto;
            position: relative;
            z-index: 1;
        }
    </style>
    
    <style>
        body {
            background: linear-gradient(to bottom, #f2edf7, #e7dff0, #cdb8e3); 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-title {
            color: #343a40;
            text-align: center;
            margin-bottom: 30px;
        }
        .login-title2 {
            color: orange;
            text-align: center;
            margin-bottom: 30px;
        }
        .error-message {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }
        .btn-primary {
            background: linear-gradient(135deg, #bf00ff 0%, #8a2be2 100%); /* Gradien untuk tampilan yang unik*/
            border: none;
            color: #ffffff; /* Teks putih untuk kontras */
            border-radius: 8px; /* Sudut membulat */
            padding: 12px 24px; /* Bantalan yang lebih besar untuk sentuhan yang lebih baik */
            font-size: 18px; /* Font lebih besar untuk visibilitas */
            font-weight: bold; /* Teks tebal */
            text-transform: uppercase; /* Huruf besar untuk penekanan */
            box-shadow: 0 4px 6px rgba(175, 0, 255, 0.3); /* Bayangan halus */
            transition: all 0.3s ease; /* Transisi halus untuk efek */
        }
    </style>
</head>
<body>

    <div class="floating-gif1" id="draggableGif" style="top: 100px; left: 100px;">
        <img src="https://i.imgur.com/mcWau0L.png" alt="GIF melayang" width="200" height="200" draggable="false" />
    </div>

    <div class="login-container">
        <h2 class="login-title">RUMAH ANTI FRAUD</h2>
        <h4 class="login-title2">Login diperlukan</h4>
        
        <?php if (isset($login_error)) { ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($login_error); ?></div>
        <?php } ?>
        
        <form method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>

            </div>
            <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
        </form>
    </div>

    <!-- script untuk GIF bergerak 1 (modifikasi dengan auto-move random) -->
    <script>
        const gif = document.getElementById('draggableGif');
        let isDragging = false;
        let offsetX, offsetY;
        let autoMoveInterval; // Variabel untuk interval auto-move
        const moveInterval = 2000; // 2 detik
        const gifWidth = 200;
        const gifHeight = 200;

        // Fungsi untuk pindah ke posisi random (hindari area tengah form login)
        function moveRandomly() {
            const maxLeft = window.innerWidth - gifWidth;
            const maxTop = window.innerHeight - gifHeight;

            // Generate random, tapi hindari area tengah (sekitar 40% dari center untuk safety)
            const avoidCenterX = window.innerWidth * 0.4; // Hindari tengah horizontal
            const avoidCenterY = window.innerHeight * 0.4; // Hindari tengah vertikal
            let newLeft = Math.random() * (maxLeft - avoidCenterX) + (Math.random() > 0.5 ? avoidCenterX : 0);
            let newTop = Math.random() * (maxTop - avoidCenterY) + (Math.random() > 0.5 ? avoidCenterY : 0);

            // Clamp agar tidak keluar layar
            newLeft = Math.max(0, Math.min(newLeft, maxLeft));
            newTop = Math.max(0, Math.min(newTop, maxTop));

            gif.style.left = newLeft + 'px';
            gif.style.top = newTop + 'px';
        }

        // Mulai auto-move setelah halaman load
        function startAutoMove() {
            if (autoMoveInterval) clearInterval(autoMoveInterval); // Clear jika sudah ada
            autoMoveInterval = setInterval(moveRandomly, moveInterval);
        }

        // Pause auto-move
        function pauseAutoMove() {
            if (autoMoveInterval) {
                clearInterval(autoMoveInterval);
                autoMoveInterval = null;
            }
        }

        // Event drag (modifikasi dari yang lama)
        gif.addEventListener('mousedown', (e) => {
            isDragging = true;
            offsetX = e.clientX - gif.offsetLeft;
            offsetY = e.clientY - gif.offsetTop;
            gif.style.animationPlayState = 'paused';
            gif.style.cursor = 'grabbing';
            pauseAutoMove(); // Pause auto-move saat drag
        });

        document.addEventListener('mouseup', () => {
            if (isDragging) {
                isDragging = false;
                gif.style.animationPlayState = 'running';
                gif.style.cursor = 'grab';
                startAutoMove(); // Resume auto-move setelah drag selesai
            }
        });

        document.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            let newLeft = e.clientX - offsetX;
            let newTop = e.clientY - offsetY;

            const maxLeft = window.innerWidth - gifWidth;
            const maxTop = window.innerHeight - gifHeight;

            if (newLeft < 0) newLeft = 0;
            if (newTop < 0) newTop = 0;
            if (newLeft > maxLeft) newLeft = maxLeft;
            if (newTop > maxTop) newTop = maxTop;

            gif.style.left = newLeft + 'px';
            gif.style.top = newTop + 'px';
        });

        // Mencegah drag image default
        gif.querySelector('img').addEventListener('dragstart', e => e.preventDefault());

        // Handle window resize (reset posisi jika perlu)
        window.addEventListener('resize', () => {
            // Opsional: Pindah random ulang saat resize
            moveRandomly();
        });

        // Inisialisasi: Mulai auto-move setelah DOM load
        document.addEventListener('DOMContentLoaded', () => {
            startAutoMove();
        });
    </script>

</body>
</html>
    <?php
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Rumah Anti Fraud</title>
			<link rel="icon" type="image/png" href="icon_buku_pensil.png">  
			<link rel="icon" type="image/png" href="https://img.icons8.com/?size=100&id=123742&format=png&color=000000">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
	<!-- style untuk body -->
	<style>
        body {
            background-color: #f2edf7;
            padding-top: 60px;
        }
        .logout-btn {
            position: fixed;
            top: 15px;
            right: 15px;
            z-index: 1000;
        }
        .welcome-message {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1000;
            font-weight: bold;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .table-header {
            background-color: #a35437;
            color: white;
            position: sticky;
            top: 0;
        }
        .even-row {
            background-color: #F5f5dc;
        }
        .odd-row {
            background-color: #ffebcd;
        }
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
    </style>
	
	<!-- style untuk tombol download -->
	<style>
	.download-button-blue {
        background-color: #bf00ff; /* Warna latar belakang */
        border: none; /* Menghilangkan border */
        color: white; /* Warna teks */
        padding: 10px 15px; /* Padding atas/bawah dan kiri/kanan */
        text-align: center; /* Menyelaraskan teks di tengah */
        text-decoration: none; /* Menghilangkan garis bawah */
        display: inline-block; /* Membuat tombol inline */
        font-size: 18px; /* Ukuran font */
        margin: 4px 2px; /* Margin */
        cursor: pointer; /* Menunjukkan kursor pointer saat hover */
        border-radius: 8px; /* Sudut membulat */
        transition: background-color 0.3s; /* Transisi halus untuk hover */
    }
	.download-button-blue:hover {
        background-color: #a011d1; /* Warna latar belakang saat hover */
		color: white; /* Warna teks */
		transform: scale(1.35); /* Membesarkan tombol sedikit saat hover */
		box-shadow: 0 8px 10px rgba(0, 0, 0, 0.3); /* Menambahkan bayangan saat hover */
    }
	
    .download-button {
        background-color: #4CAF50; /* Warna latar belakang */
        border: none; /* Menghilangkan border */
        color: white; /* Warna teks */
        padding: 10px 15px; /* Padding atas/bawah dan kiri/kanan */
        text-align: center; /* Menyelaraskan teks di tengah */
        text-decoration: none; /* Menghilangkan garis bawah */
        display: inline-block; /* Membuat tombol inline */
        font-size: 16px; /* Ukuran font */
        margin: 4px 2px; /* Margin */
        cursor: pointer; /* Menunjukkan kursor pointer saat hover */
        border-radius: 8px; /* Sudut membulat */
        transition: background-color 0.3s; /* Transisi halus untuk hover */
    }

    .download-button:hover {
        background-color: #45a049; /* Warna latar belakang saat hover */
		transform: scale(1.35); /* Membesarkan tombol sedikit saat hover */
		box-shadow: 0 8px 10px rgba(0, 0, 0, 0.3); /* Menambahkan bayangan saat hover */
    }
	</style>
	
	<!-- style untuk PASARAN -->
	<style>

        @font-face {
            font-family: 'DigitalFont';
            src: url('font/DS-DIGIT.ttf') format('woff2'),
                 url('font/DS-DIGIT.woff') format('woff');
            font-weight: normal;
            font-style: normal;
        }
		@font-face {
            font-family: 'CustomFont';
            src: url('font/DS-DIGIT.ttf') format('truetype'),
                 url('font/awesome_java.woff') format('woff');
            font-weight: normal;
            font-style: normal;
        }
        #clockContainer {
            display: flex;
            align-items: baseline; /* Sejajarkan berdasarkan baseline */
            gap: 20px; /* Jarak antara nama hari dan jam */
        }
		
		#dayName {
            font-family: DigitalFont, sans-serif;
            font-size: 1.5cm;
            color: #4CAF50; /* Warna teks putih */
			text-shadow: 0 0 10px #0f0, 0 0 20px #0f0; /* Efek cahaya LED */
			padding-bottom: 0.2rem; /* Sesuaikan jika diperlukan */
        }
		
		 #pasaran {
            font-family: CustomFont, sans-serif;
            font-size: 1cm;
            color: #BF00FF; /* Warna teks putih */
			text-shadow: 0 0 10px #8A2BE2, 0 0 20px #8A2BE2; /* Efek cahaya LED */
            padding-bottom: 0.2rem; /* Sesuaikan jika diperlukan */
        }
		
		#date {
            font-family: DigitalFont, sans-serif;
            font-size: 1.5cm;
            color: #4CAF50; /* Warna teks putih */
			text-shadow: 0 0 10px #0f0, 0 0 20px #0f0; /* Efek cahaya LED */
            padding-bottom: 0.2rem; /* Sesuaikan jika diperlukan */
        }
		
		#digitalClock {
			font-family: 'DigitalFont', sans-serif; /* Gunakan font Digital-7 */
            font-size: 1.5cm; /* Ukuran font untuk jam */
            font-weight: bold;
            color: #4CAF50;
			text-shadow: 0 0 10px #0f0, 0 0 20px #0f0; /* Efek cahaya LED */
            line-height: 1; /* Pastikan line-height konsisten */
            margin-top: 20px;
        }
		
	</style>

	<!-- style untuk GIF bergerak -->
	<style>	
		.floating-gif {
		  position: fixed;
		  width: 200px;
		  height: 200px;
		  cursor: grab;
		  animation: float 3s ease-in-out infinite;
		  user-select: none; /* agar teks tidak terseleksi saat drag */
		  z-index: 10;
		}
		.floating-gif:active {
		  cursor: grabbing;
		  animation-play-state: paused; /* pause animasi saat drag */
		}
		@keyframes float {
		  0%, 100% { transform: translateY(0); }
		  50% { transform: translateY(-20px); }
		}
		.content {
		  text-align: center;
		  padding: 20px;
		  background: rgba(255, 255, 255, 0.9);
		  border-radius: 10px;
		  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
		  max-width: 600px;
		  margin: 40px auto;
		  position: relative;
		  z-index: 1;
		}
    </style>
	
	<!-- script untuk PASARAN-->
	    <script>
        // Daftar nama hari dalam bahasa Indonesia
        const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
		
		// Daftar pasaran Jawa
        const pasaran = ["Legi -", "Pahing -", "Pon -", "Wage -", "Kliwon -"];
		
		// Daftar nama bulan dalam bahasa Indonesia
        const months = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];
		
		
		// Tanggal acuan: 1 Januari 2025 adalah "Rabu Pon"
        const referenceDate = new Date(2025, 0, 1); // 1 Januari 2025
        const referencePasaranIndex = 2; // Pon

        // Fungsi untuk menghitung pasaran Jawa
        function getPasaran(date) {
            // Hitung selisih hari antara tanggal acuan dan tanggal yang diberikan
            const timeDiff = date - referenceDate;
            const daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));

            // Debugging: Tampilkan selisih hari
            console.log("Selisih Hari:", daysDiff);

            // Hitung indeks pasaran Jawa
            const pasaranIndex = (referencePasaranIndex + daysDiff) % 5;

            // Debugging: Tampilkan indeks pasaran
            console.log("Indeks Pasaran:", pasaranIndex);

            // Pastikan indeks pasaran selalu positif
            return pasaran[pasaranIndex >= 0 ? pasaranIndex : pasaranIndex + 5];
        }
		
        function updateClock() {
            const now = new Date();
            const day = days[now.getDay()]; // Ambil nama hari
            const pasaranJawa = getPasaran(now); // Ambil pasaran Jawa
            const date = now.getDate(); // Ambil tanggal (1-31)
            const month = months[now.getMonth()]; // Ambil nama bulan
            const year = now.getFullYear(); // Ambil tahun
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            // Update nama hari dan jam
            document.getElementById('dayName').textContent = day;
			document.getElementById('pasaran').textContent = pasaranJawa;
			document.getElementById('date').textContent = `${date} ${month} ${year}`;
            document.getElementById('digitalClock').textContent = `${hours}:${minutes}:${seconds}`;
        }

        setInterval(updateClock, 1000);
        updateClock(); // Panggil fungsi sekali untuk menginisialisasi jam
    </script>
	
	
	<!-- script untuk pilihan file yang akan di download-->
	<script>
    function downloadFile_sudahso() {
      var select = document.getElementById("fileSelect_sudahso");
      var fileName = select.value;
      if (fileName) {
        window.location.href = "http://192.168.18.66/so/2409/" + fileName;
      } else {
        alert("Silakan pilih file untuk diunduh.");
      }
    }
	</script>
	<script>
    function downloadFile_rkas() {
      var select = document.getElementById("fileSelect_rkas");
      var fileName = select.value;
      if (fileName) {
        window.location.href = "http://192.168.18.66/so/2409/" + fileName;
      } else {
        alert("Silakan pilih file untuk diunduh.");
      }
    }
	</script>
	
	
	<!-- script untuk logout otomatis-->
    <script>
	document.addEventListener('DOMContentLoaded', function() {
    // Flag untuk menandai apakah form sedang disubmit
    var isSubmitting = false;
    
    // Deteksi ketika form disubmit
    document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('submit', function() {
            isSubmitting = true;
        });
    });
    
    // Deteksi ketika link diklik (untuk logout)
    document.querySelectorAll('a[href]').forEach(function(link) {
        link.addEventListener('click', function() {
            if (this.getAttribute('href').includes('logout')) {
                isSubmitting = true;
            }
        });
    });
    
    // Handler untuk beforeunload
    window.addEventListener('beforeunload', function(e) {
        if (!isSubmitting) {
            // Kirim permintaan logout menggunakan sendBeacon
            navigator.sendBeacon('?logout=1');
        }
    });
	});
	</script>
	
</head>

<body>
    <div class="welcome-message">Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?></div>
    <a href="?logout=1" class="btn btn-danger logout-btn">Logout</a>
	
	<div class="floating-gif" id="draggableGif" style="top: 100px; right: 100px;">
    <img src="https://i.imgur.com/mcWau0L.png" alt="GIF melayang" width="200" height="200" draggable="false" />
	</div>
	
	
	    <div id="clockContainer">
        <div id="dayName">Hari</div>
		<div id="pasaran">Pasaran</div>
		<div id="date">Tanggal</div>
        <div id="digitalClock">00:00:00</div>
		</div>
	
<div class="motivational-frame">
    <div class="frame-content">
        <div class="left-section">
            <p class="quote1">"Doa Mohon Kelapangan dan Kelancaran"</p>  
            <p class="quote2">"رَبِّ اشْرَحْ لِيْ صَدْرِيْۙ وَيَسِّرْ لِيْٓ اَمْرِيْۙ وَاحْلُلْ عُقْدَةً مِّنْ لِّسَانِيْ"</p>
        </div>
        <div class="right-section">
            <p class="quote3">"rabbisyraḫ lî shadrî, wa yassir lî amrî, waḫlul ‘uqdatam mil lisânî"</p>
            <p class="quote">"Ya Tuhanku, lapangkanlah dadaku, dan mudahkanlah untukku urusanku, dan lepaskanlah kekakuan dari lidahku. (QS Taha: 25-27)..."</p>
            <p class="author">Sumber: quran.nu.or.id/doa</p>
        </div>
    </div>
</div>

<style>
.motivational-frame {
    background-color: #f5e3fa;
    border: 2px solid #e0e0e0;
    border-left: 5px solid #e57df5;
	border-right: 5px solid #e57df5;
    padding: 20px;
    margin: 20px auto;
    border-radius: 5px;
    font-family: 'Georgia', serif;
    box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
    
    /* Ukuran landscape */
    width: 80%;
    max-width: 900px;
    min-width: 600px;
}

.frame-content {
    display: grid;
    grid-template-columns: 1fr 1fr; /* Dua kolom sama lebar */
    gap: 30px; /* Jarak antara kiri dan kanan */
    align-items: start;
}

.left-section {
    text-align: center;
    border-right: 1px dashed #ccc;
    padding-right: 20px;
}

.right-section {
    text-align: left;
}

.quote1 {
    font-size: 1.5em;
    line-height: 1.3;
    color: #2c3e50;
    margin-bottom: 20px;
    font-weight: bold;
}

.quote2 {
    font-size: 2.5em;
    line-height: 1.3;
    color: #2e7d32;
    font-family: 'Traditional Arabic', 'Scheherazade New', serif;
    direction: rtl;
	font-weight: bold;
}

.quote3 {
    font-size: 1.1em;
    line-height: 1.5;
    color: #2e7d32;
    margin-bottom: 15px;
    font-style: italic;
}

.quote {
    font-size: 1.1em;
    line-height: 1.5;
    color: #333;
    margin-bottom: 15px;
    font-style: italic;
}

.author {
    text-align: right;
    font-size: 0.9em;
    color: #666;
    font-style: normal;
    font-weight: bold;
    margin-top: 15px;
}

/* Responsive untuk tablet */
@media (max-width: 768px) {
    .motivational-frame {
        width: 95%;
        min-width: unset;
    }
    
    .frame-content {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .left-section {
        border-right: none;
        border-bottom: 1px dashed #ccc;
        padding-right: 0;
        padding-bottom: 20px;
    }
}
</style>
	
	<P> <blink>Status SO toko (Q - M) periode Januari 2025 s.d Maret 2025 (Kuartal I 2025)</blink>
	<blink><a href="so/2409/TOKO Q M 2501.xls" style="text-decoration: none; font-weight: bold; transition: font-size 0.2s ease-in-out; title="Ambil_file" target="_blank">Disini</a></blink> </p>

	<P> <blink>Status SO toko (Q - M) periode April 2025 s.d Juni 2025 (Kuartal II 2025)</blink>
	<blink><a href="so/2409/TOKO Q M 2504.xls" style="text-decoration: none; font-weight: bold; transition: font-size 0.2s ease-in-out; title="Ambil_file" target="_blank">Disini</a></blink> </p>

	<P> <blink>Status SO toko (Q - M) periode Juli 2025 s.d September 2025 (Kuartal III 2025)</blink>
	<a href="so/2409/TOKO Q M 2507.xls" class="download-button-blue" target="_blank">Di sini</a>

	<P> <blink>Status SO toko (Q - M) periode Oktober 2025 s.d Desember 2025 (Kuartal IV 2025)</blink>
	<a href="so/2409/TOKO Q M 2510.xls" class="download-button-blue" target="_blank">Di sini</a>
	
	<P> <blink>Status SO toko (Q - M) periode Januari 2026 s.d Maret 2026 (Kuartal I 2026)</blink>
	<a href="so/2409/TOKO Q M 2601.xls" class="download-button-blue" target="_blank">Di sini</a>
	
	<p class="style2" style="font-family: 'Roboto', Estrangelo Edessa;font-size: 24px;
color: #000000; class="style2">Download toko-2 yg sudah di SO,DISINI !! <a href="SO/2409/cek scan per jam 2410.xls"><img name="imageField" type="image" id="imageField" value="imageField" border=0 src="down.png"></a></p>
<select id="fileSelect_sudahso">
    <option value="">--Pilih File--</option>
	<option value="cek scan per jam 2602.xls">sudah So 2602</option>
	<option value="cek scan per jam 2601.xls">sudah So 2601</option>
	<option value="cek scan per jam 2512.xls">sudah So 2512</option>
	<option value="cek scan per jam 2511.xls">sudah So 2511</option>
	<option value="cek scan per jam 2510.xls">sudah So 2510</option>
	<option value="cek scan per jam 2509.xls">sudah So 2509</option>
	<option value="cek scan per jam 2508.xls">sudah So 2508</option>
	<option value="cek scan per jam 2507.xls">sudah So 2507</option>
	<option value="cek scan per jam 2506.xls">sudah So 2506</option>
	<option value="cek scan per jam 2505.xls">sudah So 2505</option>
	<option value="cek scan per jam 2504.xls">sudah So 2504</option>
	<option value="cek scan per jam 2503.xls">sudah So 2503</option>
	<option value="cek scan per jam 2502.xls">sudah So 2502</option>
	<option value="cek scan per jam 2501.xls">sudah So 2501</option>
    <!-- Tambahkan lebih banyak pilihan sesuai kebutuhan -->
  </select>
  <button class="download-button" onclick="downloadFile_sudahso()"><i class="fas fa-download"></i> Download File</button>

<p class="style2" style="font-family: 'Roboto', Estrangelo Edessa;font-size: 24px; class="style2">Download Rekap Kas,DISINI !!  <a href="SO/2409/REKAP KAS 2410.XLS"> <img name="imageField" type="image" id="imageField" value="imageField" border=0 src="down.png"></a></p>
<select id="fileSelect_rkas">
    <option value="">--Pilih File--</option>
	<option value="REKAP KAS 2602.xls">RKAS 2602</option>
	<option value="REKAP KAS 2601.xls">RKAS 2601</option>
	<option value="REKAP KAS 2512.xls">RKAS 2512</option>
	<option value="REKAP KAS 2511.xls">RKAS 2511</option>
	<option value="REKAP KAS 2510.xls">RKAS 2510</option>
	<option value="REKAP KAS 2509.xls">RKAS 2509</option>
	<option value="REKAP KAS 2508.xls">RKAS 2508</option>
	<option value="REKAP KAS 2507.xls">RKAS 2507</option>
	<option value="REKAP KAS 2506.xls">RKAS 2506</option>
	<option value="REKAP KAS 2505.xls">RKAS 2505</option>
	<option value="REKAP KAS 2504.xls">RKAS 2504</option>
	<option value="REKAP KAS 2503.xls">RKAS 2503</option>
	<option value="REKAP KAS 2502.xls">RKAS 2502</option>
	<option value="REKAP KAS 2501.xls">RKAS 2501</option>
    <!-- Tambahkan lebih banyak pilihan sesuai kebutuhan -->
  </select>
  <button class="download-button" onclick="downloadFile_rkas()">Download File</button>
	
	<!-- script untuk GIF bergerak-->
		<script>
		const gif = document.getElementById('draggableGif');
		let isDragging = false;
		let offsetX, offsetY;

		gif.addEventListener('mousedown', (e) => {
		  isDragging = true;
		  // Hitung offset posisi mouse terhadap posisi elemen
		  offsetX = e.clientX - gif.offsetLeft;
		  offsetY = e.clientY - gif.offsetTop;
		  // Hentikan animasi saat drag
		  gif.style.animationPlayState = 'paused';
		  gif.style.cursor = 'grabbing';
		});

		document.addEventListener('mouseup', () => {
		  if (isDragging) {
			isDragging = false;
			// Lanjutkan animasi saat drag selesai
			gif.style.animationPlayState = 'running';
			gif.style.cursor = 'grab';
		  }
		});

		document.addEventListener('mousemove', (e) => {
		  if (!isDragging) return;
		  // Hitung posisi baru elemen berdasarkan posisi mouse dan offset
		  let newLeft = e.clientX - offsetX;
		  let newTop = e.clientY - offsetY;

		  // Batasi agar GIF tidak keluar dari viewport
		  const maxLeft = window.innerWidth - gif.offsetWidth;
		  const maxTop = window.innerHeight - gif.offsetHeight;

		  if (newLeft < 0) newLeft = 0;
		  if (newTop < 0) newTop = 0;
		  if (newLeft > maxLeft) newLeft = maxLeft;
		  if (newTop > maxTop) newTop = maxTop;

		  gif.style.left = newLeft + 'px';
		  gif.style.top = newTop + 'px';
		});

		// Mencegah drag image default (gambar ikut ter-drag)
		gif.querySelector('img').addEventListener('dragstart', e => e.preventDefault());
	  </script>
	
</body>
</html>
