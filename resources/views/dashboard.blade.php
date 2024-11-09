<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penampungan Sampah</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
    /* Styling umum dan sidebar */
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    .container {
        height: 400px;
        width: 400px;
        background-color: #ffffff;
        position: absolute;
        transform: translate(-50%, -50%);
        top: 50%;
        left: 50%;
        border-radius: 8px;
        box-shadow: 20px 20px 40px rgba(60, 60, 150, 0.25);
        display: grid;
        place-items: center;
    }

    .circular-progress {
        position: relative;
        height: 250px;
        width: 250px;
        border-radius: 50%;
        display: grid;
        place-items: center;
    }

    .circular-progress:before {
        content: "";
        position: absolute;
        height: 84%;
        width: 84%;
        background-color: #ffffff;
        border-radius: 50%;
    }

    .value-container {
        position: relative;
        font-family: "Poppins", sans-serif;
        font-size: 50px;
        color: #231c3d;
    }

    .sb-sidenav {
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        height: 100%;
        background-color: #343a40;
        padding: 1rem;
        color: #fff;
        display: block;
        transition: transform 0.3s ease;
        transform: translateX(-250px);
    }

    .sb-sidenav.open {
        transform: translateX(0);
    }

    .sb-sidenav a {
        color: #fff;
        text-decoration: none;
        display: flex;
        align-items: center;
        padding: 0.5rem 0.5rem;
    }

    .sb-sidenav a:hover {
        background-color: #495057;
    }

    .sb-main {
        margin-left: 250px;
        padding: 2rem;
        flex: 2;
    }

    .navbar {
        background-color: #343a40;
    }

    .navbar .navbar-brand,
    .navbar .nav-link {
        color: #fff;
    }

    .navbar .nav-link:hover {
        color: #adb5bd;
    }

    .circular-progress-container {
    display: flex; /* Menggunakan flexbox untuk pengaturan yang lebih baik */
    justify-content: center; /* Mengatur konten di tengah secara horizontal */
    align-items: center; /* Mengatur konten di tengah secara vertikal */
    margin-left: 10px;
    margin-right: 10px;
}

    /* Sidebar untuk perangkat desktop */
    @media (min-width: 1024px) {
        .sb-sidenav {
            transform: translateX(0);
        }

        .sb-main {
            margin-left: 250px;
        }
    }

    /* Sidebar untuk perangkat kecil (mobile dan tablet) */
    @media (max-width: 768px) {
        .sb-sidenav {
            transform: translateX(-250px);
            transition: transform 0.3s ease-in-out;
        }

        .sb-sidenav.open {
            transform: translateX(0);
        }

        .sb-main {
            margin-left: 0;
        }

        .navbar-toggler {
            display: block;
            background: transparent;
            color: white;
            font-size: 30px;
            cursor: pointer;
        }

        .circular-progress-container {
            flex-direction: column;
            align-items: center;
            margin-top: 10px;
            /* Mengurangi margin atas untuk perangkat kecil */
            margin-left: 0;
            /* Menghapus margin kiri pada perangkat kecil */
            margin-right: 0;
        }
    }

    .navbar-toggler {
        border: none;
        background: transparent;
        color: white;
        font-size: 30px;
        cursor: pointer;
    }

    /* Make table scrollable horizontally on small screens */
    .table-responsive {
        overflow-x: auto;
    }
    </style>
</head>

