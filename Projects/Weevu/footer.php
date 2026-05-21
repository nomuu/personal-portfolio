
<style>
  /* Make sure wave sits above content */
  .footer-wave svg {
    display: block;
  }
  </style>
  <!-- Wave SVG as top border -->
<div class="footer-wave" style="margin-bottom: -1px;">
  <svg viewBox="0 0 1440 100" preserveAspectRatio="none"
       xmlns="http://www.w3.org/2000/svg"
       style="display: block; width: 100%; height: 80px;">
    <!-- Flipped path -->
    <path fill="#212529" d="M1440,100 C1080,0 360,100 0,0 L0,100 L1440,100 Z"></path>
  </svg>
</div>

<footer class="bg-dark text-light py-4">
  <div class="container">
    <div class="row align-items-center">
      <!-- First Column: Logo -->
      <div class="col-md-4 mb-3 mb-md-0 text-center text-md-start">
        <img src="images/logo.png" alt="Logo" class="img-fluid" style="max-height: 80px;">
      </div>

      <!-- Second Column: Menu List -->
      <div class="col-md-4 mb-3 mb-md-0">
        <h5 class="mb-3">Menu</h5>
        <ul class="list-unstyled">
          <li><a href="index.php" class="text-white">Start Free Scan</a></li>
          <li><a href="#" onclick="showSection('home-services')" class="text-white">Services</a></li>
          <li><a href="#" onclick="showSection('documentation')" class="text-white">Documentation</a></li>
          <li><a href="#" onclick="showSection('contact')" class="text-white">Contact</a></li>
        </ul>
      </div>

      <!-- Third Column: Services List -->
      <div class="col-md-4">
        <h5 class="mb-3">Our Services</h5>
        <ul class="list-unstyled">
          <li><a href="#"  onclick="showSection('home-services')" class="text-white">One-Time Security Scan</a></li>
          <li><a href="#" onclick="showSection('home-services')" class="text-white">Scheduled Scan + Reports</a></li>
        </ul>
      </div>
    </div>

    <hr class="border-secondary mt-4">
    <div class="text-center small text-white-50">
      v1.0 &copy; <?php echo date("Y"); ?> Weevu by <a href="https://imronaldmendoza.com" class="text-white text-decoration-none">Ronald Fernandez Mendoza</a>. All rights reserved.
    </div>
  </div>
</footer>

<!-- Back to Top Button -->
<button id="backToTopBtn" type="button" 
  class="btn btn-primary rounded-circle" 
  style="position: fixed; bottom: 40px; left: 50%; transform: translateX(-50%);
         width: 45px; height: 45px; display: none; z-index: 1050;">
  &#8679;
</button>


<script>

  const backToTopBtn = document.getElementById('backToTopBtn');

  window.addEventListener('scroll', () => {
    if (window.scrollY > 200) {
      backToTopBtn.style.display = 'block';
    } else {
      backToTopBtn.style.display = 'none';
    }
  });

  backToTopBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
</script>
