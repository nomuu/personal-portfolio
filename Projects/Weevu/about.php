<section id="about" class="py-5 bg-white content-section">
  <div class="container">
    <div class="mb-5">
      <h2 class="fw-bold">About Web Vulnerabilities</h2>
      <p class="lead text-muted">
        Understanding web vulnerabilities is essential for building secure applications. Below is a detailed overview of common security threats.
      </p>
    </div>

    <div class="vulnerability-list">
      
      <div class="row py-4 border-bottom align-items-start">
        <div class="col-md-3">
          <h5 class="fw-bold text-danger">SQL Injection</h5>
          <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill small">High Risk</span>
        </div>
        <div class="col-md-9">
          <p class="text-secondary mb-0">
            Attackers inject malicious SQL queries into input fields to manipulate or access the database illegally. This can lead to unauthorized access to sensitive data like user credentials, personal information, or even the deletion of entire databases.
          </p>
        </div>
      </div>

      <div class="row py-4 border-bottom align-items-start">
        <div class="col-md-3">
          <h5 class="fw-bold text-warning text-dark">Cross-Site Scripting</h5>
          <span class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25 rounded-pill small">Medium to High</span>
        </div>
        <div class="col-md-9">
          <p class="text-secondary mb-0">
            Malicious scripts are injected into trusted websites. When a user visits the affected page, the script executes in their browser, allowing attackers to steal session cookies, hijack accounts, or deface the website.
          </p>
        </div>
      </div>

      <div class="row py-4 border-bottom align-items-start">
        <div class="col-md-3">
          <h5 class="fw-bold text-primary">CSRF</h5>
          <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill small">Medium Risk</span>
        </div>
        <div class="col-md-9">
          <p class="text-secondary mb-0">
            Cross-Site Request Forgery tricks an authenticated user into submitting a request they did not intend to make. This can result in unauthorized actions like changing passwords or transferring funds without the user's knowledge.
          </p>
        </div>
      </div>

      <div class="row py-4 border-bottom align-items-start">
        <div class="col-md-3">
          <h5 class="fw-bold text-dark">Broken Authentication</h5>
          <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill small">Critical</span>
        </div>
        <div class="col-md-9">
          <p class="text-secondary mb-0">
            Occurs when application functions related to authentication and session management are implemented incorrectly. Attackers can compromise passwords, keys, or session tokens to assume other users' identities.
          </p>
        </div>
      </div>

      <div class="row py-4 align-items-start"> <div class="col-md-3">
          <h5 class="fw-bold text-info">Misconfiguration</h5>
          <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 rounded-pill small">Variable Risk</span>
        </div>
        <div class="col-md-9">
          <p class="text-secondary mb-0">
            Inadequate security settings, such as default credentials, unnecessary open ports, or detailed error messages that reveal system information, can be exploited to gain unauthorized access.
          </p>
        </div>
      </div>

    </div>
  </div>
</section>