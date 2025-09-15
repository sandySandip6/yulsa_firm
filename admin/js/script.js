document.addEventListener("DOMContentLoaded", () => {
  // MOBILE MENU TOGGLE (if needed for mobile sidebar)
  const hamburger = document.querySelector('.hamburger');
  const sidebar = document.querySelector('.sidebar');
  
  if (hamburger && sidebar) {
    hamburger.addEventListener('click', () => {
      sidebar.classList.toggle('mobile-open');
    });
  }

  // NAVIGATION
  const navLinks = document.querySelectorAll(".nav-link");
  const sections = document.querySelectorAll(".content-section");

  navLinks.forEach(link => {
    link.addEventListener("click", e => {
      // Handle logout link specially
      if (link.id === "logout-link") {
        e.preventDefault();
        showLogoutModal();
        return;
      }
      
      // Only prevent default for internal navigation links (those with IDs)
      if (link.id) {
        e.preventDefault();

        // remove active from all
        navLinks.forEach(l => l.classList.remove("active"));
        sections.forEach(s => s.classList.remove("active"));

        // activate clicked link + matching section
        link.classList.add("active");
        const sectionId = link.id.replace("-link", "-section");
        const target = document.getElementById(sectionId);
        if (target) target.classList.add("active");
      }
    });
  });

  // ======================
  // USERS SECTION
  // ======================
  const usersTableBody = document.querySelector("#users-table tbody");
  const totalUsers = document.getElementById("total-users");
  const cardTotalUsers = document.getElementById("card-total-users");
  const cardWithServices = document.getElementById("card-with-services");
  const cardEmpty = document.getElementById("card-empty");

  function loadUsers() {
    fetch("fetch-data.php")
      .then(res => res.json())
      .then(data => {
        usersTableBody.innerHTML = "";
        let withServices = 0, emptyProfiles = 0;

        data.forEach(user => {
          if (user.services || user.other_services) {
            withServices++;
          }
          if (!user.b_info && !user.services && !user.other_services) {
            emptyProfiles++;
          }

          const tr = document.createElement("tr");
          tr.innerHTML = `
            <td>${user.id}</td>
            <td>${user.name}</td>
            <td>${user.email}</td>
            <td>${user.b_info || ""}</td>
            <td>${user.services || ""}</td>
            <td>${user.other_services || ""}</td>
            <td><button class="view-btn" data-id="${user.id}">View</button></td>
          `;
          usersTableBody.appendChild(tr);
        });

        totalUsers.textContent = data.length;
        cardTotalUsers.textContent = data.length;
        cardWithServices.textContent = withServices;
        cardEmpty.textContent = emptyProfiles;
      })
      .catch(err => console.error("Error loading users:", err));
  }

  loadUsers();

  // ======================
  // USER VIEW FUNCTIONALITY
  // ======================
  const userModal = document.getElementById("user-modal");
  const userDetails = document.getElementById("user-details");
  const modalClose = document.getElementById("modal-close");

  // Event listener for view buttons (users only)
  document.addEventListener("click", (e) => {
    if (e.target.classList.contains("view-btn") && !e.target.getAttribute("data-type")) {
      const userId = e.target.getAttribute("data-id");
      viewUserDetails(userId);
    }
  });

  function viewUserDetails(userId) {
    // Find user data from the current loaded users
    fetch("fetch-data.php")
      .then(res => res.json())
      .then(data => {
        const user = data.find(u => u.id == userId);
        if (user) {
          userDetails.innerHTML = `
            <div class="user-detail-item">
              <strong>ID:</strong> ${user.id}
            </div>
            <div class="user-detail-item">
              <strong>Name:</strong> ${user.name}
            </div>
            <div class="user-detail-item">
              <strong>Email:</strong> ${user.email}
            </div>
            <div class="user-detail-item">
              <strong>Business Info:</strong> ${user.b_info || "Not provided"}
            </div>
            <div class="user-detail-item">
              <strong>Services Interest:</strong> ${user.services || "Not specified"}
            </div>
            <div class="user-detail-item">
              <strong>Other Services:</strong> ${user.other_services || "Not specified"}
            </div>
          `;
          userModal.setAttribute("aria-hidden", "false");
        }
      })
      .catch(err => console.error("Error fetching user details:", err));
  }

  // Close modal functionality
  modalClose.addEventListener("click", () => {
    userModal.setAttribute("aria-hidden", "true");
  });

  // Close modal when clicking outside
  userModal.addEventListener("click", (e) => {
    if (e.target === userModal) {
      userModal.setAttribute("aria-hidden", "true");
    }
  });

  // ======================
  // TEAM SECTION
  // ======================
  const teamForm = document.getElementById("team-form");
  const teamList = document.getElementById("team-list");

  function loadTeam() {
    fetch("fetch-team.php")
      .then(res => res.json())
      .then(data => {
        teamList.innerHTML = "";
        data.forEach(member => {
          const div = document.createElement("div");
          div.classList.add("team-card");
          div.innerHTML = `
            <img src="${member.image}" alt="${member.name}">
            <h3>${member.name}</h3>
            <p>${member.position}</p>
            <div class="team-actions">
              <button class="btn-edit" data-id="${member.id}" data-name="${member.name}" data-position="${member.position}" data-image="${member.image}">Edit</button>
              <button class="btn-delete" data-id="${member.id}" data-name="${member.name}">Delete</button>
            </div>
          `;
          teamList.appendChild(div);
        });
      })
      .catch(err => console.error("Error loading team:", err));
  }

  teamForm.addEventListener("submit", e => {
    e.preventDefault();
    const formData = new FormData(teamForm);
    fetch("team-upload.php", {
      method: "POST",
      body: formData
    })
      .then(res => res.json())
      .then(result => {
        if (result.success) {
          teamForm.reset();
          loadTeam();
        } else {
          alert(result.error || "Failed to add member");
        }
      })
      .catch(err => console.error("Error adding team member:", err));
  });

  loadTeam();

  // ======================
  // TEAM UPDATE/DELETE FUNCTIONALITY
  // ======================
  
  // Update modal elements
  const teamUpdateModal = document.getElementById("team-update-modal");
  const teamUpdateForm = document.getElementById("team-update-form");
  const teamUpdateClose = document.getElementById("team-update-close");
  const cancelUpdate = document.getElementById("cancel-update");
  
  // Delete modal elements
  const teamDeleteModal = document.getElementById("team-delete-modal");
  const teamDeleteClose = document.getElementById("team-delete-close");
  const cancelDelete = document.getElementById("cancel-delete");
  const confirmDelete = document.getElementById("confirm-delete");
  
  let memberToDelete = null;

  // Event listeners for edit buttons
  document.addEventListener("click", (e) => {
    if (e.target.classList.contains("btn-edit")) {
      const id = e.target.getAttribute("data-id");
      const name = e.target.getAttribute("data-name");
      const position = e.target.getAttribute("data-position");
      const image = e.target.getAttribute("data-image");
      
      // Populate update form
      document.getElementById("update-member-id").value = id;
      document.getElementById("update-member-name").value = name;
      document.getElementById("update-member-position").value = position;
      document.getElementById("current-image-preview").src = image;
      
      // Show update modal
      teamUpdateModal.setAttribute("aria-hidden", "false");
    }
    
    if (e.target.classList.contains("btn-delete")) {
      const id = e.target.getAttribute("data-id");
      const name = e.target.getAttribute("data-name");
      
      memberToDelete = id;
      document.getElementById("delete-member-name").textContent = name;
      
      // Show delete modal
      teamDeleteModal.setAttribute("aria-hidden", "false");
    }
  });

  // Close update modal
  teamUpdateClose.addEventListener("click", () => {
    teamUpdateModal.setAttribute("aria-hidden", "true");
  });
  
  cancelUpdate.addEventListener("click", () => {
    teamUpdateModal.setAttribute("aria-hidden", "true");
  });

  // Close delete modal
  teamDeleteClose.addEventListener("click", () => {
    teamDeleteModal.setAttribute("aria-hidden", "true");
  });
  
  cancelDelete.addEventListener("click", () => {
    teamDeleteModal.setAttribute("aria-hidden", "true");
  });

  // Handle update form submission
  teamUpdateForm.addEventListener("submit", (e) => {
    e.preventDefault();
    
    const formData = new FormData(teamUpdateForm);
    const currentImageSrc = document.getElementById("current-image-preview").src;
    const currentImageFilename = currentImageSrc.split("/").pop();
    formData.append("current_image", currentImageFilename);
    
    fetch("update-team.php", {
      method: "POST",
      body: formData
    })
      .then(res => res.json())
      .then(result => {
        if (result.success) {
          teamUpdateModal.setAttribute("aria-hidden", "true");
          loadTeam();
          alert("Team member updated successfully!");
        } else {
          alert(result.message || "Failed to update member");
        }
      })
      .catch(err => console.error("Error updating team member:", err));
  });

  // Handle delete confirmation
  confirmDelete.addEventListener("click", () => {
    if (memberToDelete) {
      const formData = new FormData();
      formData.append("id", memberToDelete);
      
      fetch("delete-team.php", {
        method: "POST",
        body: formData
      })
        .then(res => res.json())
        .then(result => {
          if (result.success) {
            teamDeleteModal.setAttribute("aria-hidden", "true");
            loadTeam();
            alert("Team member deleted successfully!");
          } else {
            alert(result.message || "Failed to delete member");
          }
        })
        .catch(err => console.error("Error deleting team member:", err));
    }
  });

  // Close modals when clicking outside
  teamUpdateModal.addEventListener("click", (e) => {
    if (e.target === teamUpdateModal) {
      teamUpdateModal.setAttribute("aria-hidden", "true");
    }
  });
  
  teamDeleteModal.addEventListener("click", (e) => {
    if (e.target === teamDeleteModal) {
      teamDeleteModal.setAttribute("aria-hidden", "true");
    }
  });

  // ======================
  // LOGOUT CONFIRMATION MODAL
  // ======================
  const logoutModal = document.getElementById("logout-modal");
  const logoutClose = document.getElementById("logout-close");
  const cancelLogout = document.getElementById("cancel-logout");
  const confirmLogout = document.getElementById("confirm-logout");

  function showLogoutModal() {
    logoutModal.setAttribute("aria-hidden", "false");
  }

  function hideLogoutModal() {
    logoutModal.setAttribute("aria-hidden", "true");
  }

  // Close logout modal
  logoutClose.addEventListener("click", hideLogoutModal);
  cancelLogout.addEventListener("click", hideLogoutModal);

  // Confirm logout
  confirmLogout.addEventListener("click", () => {
    window.location.href = "logout.php";
  });

  // Close logout modal when clicking outside
  logoutModal.addEventListener("click", (e) => {
    if (e.target === logoutModal) {
      hideLogoutModal();
    }
  });

  // ======================
  // CONTACT MESSAGES SECTION
  // ======================
  const contactTableBody = document.querySelector("#contact-table tbody");
  const contactRowsPerPage = document.getElementById("contact-rows-per-page");
  const contactPagination = document.getElementById("contact-pagination");
  const contactPaginationBottom = document.getElementById("contact-pagination-bottom");
  const contactTableStatus = document.getElementById("contact-table-status");
  const searchInput = document.getElementById("search-input");

  let currentContactPage = 1;
  let contactData = [];
  let contactTotalPages = 1;

  function loadContactMessages(page = 1, limit = 10, search = '') {
    const params = new URLSearchParams({
      page: page,
      limit: limit,
      search: search
    });

    fetch(`fetch-contact.php?${params}`)
      .then(res => res.json())
      .then(data => {
        contactData = data.contacts;
        contactTotalPages = data.pagination.total_pages;
        currentContactPage = data.pagination.current_page;
        
        renderContactTable();
        renderContactPagination();
        updateContactTableStatus(data.pagination);
      })
      .catch(err => console.error("Error loading contact messages:", err));
  }

  function renderContactTable() {
    contactTableBody.innerHTML = "";
    
    contactData.forEach(contact => {
      const tr = document.createElement("tr");
      const messagePreview = contact.message.length > 50 ? 
        contact.message.substring(0, 50) + "..." : contact.message;
      
      tr.innerHTML = `
        <td>${contact.id}</td>
        <td>${contact.name}</td>
        <td>${contact.email}</td>
        <td title="${contact.message}">${messagePreview}</td>
        <td>
          <button class="contact-view-btn" data-id="${contact.id}">View</button>
          <button class="btn-delete" data-id="${contact.id}" data-type="contact">Delete</button>
        </td>
      `;
      contactTableBody.appendChild(tr);
    });
  }

  function renderContactPagination() {
    const paginationHTML = generatePaginationHTML(currentContactPage, contactTotalPages, 'contact');
    contactPagination.innerHTML = paginationHTML;
    contactPaginationBottom.innerHTML = paginationHTML;
  }

  function generatePaginationHTML(currentPage, totalPages, type) {
    let html = '';
    
    // Previous button
    if (currentPage > 1) {
      html += `<button onclick="loadContactMessages(${currentPage - 1}, ${contactRowsPerPage.value}, '${searchInput.value}')">Previous</button>`;
    }
    
    // Page numbers
    const startPage = Math.max(1, currentPage - 2);
    const endPage = Math.min(totalPages, currentPage + 2);
    
    for (let i = startPage; i <= endPage; i++) {
      const activeClass = i === currentPage ? 'active' : '';
      html += `<button class="${activeClass}" onclick="loadContactMessages(${i}, ${contactRowsPerPage.value}, '${searchInput.value}')">${i}</button>`;
    }
    
    // Next button
    if (currentPage < totalPages) {
      html += `<button onclick="loadContactMessages(${currentPage + 1}, ${contactRowsPerPage.value}, '${searchInput.value}')">Next</button>`;
    }
    
    return html;
  }

  function updateContactTableStatus(pagination) {
    const start = ((pagination.current_page - 1) * pagination.limit) + 1;
    const end = Math.min(pagination.current_page * pagination.limit, pagination.total_records);
    contactTableStatus.textContent = `Showing ${start}-${end} of ${pagination.total_records} contact messages`;
  }

  // Event listeners for contact messages
  contactRowsPerPage.addEventListener("change", () => {
    loadContactMessages(1, contactRowsPerPage.value, searchInput.value);
  });

  // Search functionality for contact messages
  searchInput.addEventListener("input", (e) => {
    const searchTerm = e.target.value;
    loadContactMessages(1, contactRowsPerPage.value, searchTerm);
  });

  // Load contact messages when contact section is active
  document.getElementById("contact-link").addEventListener("click", () => {
    loadContactMessages();
  });

  // ======================
  // CONTACT MESSAGE MODAL FUNCTIONALITY
  // ======================
  const contactModal = document.getElementById("contact-modal");
  const contactDetails = document.getElementById("contact-details");
  const contactModalClose = document.getElementById("contact-modal-close");
  const contactDeleteModal = document.getElementById("contact-delete-modal");
  const contactDeleteClose = document.getElementById("contact-delete-close");
  const cancelContactDelete = document.getElementById("cancel-contact-delete");
  const confirmContactDelete = document.getElementById("confirm-contact-delete");

  let contactToDelete = null;

  // Event listeners for contact message actions
  document.addEventListener("click", (e) => {
    if (e.target.classList.contains("contact-view-btn")) {
      const contactId = e.target.getAttribute("data-id");
      viewContactDetails(contactId);
    }
    
    if (e.target.classList.contains("btn-delete") && e.target.getAttribute("data-type") === "contact") {
      const contactId = e.target.getAttribute("data-id");
      contactToDelete = contactId;
      contactDeleteModal.setAttribute("aria-hidden", "false");
    }
  });

  function viewContactDetails(contactId) {
    const contact = contactData.find(c => c.id == contactId);
    if (contact) {
      contactDetails.innerHTML = `
        <div class="contact-detail-item">
          <strong>ID:</strong> ${contact.id}
        </div>
        <div class="contact-detail-item">
          <strong>Name:</strong> ${contact.name}
        </div>
        <div class="contact-detail-item">
          <strong>Email:</strong> <a href="mailto:${contact.email}">${contact.email}</a>
        </div>
        <div class="contact-detail-item">
          <strong>Message:</strong>
          <div style="margin-top: 10px; padding: 10px; background: #f5f5f5; border-radius: 5px; white-space: pre-wrap;">${contact.message}</div>
        </div>
      `;
      contactModal.setAttribute("aria-hidden", "false");
    }
  }

  // Close contact modal
  contactModalClose.addEventListener("click", () => {
    contactModal.setAttribute("aria-hidden", "true");
  });

  // Close contact delete modal
  contactDeleteClose.addEventListener("click", () => {
    contactDeleteModal.setAttribute("aria-hidden", "true");
  });

  cancelContactDelete.addEventListener("click", () => {
    contactDeleteModal.setAttribute("aria-hidden", "true");
  });

  // Handle contact delete confirmation
  confirmContactDelete.addEventListener("click", () => {
    if (contactToDelete) {
      const formData = new FormData();
      formData.append("id", contactToDelete);
      
      fetch("delete-contact.php", {
        method: "POST",
        body: formData
      })
        .then(res => res.json())
        .then(result => {
          if (result.success) {
            contactDeleteModal.setAttribute("aria-hidden", "true");
            loadContactMessages(currentContactPage, contactRowsPerPage.value, searchInput.value);
            alert("Contact message deleted successfully!");
          } else {
            alert(result.message || "Failed to delete contact message");
          }
        })
        .catch(err => console.error("Error deleting contact message:", err));
    }
  });

  // Close modals when clicking outside
  contactModal.addEventListener("click", (e) => {
    if (e.target === contactModal) {
      contactModal.setAttribute("aria-hidden", "true");
    }
  });

  contactDeleteModal.addEventListener("click", (e) => {
    if (e.target === contactDeleteModal) {
      contactDeleteModal.setAttribute("aria-hidden", "true");
    }
  });
});
