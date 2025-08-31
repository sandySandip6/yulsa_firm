document
  .getElementById("collaborateForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("process-form.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text())
      .then((data) => {
        if (data.trim() === "success") {
          // Show the success message
          const successMessage = document.getElementById("success-message");
          successMessage.classList.remove("hidden");

          // Hide the success message after 5 seconds
          setTimeout(() => {
            successMessage.classList.add("hidden");
          }, 5000);
        } else {
          alert("There was an error submitting your form. Please try again.");
        }
      })
      .catch((error) => console.error("Error:", error));
  });
