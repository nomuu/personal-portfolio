<section id="home-services" class="py-5 bg-light content-section" style="display: none;">
  <div class="container py-5">
    <h2 class="mb-4 text-center">Choose Your Security Service</h2>
    <div class="row">

      <!-- Left side: Services -->
      <div class="col-md-6">
        <div class="home-services-atm-card standard mb-4" data-name="One-Time Security Scan" data-price="150">
          <div class="card-header">
            <div class="brand-name">Weevu</div>
            <div class="service-level">Standard</div>
          </div>
          <div class="card-bottom">
            <div class="price"><p class="fs-1">PHP 150</p><small>Monthly</small></div>
            <div class="service-name">One-Time Security Scan</div>
          </div>
        </div>

        <div class="home-services-atm-card premium" data-name="Scheduled Scan + Report" data-price="350">
          <div class="card-header">
            <div class="brand-name">Weevu</div>
            <div class="service-level">Premium</div>
          </div>
          <div class="card-bottom">
            <div class="price"><p class="fs-1">PHP 350</p><small>Monthly</small></div>
            <div class="service-name">Scheduled Scan + Report</div>
          </div>
        </div>
      </div>

      <!-- Right side: Billing panel -->
      <div class="col-md-6">
        <div id="home-services-billing-panel" class="p-4 bg-white border rounded shadow-sm" style="opacity: 1; transform: translateY(0); transition: 0.3s;">
          
          <!-- Placeholder before selection -->
          <div id="home-services-billing-default" class="text-muted">
            <h4 class="text-primary mb-3">🔐 Welcome to <strong>Weevu Security Services</strong></h4>
            <p>Protect your online presence with our expert-led vulnerability scans. Whether you’re a business owner, developer, or organization, Weevu offers reliable, efficient, and affordable scanning solutions tailored to your needs.</p>
            <hr>
            <h5 class="text-dark">📦 Our Services</h5>
            <p><strong>1. One-Time Security Scan</strong> – Best for quick, deep security insight</p>
            <ul>
              <li>✔️ Full protocol encryption analysis</li>
              <li>✔️ Vulnerability and threat assessment</li>
              <li>✔️ PDF report with detailed findings</li>
              <li>✔️ Ideal for system audits, app launch prep, or compliance checks</li>
            </ul>
            <p class="mt-4"><strong>2. Scheduled Scan + Email Reports</strong> – Best for ongoing protection</p>
            <ul>
              <li>✔️ Weekly or Monthly automatic scans</li>
              <li>✔️ Email notifications with summary + PDF report</li>
              <li>✔️ No need to manually request each scan</li>
              <li>✔️ Great for continuously updated systems and web apps</li>
            </ul>
            <hr>
            <p class="text-center text-muted small">
              Click any of the cards on the left to see pricing and billing details.
            </p>
          </div>

          <!-- Actual billing details -->
          <div id="home-services-billing-details" style="display: none;">
            <h5 class="mb-3">Billing Summary</h5>
            <p><strong>Selected Service:</strong> <span id="home-services-billing-name" class="text-primary">—</span></p>
            <p><strong>Total Amount:</strong> PHP <span id="home-services-billing-price" class="text-success">—</span></p>
            <div id="home-services-billing-includes" class="mt-3"></div>
            <hr>

            <!-- GCash QR Code (only shows for Standard) -->
            <div id="gcash-qr" class="text-center" style="display: none;">
              <p class="mt-3 mb-2"><strong>Pay via GCash</strong></p>
              <img src="images/weevu-qr-150.jpg" alt="GCash QR for PHP 150" style="max-width: 200px; border: 1px solid #ccc; border-radius: 10px;">
              <p class="text-muted small mt-2">Scan the QR code using your GCash app. The amount is pre-filled.</p>
            </div>

            <!-- Manual Proof of Payment Upload -->
            <div id="payment-proof-upload" class="mt-3">
              <label for="proofFile" class="form-label">Upload proof of payment:</label>
              <input type="file" id="proofFile" accept="image/*,application/pdf" class="form-control" />
              <button id="uploadProofBtn" class="btn btn-success w-100 mt-3" disabled>Upload Proof of Payment</button>
              <p id="uploadStatus" class="text-success mt-2" style="display:none;">Thank you! Your proof has been uploaded. We will verify your payment shortly.</p>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<script>
  const serviceCards = document.querySelectorAll('#home-services .home-services-atm-card');
  const billingName = document.getElementById('home-services-billing-name');
  const billingPrice = document.getElementById('home-services-billing-price');
  const billingIncludes = document.getElementById('home-services-billing-includes');
  const billingDetails = document.getElementById('home-services-billing-details');
  const defaultMessage = document.getElementById('home-services-billing-default');
  const gcashQR = document.getElementById('gcash-qr');

  const proofFileInput = document.getElementById('proofFile');
  const uploadProofBtn = document.getElementById('uploadProofBtn');
  const uploadStatus = document.getElementById('uploadStatus');

  const serviceDescriptions = {
    'One-Time Security Scan': `
      <p class="mb-1 text-muted">Scan additional layers like protocol encryption and other vulnerabilities. Includes a downloadable report.</p>
      <ul class="mb-0">
        <li>✅ Protocol encryption scan</li>
        <li>✅ Additional vulnerability assessment</li>
        <li>✅ Downloadable detailed report</li>
      </ul>
    `,
    'Scheduled Scan + Report': `
      <p class="mb-1 text-muted">Schedule weekly or monthly scans with downloadable reports or email notification reports.</p>
      <ul class="mb-0">
        <li>✅ Weekly or monthly scheduled scans</li>
        <li>✅ Downloadable or email reports</li>
        <li>✅ Automated scan notifications</li>
      </ul>
    `
  };

  serviceCards.forEach(card => {
    card.addEventListener('click', () => {
      serviceCards.forEach(c => c.classList.remove('active'));
      card.classList.add('active');

      const name = card.getAttribute('data-name');
      const price = card.getAttribute('data-price');

      billingName.textContent = name;
      billingPrice.textContent = price;
      billingIncludes.innerHTML = serviceDescriptions[name] || '';

      billingDetails.style.display = 'block';
      defaultMessage.style.display = 'none';

      // Show QR only if PHP 150 is selected
      if (price === '150') {
        gcashQR.style.display = 'block';
      } else {
        gcashQR.style.display = 'none';
      }
    });
  });

  // Enable upload button only if a file is selected
  proofFileInput.addEventListener('change', () => {
    uploadProofBtn.disabled = !proofFileInput.files.length;
    uploadStatus.style.display = 'none';
  });

  uploadProofBtn.addEventListener('click', () => {
    // Here you will handle the file upload to server
    // For demo, just simulate upload success:
    if(proofFileInput.files.length){
      // TODO: Implement actual upload to backend via AJAX/fetch
      uploadStatus.style.display = 'block';
      uploadProofBtn.disabled = true;
      proofFileInput.value = ''; // reset input
    }
  });
</script>
