// Counter Animation
document.addEventListener('scroll', () => {
    const counters = document.querySelectorAll('.counter');
    const speed = 150; // Adjust the speed of counting
  
    counters.forEach(counter => {
      const updateCount = () => {
        const target = +counter.getAttribute('data-target');
        const count = +counter.innerText;
        const increment = target / speed;
  
        if (count < target) {
          counter.innerText = Math.ceil(count + increment);
          setTimeout(updateCount, 15);
        } else {
          counter.innerText = target;
        }
      };
  
      const sectionPosition = counter.getBoundingClientRect().top;
      const screenHeight = window.innerHeight;
  
      if (sectionPosition < screenHeight && counter.innerText === "0") {
        updateCount();
      }
    });
  });
  