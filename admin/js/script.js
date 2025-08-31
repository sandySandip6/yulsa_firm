// script.js — replace your entire file with this exact content
document.addEventListener("DOMContentLoaded", () => {
    const dashboardLink = document.getElementById("dashboard-link");
    const usersLink = document.getElementById("users-link");
    const dashboardSection = document.getElementById("dashboard-section");
    const usersSection = document.getElementById("users-section");
  
    dashboardSection.style.display = "block";
  
    dashboardLink.addEventListener("click", (e) => {
      e.preventDefault();
      dashboardSection.style.display = "block";
      usersSection.style.display = "none";
    });
  
    usersLink.addEventListener("click", (e) => {
      e.preventDefault();
      dashboardSection.style.display = "none";
      usersSection.style.display = "block";
      fetchUserData();
    });
  
    function normalizeListField(value) {
      if (value === null || value === undefined || value === "") return "-";
      if (Array.isArray(value)) return value.join(", ");
      if (typeof value === "string") {
        const s = value.trim();
        if ((s.startsWith("[") && s.endsWith("]")) || (s.startsWith('"') && s.endsWith('"'))) {
          try {
            const parsed = JSON.parse(s);
            if (Array.isArray(parsed)) return parsed.join(", ");
            return String(parsed);
          } catch (err) {
            // not JSON
          }
        }
        if (s.includes(",")) return s.split(",").map(x => x.trim()).join(", ");
        return s || "-";
      }
      return String(value);
    }
  
    function fetchUserData() {
      console.log("Fetching users from fetch-data.php ...");
      fetch("fetch-data.php")
        .then(res => {
          // show raw text for debugging if JSON fails
          return res.text().then(text => {
            try {
              const json = JSON.parse(text);
              return json;
            } catch (e) {
              console.error("fetch-data.php did not return valid JSON. Raw response:", text);
              throw e;
            }
          });
        })
        .then((data) => {
          console.log("Fetched data (from fetch-data.php):", data);
          if (!Array.isArray(data)) {
            throw new Error("Expected an array");
          }
  
          const tbody = document.querySelector("#users-table tbody");
          tbody.innerHTML = "";
  
          if (data.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6">No users found</td></tr>`;
            return;
          }
  
          data.forEach(user => {
            // Use the exact keys your server returns; fallback to other names if necessary
            const servicesRaw = user.services ?? user.service ?? user.services_interest ?? "";
            const otherRaw = user.other_services ?? user.other_service ?? user.otherService ?? "";
  
            const services = normalizeListField(servicesRaw);
            const other = normalizeListField(otherRaw);
  
            const row = document.createElement("tr");
            row.innerHTML = `
              <td>${user.id ?? "-"}</td>
              <td>${user.name ?? "-"}</td>
              <td>${user.email ?? "-"}</td>
              <td>${user.b_info ?? "-"}</td>
              <td>${services}</td>
              <td>${other}</td>
            `;
            tbody.appendChild(row);
          });
        })
        .catch(err => {
          console.error("Error loading user data:", err);
          const tbody = document.querySelector("#users-table tbody");
          if (tbody) tbody.innerHTML = `<tr><td colspan="6">Error loading users</td></tr>`;
        });
    }
  });
  