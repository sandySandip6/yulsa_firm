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
  <link rel="stylesheet" href="./css/style.css?v=1.5">
</head>

<body>
  <div class="dashboard-layout">
    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="brand">
        <img src="https://cdn-icons-png.flaticon.com/512/9703/9703596.png" alt="logo" class="brand-logo">
        <div>
          <h2>Admin Panel</h2>
          <small>Manage Collaborations</small>
        </div>
      </div>

      <nav class="nav">
        <a href="#" id="dashboard-link" class="nav-link active"><span>Dashboard</span></a>
        <a href="#" id="users-link" class="nav-link"><span>Clients</span></a>
        <a href="#" id="team-link" class="nav-link"><span>Team</span></a>
        <a href="#" id="contact-link" class="nav-link"><span>Contact Messages</span></a>
        <a href="logout.php" id="logout-link" class="nav-link"><span>Logout</span></a>
      </nav>

      <div class="sidebar-footer">
        <button id="dark-mode-toggle" class="btn-ghost">Toggle Dark</button>
      </div>
    </aside>

    <!-- MAIN -->
    <main class="main">
      <!-- TOPBAR -->
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
            <img src="https://cdn-icons-png.flaticon.com/512/9703/9703596.png" alt="admin" class="avatar">
            <span class="username">Admin</span>
          </div>
        </div>
      </header>

      <!-- DASHBOARD -->
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

      <!-- USERS -->
      <section id="users-section" class="content-section">
        <h1>Clients</h1>

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

      <!-- TEAM -->
      <section id="team-section" class="content-section">
        <h1>Team Members</h1>

        <!-- Upload Form -->
        <form id="team-form" enctype="multipart/form-data" method="POST">
          <input type="text" name="name" placeholder="Name" required>
          <input type="text" name="position" placeholder="Position" required>
          <input type="file" name="image" accept="image/*" required>
          <button type="submit">Add Member</button>
        </form>

        <!-- Team List -->
        <div id="team-list" class="team-grid">
          <!-- dynamically filled -->
        </div>
      </section>

      <!-- CONTACT MESSAGES -->
      <section id="contact-section" class="content-section">
        <h1>Contact Messages</h1>

        <div class="table-controls">
          <div>
            <label>Rows:
              <select id="contact-rows-per-page">
                <option>5</option>
                <option selected>10</option>
                <option>20</option>
              </select>
            </label>
          </div>
          <div class="pagination" id="contact-pagination"></div>
        </div>

        <div class="table-wrap">
          <table id="contact-table" class="styled-table"> 
            <thead>
              <tr>
                <th data-key="id" class="sortable">ID</th>
                <th data-key="name" class="sortable">Name</th>
                <th data-key="email" class="sortable">Email</th>
                <th data-key="message">Message</th>

                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- rows inserted by JS -->
            </tbody>
          </table>
        </div>

        <div class="table-controls bottom-controls">
          <div id="contact-table-status" class="table-status"></div>
          <div class="pagination" id="contact-pagination-bottom"></div>
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

  <!-- TEAM UPDATE MODAL -->
  <div id="team-update-modal" class="modal" aria-hidden="true">
    <div class="modal-panel">
      <button class="modal-close" id="team-update-close">&times;</button>
      <h2>Update Team Member</h2>
      <form id="team-update-form" enctype="multipart/form-data">
        <input type="hidden" id="update-member-id" name="id">
        <input type="text" id="update-member-name" name="name" placeholder="Name" required>
        <input type="text" id="update-member-position" name="position" placeholder="Position" required>
        <div class="image-preview">
          <img id="current-image-preview" src="" alt="Current image" style="max-width: 100px; max-height: 100px; border-radius: 50%; margin: 10px 0;">
        </div>
        <input type="file" id="update-member-image" name="image" accept="image/*">
        <div class="modal-actions">
          <button type="button" id="cancel-update" class="btn-cancel">Cancel</button>
          <button type="submit" class="btn-save">Update Member</button>
        </div>
      </form>
    </div>
  </div>

  <!-- TEAM DELETE CONFIRMATION MODAL -->
  <div id="team-delete-modal" class="modal" aria-hidden="true">
    <div class="modal-panel">
      <button class="modal-close" id="team-delete-close">&times;</button>
      <h2>Delete Team Member</h2>
      <p>Are you sure you want to delete <strong id="delete-member-name"></strong>?</p>
      <p class="warning-text">This action cannot be undone.</p>
      <div class="modal-actions">
        <button type="button" id="cancel-delete" class="btn-cancel">Cancel</button>
        <button type="button" id="confirm-delete" class="btn-delete-confirm">Delete</button>
      </div>
    </div>
  </div>

  <!-- CONTACT MESSAGE DETAILS MODAL -->
  <div id="contact-modal" class="modal" aria-hidden="true">
    <div class="modal-panel">
      <button class="modal-close" id="contact-modal-close">&times;</button>
      <h2>Contact Message Details</h2>
      <div id="contact-details">
        <!-- filled by JS -->
      </div>
    </div>
  </div>

  <!-- CONTACT MESSAGE DELETE CONFIRMATION MODAL -->
  <div id="contact-delete-modal" class="modal" aria-hidden="true">
    <div class="modal-panel">
      <button class="modal-close" id="contact-delete-close">&times;</button>
      <h2>Delete Contact Message</h2>
      <p>Are you sure you want to delete this contact message?</p>
      <p class="warning-text">This action cannot be undone.</p>
      <div class="modal-actions">
        <button type="button" id="cancel-contact-delete" class="btn-cancel">Cancel</button>
        <button type="button" id="confirm-contact-delete" class="btn-delete-confirm">Delete</button>
      </div>
    </div>
  </div>

  <!-- LOGOUT CONFIRMATION MODAL -->
  <div id="logout-modal" class="modal" aria-hidden="true">
    <div class="modal-panel">
      <button class="modal-close" id="logout-close">&times;</button>
      <div class="logout-icon">🚪</div>
      <h2>Confirm Logout</h2>
      <p>Are you sure you want to logout from the admin panel?</p>
      <p class="warning-text">You will need to login again to access the admin dashboard.</p>
      <div class="modal-actions">
        <button type="button" id="cancel-logout" class="btn-cancel">Cancel</button>
        <button type="button" id="confirm-logout" class="btn-logout-confirm">Logout</button>
      </div>
    </div>
  </div>

  <script src="./js/script.js?v=1.5"></script>
</body>
</html>
