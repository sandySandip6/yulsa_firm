document.addEventListener("DOMContentLoaded", () => {
  // NAVIGATION
  const navLinks = document.querySelectorAll(".nav-link");
  const sections = document.querySelectorAll(".content-section");

  navLinks.forEach(link => {
    link.addEventListener("click", e => {
      e.preventDefault();

      // remove active from all
      navLinks.forEach(l => l.classList.remove("active"));
      sections.forEach(s => s.classList.remove("active"));

      // activate clicked link + matching section
      link.classList.add("active");
      const sectionId = link.id.replace("-link", "-section");
      const target = document.getElementById(sectionId);
      if (target) target.classList.add("active");
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
          `;
          teamList.appendChild(div);
        });
      })
      .catch(err => console.error("Error loading team:", err));
  }

  if (teamForm) {
    teamForm.addEventListener("submit", e => {
      e.preventDefault();
      const formData = new FormData(teamForm);
      fetch("add-team.php", {
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
  }

  loadTeam();
});
