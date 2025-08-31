let currentSlide = 0; // Start with the first slide
const slides = document.querySelectorAll('.slide'); // Select all slides
const totalSlides = slides.length;

function showSlide(index) {
  slides.forEach((slide, i) => {
    slide.classList.remove('active'); // Remove 'active' from all slides
    if (i === index) {
      slide.classList.add('active'); // Add 'active' to the current slide
    }
  });
}

function nextSlide() {
  currentSlide = (currentSlide + 1) % totalSlides; // Loop back to the first slide after the last
  showSlide(currentSlide);
}

setInterval(nextSlide, 5000); // Change slide every 5 seconds

showSlide(currentSlide); // Show the first slide
