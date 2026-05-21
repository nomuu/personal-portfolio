<section id="home" class="position-relative overflow-hidden text-white py-5 content-section">
  <!-- Video Background -->
  <video autoplay muted loop playsinline class="position-absolute w-100 h-100 object-fit-cover z-n1">
    <source src="images/home-bg.mp4" type="video/mp4">
    Your browser does not support the video tag.
  </video>

  <!-- Dark Overlay -->
  <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-75 z-0"></div>

  <!-- Content -->
  <div class="container py-5 position-relative">
    <div class="text-center mb-5 pe-5">
      <br><br>
      <h1 class="display-4 fw-bold">Your Website’s Safety<br>Check Starts Here.</h1>
      <p class="lead text-white mt-3">
        Protect your website effortlessly. Simply enter your URL below to instantly check for critical security headers and SSL certificate details. <br>Get clear insights that help safeguard your site against common vulnerabilities — absolutely free.
      </p>
    </div>

    <!-- Scan Form -->
    <form method="post" class="mb-5" id="freescan">
      <div class="input-group" id="scan-form-group">
        <input
          type="text"
          name="website"
          class="form-control"
          placeholder="Enter website URL (e.g. example.com)"
          required
        />
        <button class="btn btn-primary" type="submit">Start Security Scan</button>
      </div>
    </form>

    <!-- Loading Spinner with Step-by-Step Messages -->
    <div id="scan-loading" class="text-center mt-4" style="display: none;">
      <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;">
        <span class="visually-hidden">Scanning...</span>
      </div>
      <p id="scan-message" class="mt-3 text-white">Initializing scan...</p>
    </div>

  </div>
</section>

<script>
  document.getElementById('freescan').addEventListener('submit', function (e) {
    const loading = document.getElementById('scan-loading');
    const message = document.getElementById('scan-message');
    const urlInput = document.querySelector('input[name="website"]');
    const domain = urlInput.value.trim();

    // 👉 Hide form input and button
    document.getElementById('scan-form-group').style.display = 'none';

    const steps = [
      `Checking "${domain}" availability...`,
      `Scanning security headers...`,
      `Scanning SSL certificate...`,
      `Finalizing...`
    ];

    let stepIndex = 0;
    loading.style.display = 'block';
    message.textContent = steps[stepIndex];

    e.preventDefault();

    const delayMs = Math.floor(Math.random() * (10000 - 5000 + 1)) + 5000;

    const interval = setInterval(() => {
      stepIndex++;
      if (stepIndex < steps.length) {
        message.textContent = steps[stepIndex];
      }
    }, delayMs / steps.length);

    setTimeout(() => {
      clearInterval(interval);
      this.submit();
    }, delayMs);
  });
</script>

<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    function urlExists($url) {
        $headers = @get_headers($url);
        return $headers && strpos($headers[0], '200') !== false;
    }

    function normalizeUrl($input) {
        $input = trim($input);
        $input = preg_replace('#^https?://#i', '', $input);
        $https = 'https://' . $input;
        if (urlExists($https)) return $https;
        $http = 'http://' . $input;
        if (urlExists($http)) return $http;
        return $https;
    }

    function getHeadersWithStatus($url) {
        $headers = @get_headers($url, 1);
        return $headers ?: [];
    }

    function getCertificateDetails($host) {
        $output = [];
        $cmd = "echo | openssl s_client -servername $host -connect $host:443 2>/dev/null | openssl x509 -noout -issuer -subject -dates";
        exec($cmd, $output);
        $certInfo = [
            "Issuer" => "N/A",
            "Subject" => "N/A",
            "Valid From" => "N/A",
            "Valid To" => "N/A"
        ];
        foreach ($output as $line) {
            if (strpos($line, 'issuer=') === 0) $certInfo["Issuer"] = trim(str_replace('issuer=', '', $line));
            elseif (strpos($line, 'subject=') === 0) $certInfo["Subject"] = trim(str_replace('subject=', '', $line));
            elseif (strpos($line, 'notBefore=') === 0) $certInfo["Valid From"] = trim(str_replace('notBefore=', '', $line));
            elseif (strpos($line, 'notAfter=') === 0) $certInfo["Valid To"] = trim(str_replace('notAfter=', '', $line));
        }
        return $certInfo;
    }

