
        <?php
        // Your PHP scanning code untouched
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
            $securityHeaders = [
                'Strict-Transport-Security' => 'Helps to enforce secure (HTTPS) connections.',
                'Content-Security-Policy' => 'Prevents cross-site scripting and other code injection attacks.',
                'X-Content-Type-Options' => 'Prevents MIME-sniffing.',
                'X-Frame-Options' => 'Protects against clickjacking.',
                'X-XSS-Protection' => 'Enables cross-site scripting filters.',
                'Referrer-Policy' => 'Controls how much referrer information should be included.',
                'Permissions-Policy' => 'Controls access to browser features.'
            ];
            $results = [];
            foreach ($securityHeaders as $header => $desc) {
                $value = isset($headers[$header]) ? (is_array($headers[$header]) ? implode(", ", $headers[$header]) : $headers[$header]) : null;
                $results[] = [
                    'name' => $header,
                    'value' => $value,
                    'present' => $value ? true : false,
                    'description' => $desc
                ];
            }
            return $results;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $input = $_POST['website'];
            $url = normalizeUrl($input);
            $host = parse_url($url, PHP_URL_HOST);
            echo "<h4>🔍 Scanning: <code>$url</code></h4>";
            $headers = getHeadersWithStatus($url);
            $headerResults = checkHeaders($headers);
            $certInfo = getCertificateDetails($host);
        ?>
            <h5 class="mt-4">🛡️ Security Headers</h5>
            <table class="table table-bordered result-table">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width:80px;">Status</th>
                        <th>Header</th>
                        <th>Value</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($headerResults as $res): ?>
                        <tr>
                            <td class="text-center fs-4">
                                <?php echo $res['present'] ? '✅' : '❌'; ?>
                            </td>
                            <td><strong><?php echo htmlspecialchars($res['name']); ?></strong></td>
                            <td><?php echo $res['value'] ? htmlspecialchars($res['value']) : 'N/A'; ?></td>
                            <td><?php echo htmlspecialchars($res['description']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h5 class="mt-5">🔐 SSL Certificate Info</h5>
            <table class="table table-bordered">
                <tbody>
                    <?php foreach ($certInfo as $label => $value): ?>
                        <tr>
                            <th><?php echo htmlspecialchars($label); ?></th>
                            <td><?php echo htmlspecialchars($value); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php
        }
        ?>