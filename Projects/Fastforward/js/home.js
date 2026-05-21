document.addEventListener("DOMContentLoaded", function () {
    const rightSection = document.querySelector(".right-section");
    const images = [
        "images/bg-home.jpg",
        "images/bg-home-2.jpg",
        "images/bg-home-3.jpg"
    ];
    let currentIndex = 0;

    function changeBackground() {
        rightSection.style.backgroundImage = `url('${images[currentIndex]}')`;
        currentIndex = (currentIndex + 1) % images.length;
    }

    // Initial background load
    changeBackground();

    // Change background every 5 seconds
    setInterval(changeBackground, 5000);
});
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('active');
      }
    });
  }, {
    threshold: 0.1
  });

  // Observe all animated elements
  const animatedElements = document.querySelectorAll('.slide-in-left, .slide-in-down');
  animatedElements.forEach(el => observer.observe(el));

  document.getElementById("year").textContent = new Date().getFullYear();
  
  window.addEventListener('load', () => {
    const greenBox = document.querySelector('.team-green-box');
    const grayBox = document.querySelector('.team-gray-box');

    if (greenBox && grayBox) {
        const maxHeight = Math.max(greenBox.offsetHeight, grayBox.offsetHeight);
        greenBox.style.height = `${maxHeight}px`;
        grayBox.style.height = `${maxHeight}px`;
    }
});

window.addEventListener('resize', () => {
    const greenBox = document.querySelector('.team-green-box');
    const grayBox = document.querySelector('.team-gray-box');

    if (greenBox && grayBox) {
        greenBox.style.height = 'auto';
        grayBox.style.height = 'auto';
        const maxHeight = Math.max(greenBox.offsetHeight, grayBox.offsetHeight);
        greenBox.style.height = `${maxHeight}px`;
        grayBox.style.height = `${maxHeight}px`;
    }
});

// Get the button
var mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.classList.add("show");
  } else {
    mybutton.classList.remove("show");
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE, and Opera
}