function checkHeaders($headers) {
    $lowercasedHeaders = array_change_key_case($headers, CASE_LOWER);

    // 1. Required Headers (Gagamitin sa Grading)
    $requiredHeaders = [
        'strict-transport-security' => 'Strict-Transport-Security',
        'content-security-policy'   => 'Content-Security-Policy',
        'x-content-type-options'    => 'X-Content-Type-Options',
        'x-frame-options'           => 'X-Frame-Options',
        'referrer-policy'           => 'Referrer-Policy'
    ];

    // 2. Additional Headers (Hindi kasali sa Grading)
    $additionalHeaders = [
        'x-xss-protection'          => 'X-XSS-Protection',
        'permissions-policy'        => 'Permissions-Policy',
        'expect-ct'                 => 'Expect-CT',
        'cross-origin-opener-policy' => 'Cross-Origin-Opener-Policy'
    ];

$descriptions = [
    'strict-transport-security' => 'Enforces secure (HTTPS) connections. <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Strict-Transport-Security" target="_blank" class="text-decoration-none small">Learn more &raquo;</a>',
    'content-security-policy'   => 'Prevents cross-site scripting and injection attacks. <a href="https://owasp.org/www-project-secure-headers/#content-security-policy" target="_blank" class="text-decoration-none small">Learn more &raquo;</a>',
    'x-content-type-options'    => 'Prevents MIME-sniffing vulnerabilities. <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Content-Type-Options" target="_blank" class="text-decoration-none small">Learn more &raquo;</a>',
    'x-frame-options'           => 'Protects against clickjacking attacks. <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options" target="_blank" class="text-decoration-none small">Learn more &raquo;</a>',
    'referrer-policy'           => 'Controls how much referrer information is shared. <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Referrer-Policy" target="_blank" class="text-decoration-none small">Learn more &raquo;</a>',
    'x-xss-protection'          => 'Legacy header to filter XSS (Cross-Site Scripting). <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-XSS-Protection" target="_blank" class="text-decoration-none small">Learn more &raquo;</a>',
    'permissions-policy'        => 'Controls access to browser features (e.g., camera, mic). <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Permissions-Policy" target="_blank" class="text-decoration-none small">Learn more &raquo;</a>',
    'expect-ct'                 => 'Enforces Certificate Transparency to prevent misissued certs. <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Expect-CT" target="_blank" class="text-decoration-none small">Learn more &raquo;</a>',
    'cross-origin-opener-policy' => 'Isolates browsing context to prevent cross-origin leaks. <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cross-Origin-Opener-Policy" target="_blank" class="text-decoration-none small">Learn more &raquo;</a>'
];

    $requiredResults = [];
    $additionalResults = [];

    // Process Required
    foreach ($requiredHeaders as $lowerKey => $prettyName) {
        $value = isset($lowercasedHeaders[$lowerKey]) ? $lowercasedHeaders[$lowerKey] : null;
        if (is_array($value)) $value = implode(", ", $value);
        $requiredResults[] = [
            'name' => $prettyName,
            'value' => $value,
            'present' => !is_null($value),
            'description' => $descriptions[$lowerKey] ?? ''
        ];
    }

    // Process Additional
    foreach ($additionalHeaders as $lowerKey => $prettyName) {
        $value = isset($lowercasedHeaders[$lowerKey]) ? $lowercasedHeaders[$lowerKey] : null;
        if (is_array($value)) $value = implode(", ", $value);
        $additionalResults[] = [
            'name' => $prettyName,
            'value' => $value,
            'present' => !is_null($value),
            'description' => $descriptions[$lowerKey] ?? ''
        ];
    }

    return ['required' => $requiredResults, 'additional' => $additionalResults];
}

// --- Execute scan ---
$input = $_POST['website'];
$url = normalizeUrl($input);
$host = parse_url($url, PHP_URL_HOST);
$headers = getHeadersWithStatus($url);

$allHeaderResults = checkHeaders($headers);
$requiredResults = $allHeaderResults['required'];
$additionalResults = $allHeaderResults['additional'];

$certInfo = getCertificateDetails($host);
$ip_address = gethostbyname($host);

// --- New Grading Logic (Required Only) ---
$totalRequired = count($requiredResults);
$presentRequired = 0;
foreach ($requiredResults as $res) {
    if ($res['present']) $presentRequired++;
}

if ($presentRequired === $totalRequired) {
    $grade = "A+";
    $gradeClass = "bg-success";
} elseif ($presentRequired >= 4) {
    $grade = "A";
    $gradeClass = "bg-success";
} elseif ($presentRequired >= 3) {
    $grade = "B";
    $gradeClass = "bg-warning text-dark";
} else {
    $grade = "F";
    $gradeClass = "bg-danger";
}
    ?>

<section id="scan-result" class="py-5 content-section" style="background-color: #f8f9fa;">
<?php require 'scan.php'; ?>
</section>

<?php } ?>