<body class="sb-nav-fixed">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard Sampah</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"
                onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="notificationLink">
                            <i class="fas fa-bell"></i>
                            <span class="badge bg-danger" id="notificationBadge" style="display:none;">1</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Modal Pop-up untuk Tong Sampah Penuh -->
    <div class="modal fade" id="fullTrashModal" tabindex="-1" aria-labelledby="fullTrashModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fullTrashModalLabel">Tong Sampah Penuh</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Salah satu tong sampah telah penuh. Segera kosongkan!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifikasi di Navbar -->
    <span class="badge bg-danger" id="notificationBadge" style="display:none;">1</span>


    <!-- Sidebar -->
    <div class="sb-sidenav" id="sidebar">
        <!-- Profil Pengguna -->
        <div class="d-flex align-items-center mb-4">
            <img src="{{ asset('assets/img/profile-icon.png') }}" alt="Profile Icon" class="rounded-circle"
                style="width: 40px; height: 40px; margin-right: 10px;">
            <span class="text-white">Selamat datang, {{ Auth::user()->name }}</span>
        </div>
        <a href="#" onclick="showHome()"><i class="fas fa-home"></i>Home</a>
        <a href="#" onclick="showDiagram('dashboard')"><i class="fas fa-chart-pie"></i> Diagram Kepenuhan</a>
        <a href="#" onclick="showTable()"><i class="fas fa-table"></i> Rekap Data</a>
        <a href="#" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Konten Utama -->
    <div class="sb-main">
        <main>
            <div class="container-fluid px-4">
                <ol class="breadcrumb mb-4">
                </ol>

                <!-- Home Content -->
                <div id="homeContent" style="display: block;">
                    <div>
                        <img src="{{ asset('assets/img/person.png') }}" alt="Home Image" class="img-fluid rounded"
                            style="width: 100%; max-width: 600px; height: auto; margin-top: 20px;">
                    </div>
                </div>

                <!-- Container untuk diagram organik dan anorganik -->
                <div id="diagramContainer" class="circular-progress-container" style="display: none;">
                    <h1 class="mt-4">Informasi Sampah</h1>
                    <div>
                        <h2>Organik</h2>
                        <div class="circular-progress" id="organikIndicator">
                            <div class="value-container" id="organikValue">0%</div>
                        </div>
                    </div>
                    <div>
                        <h2>Anorganik</h2>
                        <div class="circular-progress" id="anorganikIndicator">
                            <div class="value-container" id="anorganikValue">0%</div>
                        </div>
                    </div>
                </div>

                <!-- Rekap Data Table -->
                <div id="rekapTableContainer" style="display: none;">
                    <h2>Rekap Data Kepenuhan Tong Sampah</h2>
                    <!-- Make table responsive on small screens -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Kepenuhan Organik (%)</th>
                                    <th>Kepenuhan Anorganik (%)</th>
                                </tr>
                            </thead>
                            <tbody id="rekapTableBody">
                                <!-- Data rows will be inserted here dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const diagramContainer = document.getElementById('diagramContainer');

        if (window.innerWidth <= 768) {
            sidebar.classList.toggle('open'); // Toggle sidebar

            // Jika sidebar terbuka, sesuaikan tampilan diagram
            if (sidebar.classList.contains('open')) {
                diagramContainer.style.marginLeft = '250px'; // Memberikan ruang untuk sidebar
            } else {
                diagramContainer.style.marginLeft = '0'; // Reset margin saat sidebar ditutup
            }
        }
    }


    function showHome() {
        document.getElementById('homeContent').style.display = 'block';
        document.getElementById('diagramContainer').style.display = 'none';
        document.getElementById('rekapTableContainer').style.display = 'none';
    }

    function showDiagram() {
        document.getElementById('homeContent').style.display = 'none';
        document.getElementById('diagramContainer').style.display = 'block';
        document.getElementById('rekapTableContainer').style.display = 'none';
    }

    function showTable() {
        document.getElementById('homeContent').style.display = 'none';
        document.getElementById('diagramContainer').style.display = 'none';
        document.getElementById('rekapTableContainer').style.display = 'block';
    }

    function logout() {
        fetch('/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (response.ok) {
                    window.location.href = '/login';
                } else {
                    alert('Gagal logout. Silakan coba lagi.');
                }
            })
            .catch(error => console.error('Error during logout:', error));
    }

    function updateCircularProgress(indicatorId, value, valueContainerId) {
        const indicator = document.getElementById(indicatorId);
        const valueContainer = document.getElementById(valueContainerId);
        const rotation = (value / 100) * 360;
        indicator.style.background = `conic-gradient(#ff6347 ${rotation}deg, #e8e8e8 ${rotation}deg)`;
        valueContainer.textContent = `${Math.round(value)}%`;
    }

    function renderOrganikDiagram(data) {
        updateCircularProgress("organikIndicator", data, "organikValue");
    }

    function renderAnorganikDiagram(data) {
        updateCircularProgress("anorganikIndicator", data, "anorganikValue");
    }

    function updateRekapTable(organikData, anorganikData) {
        const tableBody = document.getElementById('rekapTableBody');
        const now = new Date();
        const dateString = now.toLocaleDateString();
        const timeString = now.toLocaleTimeString();

        const lastRow = tableBody.querySelector('tr:first-child');
        if (lastRow) {
            const lastDate = lastRow.cells[0].textContent;
            const lastTime = lastRow.cells[1].textContent;

            if (lastDate === dateString && lastTime === timeString) {
                return;
            }
        }

        const row = document.createElement('tr');
        row.innerHTML = `
        <td>${dateString}</td>
        <td>${timeString}</td>
        <td>${organikData}%</td>
        <td>${anorganikData}%</td>
        `;

        tableBody.prepend(row);

        const rows = tableBody.querySelectorAll('tr');
        if (rows.length > 10) {
            tableBody.removeChild(rows[rows.length - 1]);
        }
    }

    let isFullTrashNotified = false; // Flag untuk memastikan pop-up hanya muncul sekali

    function checkFullTrash(organikValue, anorganikValue) {
        // Cek jika salah satu tong sampah penuh (100%)
        if ((organikValue >= 100 || anorganikValue >= 100) && !isFullTrashNotified) {
            showNotification();
            showFullTrashPopup();
            isFullTrashNotified = true; // Menandakan pop-up sudah ditampilkan
        }
    }

    function showNotification() {
        const notificationBadge = document.getElementById('notificationBadge');
        notificationBadge.style.display = 'inline-block'; // Tampilkan badge notifikasi
    }

    function showFullTrashPopup() {
        const fullTrashModal = new bootstrap.Modal(document.getElementById('fullTrashModal'));
        fullTrashModal.show(); // Tampilkan modal pop-up
    }

    function updateCircularProgress(indicatorId, value, valueContainerId) {
        const indicator = document.getElementById(indicatorId);
        const valueContainer = document.getElementById(valueContainerId);
        const rotation = (value / 100) * 360;
        indicator.style.background = `conic-gradient(#ff6347 ${rotation}deg, #e8e8e8 ${rotation}deg)`;
        valueContainer.textContent = `${Math.round(value)}%`;

        // Cek jika tong sampah penuh setelah pembaruan
        checkFullTrash(parseInt(document.getElementById('organikValue').textContent), parseInt(document.getElementById(
            'anorganikValue').textContent));
    }

    function resetFullTrashNotification() {
        // Reset flag setelah modal ditutup
        const fullTrashModal = document.getElementById('fullTrashModal');
        fullTrashModal.addEventListener('hidden.bs.modal', function() {
            isFullTrashNotified =
                false; // Reset flag untuk memungkinkan notifikasi muncul lagi jika kondisi penuh terjadi
        });
    }

    async function fetchData() {
        try {
            const organikResponse = await fetch('/api/organik-data');
            const organikData = await organikResponse.json();
            renderOrganikDiagram(organikData.distance1);

            const anorganikResponse = await fetch('/api/anorganik-data');
            const anorganikData = await anorganikResponse.json();
            renderAnorganikDiagram(anorganikData.distance2);

            updateRekapTable(organikData.distance1, anorganikData.distance2);

        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        fetchData();
        setInterval(fetchData, 5000); // Update setiap 5 detik
        resetFullTrashNotification(); // Menyiapkan reset flag setelah modal ditutup
    });
    </script>
</body>

</html>