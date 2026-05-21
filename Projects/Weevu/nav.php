<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <!-- Brand / Logo -->
        <a class="navbar-brand" href="index.php">
            <img src="images/logo.png" alt="Weevu" height="40" class="d-inline-block align-text-top me-2">
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Nav Links and Login Button -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto me-3">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Start Free Scan</a>
                </li>

                <!-- Services Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Services
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="servicesDropdown">
                        <li><a class="dropdown-item" href="#" onclick="showSection('home-services')">One-Time Security Scan</a></li>
                        <li><a class="dropdown-item" href="#" onclick="showSection('home-services')">Scheduled Scan + Reports</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link"  href="#" onclick="showSection('documentation')">Documentation</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link"  href="#" onclick="showSection('contact')">Contact</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link"  href="#" onclick="showSection('faq')">FAQ</a>
                </li>
            </ul>

            <!-- Login with Google Button -->
            <a href="<?= $googleAuthUrl ?>" class="btn btn-outline-light btn-sm">
                Login with Google
            </a>
        </div>
    </div>
</nav>
<!-- Modal for Error Message -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="errorModalLabel">Permission Required</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if ($errorMessage): ?>
                    <p><strong><?= htmlspecialchars($errorMessage); ?></strong></p>

                    <p class="mt-3 mb-2">
                        Want access? It’s easy — just register for one of our Weevu services.
                    </p>

                    <p>
                        Our tools are built to help businesses stay secure and proactive:
                        <ul>
                            <li><strong>One-Time Security Scan</strong> — instantly uncover hidden vulnerabilities.</li>
                            <li><strong>Scheduled Scan + Report</strong> — automate monitoring and get monthly insights.</li>
                        </ul>
                    </p>
                    <hr>
                    <div class="text-center mt-4">
                        <a href="#" onclick="showSection('home-services')" class="btn btn-danger" data-bs-dismiss="modal">
                            Explore Services
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
