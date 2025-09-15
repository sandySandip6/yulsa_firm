document
  .getElementById("collaborateForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const submitButton = this.querySelector('button[type="submit"]');
    
    // Disable submit button and show loading state
    submitButton.disabled = true;
    submitButton.textContent = 'Submitting...';

    fetch("process-form.php", {
      method: "POST",
      body: formData,
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.status === 'success') {
          // Show success message
          alert(data.message);
          
          // Close the modal
          document.getElementById('collaborateModal').style.display = 'none';
          
          // Reset the form
          this.reset();
          
          // Hide other service field if it was shown
          const otherServiceGroup = document.getElementById('other-service-group');
          if (otherServiceGroup) {
            otherServiceGroup.classList.add('hidden');
          }
        } else {
          alert(data.message || "There was an error submitting your form. Please try again.");
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("There was an error submitting your form. Please try again.");
        // Fallback: redirect to home page after error
        setTimeout(() => {
          window.location.href = 'index.php';
        }, 2000);
      })
      .finally(() => {
        // Re-enable submit button
        submitButton.disabled = false;
        submitButton.textContent = 'Submit';
      });
  });
