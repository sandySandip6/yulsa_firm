// script.js (v1.2)
document.addEventListener('DOMContentLoaded', () => {
  const dashboardLink = document.getElementById('dashboard-link');
  const usersLink = document.getElementById('users-link');
  const dashboardSection = document.getElementById('dashboard-section');
  const usersSection = document.getElementById('users-section');

  const searchInput = document.getElementById('search-input');
  const rowsPerPageSelect = document.getElementById('rows-per-page');
  const paginationEl = document.getElementById('pagination');
  const paginationBottom = document.getElementById('pagination-bottom');
  const tableStatus = document.getElementById('table-status');

  const totalUsersEl = document.getElementById('total-users');
  const cardTotalUsers = document.getElementById('card-total-users');
  const cardWithServices = document.getElementById('card-with-services');
  const cardEmpty = document.getElementById('card-empty');

  const exportCsvBtn = document.getElementById('export-csv');

  const body = document.body;
  const darkToggle = document.getElementById('dark-mode-toggle');

  let allUsers = [];   // raw data from server
  let filtered = [];   // filtered/sorted data
  let currentPage = 1;
  let rowsPerPage = parseInt(rowsPerPageSelect.value, 10);
  let sortState = { key: null, dir: 1 }; // dir: 1 asc, -1 desc

  // Modal elements
  const modal = document.getElementById('user-modal');
  const modalClose = document.getElementById('modal-close');
  const userDetails = document.getElementById('user-details');

  // NAV
  dashboardLink.addEventListener('click', (e) => { e.preventDefault(); showSection('dashboard'); });
  usersLink.addEventListener('click', (e) => { e.preventDefault(); showSection('users'); fetchAndRender(); });

  function showSection(name) {
    document.querySelectorAll('.nav-link').forEach(a => a.classList.remove('active'));
    if (name === 'dashboard') {
      dashboardLink.classList.add('active');
      dashboardSection.classList.add('active');
      usersSection.classList.remove('active');
    } else {
      usersLink.classList.add('active');
      dashboardSection.classList.remove('active');
      usersSection.classList.add('active');
    }
  }

  // Dark mode toggle (persist)
  if (localStorage.getItem('admin-dark') === '1') { body.classList.add('dark'); }
  darkToggle.addEventListener('click', () => {
    body.classList.toggle('dark');
    localStorage.setItem('admin-dark', body.classList.contains('dark') ? '1' : '0');
  });

  // Normalizer for service fields
  function normalizeListField(value) {
    if (value === null || value === undefined || value === '') return '';
    if (Array.isArray(value)) return value.join(', ');
    if (typeof value === 'string') {
      const s = value.trim();
      if ((s.startsWith('[') && s.endsWith(']')) || (s.startsWith('"') && s.endsWith('"'))) {
        try {
          const parsed = JSON.parse(s);
          if (Array.isArray(parsed)) return parsed.join(', ');
          return String(parsed);
        } catch (e) { /* ignore */ }
      }
      if (s.includes(',')) return s.split(',').map(x => x.trim()).join(', ');
      return s;
    }
    return String(value);
  }

  // Fetch data
  function fetchAndRender() {
    console.log('fetching users...');
    fetch('fetch-data.php')
      .then(res => res.text())
      .then(text => {
        try {
          const json = JSON.parse(text);
          allUsers = json.map(u => {
            return {
              ...u,
              services: normalizeListField(u.services ?? u.service ?? ''),
              other_services: normalizeListField(u.other_services ?? u.other_service ?? '')
            };
          });
          renderDashboardCards();
          applyFilterAndRender();
          console.log('Loaded users:', allUsers.length);
        } catch (e) {
          console.error('Invalid JSON response from fetch-data.php', text);
          tableStatus.textContent = 'Error: invalid server response. Check console.';
        }
      })
      .catch(err => {
        console.error('Fetch error', err);
        tableStatus.textContent = 'Error fetching data.';
      });
  }

  // Dashboard card counts
  function renderDashboardCards() {
    const total = allUsers.length;
    const withServices = allUsers.filter(u => u.services && u.services.trim() !== '').length;
    const emptyProfiles = allUsers.filter(u => (!u.b_info || !u.b_info.trim()) && (!u.services || !u.services.trim())).length;

    totalUsersEl.textContent = total;
    cardTotalUsers.textContent = total;
    cardWithServices.textContent = withServices;
    cardEmpty.textContent = emptyProfiles;
  }

  // Filtering, searching, sorting
  function applyFilterAndRender() {
    const q = (searchInput.value || '').toLowerCase().trim();
    filtered = allUsers.filter(u => {
      if (!q) return true;
      return (
        String(u.name || '').toLowerCase().includes(q) ||
        String(u.email || '').toLowerCase().includes(q) ||
        String(u.services || '').toLowerCase().includes(q) ||
        String(u.other_services || '').toLowerCase().includes(q)
      );
    });

    // apply sort if set
    if (sortState.key) {
      filtered.sort((a, b) => {
        const A = String(a[sortState.key] ?? '').toLowerCase();
        const B = String(b[sortState.key] ?? '').toLowerCase();
        if (A < B) return -1 * sortState.dir;
        if (A > B) return 1 * sortState.dir;
        return 0;
      });
    }

    currentPage = 1;
    rowsPerPage = parseInt(rowsPerPageSelect.value, 10);
    renderTable();
  }

  // Render table
  function renderTable() {
    const tbody = document.querySelector('#users-table tbody');
    tbody.innerHTML = '';
    const total = filtered.length;
    const start = (currentPage - 1) * rowsPerPage;
    const pageData = filtered.slice(start, start + rowsPerPage);

    pageData.forEach(user => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${user.id ?? '-'}</td>
        <td>${user.name ?? '-'}</td>
        <td>${user.email ?? '-'}</td>
        <td>${(user.b_info && user.b_info.trim()) ? escapeHtml(user.b_info) : '-'}</td>
        <td>${user.services ? '<span class="badge">' + escapeHtml(user.services) + '</span>' : '-'}</td>
        <td>${user.other_services ? escapeHtml(user.other_services) : '-'}</td>
        <td><button class="action-btn" data-id="${user.id}" data-action="view">View</button></td>
      `;
      tbody.appendChild(tr);
    });

    tableStatus.textContent = `Showing ${Math.min(total, start + 1)} - ${Math.min(total, start + pageData.length)} of ${total} results.`;
    renderPagination(total);
    // attach row action listeners
    tbody.querySelectorAll('.action-btn').forEach(btn => btn.addEventListener('click', onRowAction));
  }

  // escape to prevent HTML injection
  function escapeHtml(s) {
    if (s === null || s === undefined) return '';
    return String(s).replace(/[&<>"]/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));
  }

  // Pagination render
  function renderPagination(totalItems) {
    const totalPages = Math.max(1, Math.ceil(totalItems / rowsPerPage));
    function build(pEl) {
      pEl.innerHTML = '';
      const createBtn = (txt, disabled, cb) => {
        const btn = document.createElement('button');
        btn.className = 'page-btn';
        btn.textContent = txt;
        if (disabled) btn.disabled = true;
        btn.addEventListener('click', cb);
        return btn;
      };
      pEl.appendChild(createBtn('Prev', currentPage === 1, () => { currentPage--; renderTable(); }));
      // show up to 5 page numbers
      const range = 2;
      const start = Math.max(1, currentPage - range);
      const end = Math.min(totalPages, currentPage + range);
      for (let i = start; i <= end; i++) {
        const btn = createBtn(i, false, () => { currentPage = i; renderTable(); });
        if (i === currentPage) btn.style.fontWeight = '700';
        pEl.appendChild(btn);
      }
      pEl.appendChild(createBtn('Next', currentPage === totalPages, () => { currentPage++; renderTable(); }));
    }
    build(paginationEl);
    build(paginationBottom);
  }

  // Row action: view details
  function onRowAction(e) {
    const id = e.currentTarget.dataset.id;
    const user = allUsers.find(u => String(u.id) === String(id));
    if (!user) return;
    openUserModal(user);
  }

  function openUserModal(user) {
    userDetails.innerHTML = `
      <div style="display:flex; gap:12px; align-items:flex-start;">
        <img src="./img/user-placeholder.png" style="width:72px;height:72px;border-radius:8px;object-fit:cover" />
        <div>
          <h3 style="margin:0 0 6px 0;">${escapeHtml(user.name || '—')}</h3>
          <div style="color:var(--muted);font-size:13px;">${escapeHtml(user.email || '—')}</div>
        </div>
      </div>
      <hr style="margin:12px 0;">
      <p><strong>Business Info:</strong><br>${escapeHtml(user.b_info || '—')}</p>
      <p><strong>Services:</strong><br>${escapeHtml(user.services || '—')}</p>
      <p><strong>Other Services:</strong><br>${escapeHtml(user.other_services || '—')}</p>
    `;
    modal.setAttribute('aria-hidden', 'false');
  }

  modalClose.addEventListener('click', () => modal.setAttribute('aria-hidden', 'true'));
  modal.addEventListener('click', (ev) => { if (ev.target === modal) modal.setAttribute('aria-hidden', 'true'); });

  // Search + rows per page
  searchInput.addEventListener('input', () => { applyFilterAndRender(); });
  rowsPerPageSelect.addEventListener('change', () => { rowsPerPage = parseInt(rowsPerPageSelect.value, 10); currentPage = 1; renderTable(); });

  // Sorting on header click
  document.querySelectorAll('#users-table thead th.sortable').forEach(th => {
    th.style.cursor = 'pointer';
    th.addEventListener('click', () => {
      const key = th.dataset.key;
      if (sortState.key === key) sortState.dir = -sortState.dir;
      else { sortState.key = key; sortState.dir = 1; }
      applyFilterAndRender();
    });
  });

  // CSV Export
  exportCsvBtn.addEventListener('click', exportToCsv);

  function exportToCsv() {
    const headers = ['ID', 'Name', 'Email', 'Business Info', 'Services', 'Other Services'];
    const rows = filtered.map(u => [
      u.id || '', u.name || '', u.email || '', u.b_info || '', u.services || '', u.other_services || ''
    ]);
    const csvContent = [headers, ...rows].map(r => r.map(cell => `"${String(cell).replace(/"/g, '""')}"`).join(',')).join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url; a.download = `users_export_${new Date().toISOString().slice(0, 10)}.csv`;
    document.body.appendChild(a); a.click(); a.remove();
    URL.revokeObjectURL(url);
  }

  // initial show dashboard; if you want to auto-fetch users on load call fetchAndRender();
  showSection('dashboard');

  // Expose fetch for manual debugging:
  window.adminFetch = fetchAndRender;
});
