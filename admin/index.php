<?php 
session_start();
// If admin is not logged in, redirect to login page
if (!isset($_SESSION['yadmin'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./css/style.css?v=1.1">
</head>

<body>
  <div class="dashboard-layout">
    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="brand">
        <img src="./img/logo-placeholder.svg" alt="logo" class="brand-logo">
        <div>
          <h2>Admin Panel</h2>
          <small>Manage Collaborations</small>
        </div>
      </div>

      <nav class="nav">
        <a href="#" id="dashboard-link" class="nav-link active"><span>Dashboard</span></a>
        <a href="#" id="users-link" class="nav-link"><span>Users</span></a>
        <a href="logout.php" class="nav-link"><span>Logout</span></a>
      </nav>

      <div class="sidebar-footer">
        <button id="dark-mode-toggle" class="btn-ghost">Toggle Dark</button>
      </div>
    </aside>

    <!-- MAIN -->
    <main class="main">
      <header class="topbar">
        <div class="search-wrap">
          <input id="search-input" type="search" placeholder="Search by name, email or service..." />
          <button id="export-csv" title="Export table to CSV">Export CSV</button>
        </div>

        <div class="topbar-right">
          <div class="stat-inline">
            <div>Total users <div id="total-users" class="stat-num">0</div></div>
          </div>
          <div class="profile">
            <img src="./img/user-placeholder.png" alt="admin" class="avatar">
            <span class="username">Admin</span>
          </div>
        </div>
      </header>

      <section id="dashboard-section" class="content-section active">
        <div class="cards">
          <div class="card">
            <div class="card-title">Total Users</div>
            <div id="card-total-users" class="card-value">0</div>
          </div>
          <div class="card">
            <div class="card-title">With Services</div>
            <div id="card-with-services" class="card-value">0</div>
          </div>
          <div class="card">
            <div class="card-title">Empty Profiles</div>
            <div id="card-empty" class="card-value">0</div>
          </div>
        </div>

        <div class="welcome">
          <h1>Welcome back</h1>
          <p>Overview of the platform and quick actions.</p>
        </div>
      </section>

      <section id="users-section" class="content-section">
        <h1>Users</h1>

        <div class="table-controls">
          <div>
            <label>Rows:
              <select id="rows-per-page">
                <option>5</option>
                <option selected>10</option>
                <option>20</option>
              </select>
            </label>
          </div>
          <div class="pagination" id="pagination"></div>
        </div>

        <div class="table-wrap">
          <table id="users-table" class="styled-table">
            <thead>
              <tr>
                <th data-key="id" class="sortable">ID</th>
                <th data-key="name" class="sortable">Name</th>
                <th data-key="email" class="sortable">Email</th>
                <th data-key="b_info">Business Info</th>
                <th data-key="services">Services Interest</th>
                <th data-key="other_services">Other Service</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- rows inserted by JS -->
            </tbody>
          </table>
        </div>

        <div class="table-controls bottom-controls">
          <div id="table-status" class="table-status"></div>
          <div class="pagination" id="pagination-bottom"></div>
        </div>
      </section>
    </main>
  </div>

  <!-- USER DETAILS MODAL -->
  <div id="user-modal" class="modal" aria-hidden="true">
    <div class="modal-panel">
      <button class="modal-close" id="modal-close">&times;</button>
      <h2>User details</h2>
      <div id="user-details">
        <!-- filled by JS -->
      </div>
    </div>
  </div>

      <script src="./js/script.js?v=1.1"></script>
</body>


</html>
