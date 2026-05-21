    <style>
        body {
            scroll-behavior: smooth;
        }
        .sidebar {
            position: sticky;
            top: 100px;
        }
        .sidebar a {
            text-decoration: none;
            color: #333;
            display: block;
            padding: 8px 0;
        }
        .sidebar a:hover {
            color: #0d6efd;
        }
        .active-link {
            font-weight: bold;
            color: #0d6efd;
        }
    </style>

<section id="documentation" class="py-5 bg-light content-section" style="display: none;">
<div class="container-fluid mt-4 mb-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 border-end">
            <nav class="sidebar py-3 px-3">
                <h5 class="mb-3">On this page</h5>
                <a href="#overview">Overview</a>
                <a href="#features">Key Features</a>
                <a href="#getting-started">Getting Started</a>
                <a href="#how-it-works">How It Works</a>
                <a href="#security">Security & Privacy</a>
                <a href="#support">Support</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 px-4">
            <div class="py-5">

                <section id="overview" class="mb-5  py-5">
                    <h2>Overview</h2>
                    <p><strong>Weevu</strong> is a lightweight and user-friendly website vulnerability scanner. It helps developers, administrators, and security testers identify common web vulnerabilities in their websites, ensuring better security and protection against threats. Weevu is designed to automate basic security checks to improve site safety without needing advanced tools or expertise.</p>
                </section>

                <section id="features" class="mb-5  py-5">
                    <h2>Key Features</h2>
                    <ul>
                        <li>Scan websites for common vulnerabilities like XSS, SQL Injection, and CSRF.</li>
                        <li>Provides a simple and intuitive interface for scanning.</li>
                        <li>Google SSO integration for secure access.</li>
                        <li>Detailed reports and summaries of detected issues.</li>
                    </ul>
                </section>

                <section id="getting-started" class="mb-5  py-5">
                    <h2>Getting Started</h2>
                    <ol>
                        <li>Log in using your Google account.</li>
                        <li>Enter the URL of the website you want to scan.</li>
                        <li>Click the "Scan" button to initiate the vulnerability test.</li>
                        <li>Review the results once the scan is completed.</li>
                    </ol>
                </section>

                <section id="how-it-works" class="mb-5  py-5">
                    <h2>How It Works</h2>
                    <p>Weevu performs a series of automated tests on your provided website URL. These include sending crafted requests and inspecting responses to detect potential vulnerabilities. Results are summarized in a user-friendly format to help you understand any weaknesses found.</p>
                </section>

                <section id="security" class="mb-5  py-5">
                    <h2>Security & Privacy</h2>
                    <p>All scans are initiated by authenticated users through Google SSO, ensuring controlled access. Weevu does not store or share any scanned website data beyond the session scope. Your privacy and data integrity are our top priorities.</p>
                </section>

                <section id="support" class="mb-5  py-5">
                    <h2>Support</h2>
                    <p>For any issues, feature requests, or bug reports, please contact the development team through the support email or via the feedback form available in your account dashboard.</p>
                </section>
            </div>
        </div>
    </div>
</div>
</section>
