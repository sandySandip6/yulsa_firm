document.addEventListener('DOMContentLoaded', () => {
  const links = document.querySelectorAll('.links a'); // Select all navigation links

  links.forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault(); // Prevent default navigation
      const cleanURL = link.getAttribute('href').replace('.html', ''); // Remove ".html" from URL
      window.history.pushState({}, '', cleanURL); // Update the URL in the browser

      // Log or simulate navigation
      console.log(`Simulated navigation to: ${cleanURL}`);

      // Optional: Load content dynamically here if required
      // Example: fetch cleanURL content and update the page
    });
  });
});

