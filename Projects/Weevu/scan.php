<div class="container">
    <h5 class="mt-4">Security Report Summary</h5>
    <div class="card border shadow-sm mb-5 rounded-0">
        <div class="card-body p-4">
            <div class="row align-items-center">
<div class="col-md-3 text-center border-end">
    <div class="d-flex align-items-center justify-content-center mx-auto ratio ratio-1x1 <?php echo $gradeClass; ?>" 
         style="max-width: 140px;">
        <div class="d-flex align-items-center justify-content-center w-100 h-100">
            <span class="display-1 fw-bold text-white lh-1 m-0" style="line-height: 1;"><?php echo $grade; ?></span>
        </div>
    </div>
</div>
                <div class="col-md-9 ps-md-4">
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless align-middle mb-0">
                            <tr>
                                <th style="width: 150px;" class="text-muted fw-normal">Site:</th>
                                <td><a href="<?php echo htmlspecialchars($url); ?>" target="_blank" class="text-decoration-none fw-bold text-break"><?php echo htmlspecialchars($url); ?></a></td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-normal">IP Address:</th>
                                <td class="font-monospace text-secondary small"><?php echo $ip_address; ?></td>
                            </tr>
                            <tr>
                                <th class="text-muted fw-normal align-top pt-1">Required Headers:</th>
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        <?php foreach ($requiredResults as $res): ?>
                                            <span class="badge <?php echo $res['present'] ? 'bg-success' : 'bg-danger'; ?> rounded-1 px-2 py-1 small fw-medium">
                                                <?php echo $res['present'] ? '✓' : '✗'; ?> <?php echo htmlspecialchars($res['name']); ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h5 class="mt-4 text-primary">Required Security Headers</h5>
    <table class="table table-bordered result-table mb-5">
        <thead class="table-light">
            <tr>
                <th class="text-center" style="width:80px;">Status</th>
                <th>Header</th>
                <th>Value</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requiredResults as $res): ?>
                <tr>
                    <td class="text-center"><?php echo $res['present'] ? '✅' : '❌'; ?></td>
                    <td><strong><?php echo htmlspecialchars($res['name']); ?></strong></td>
                    <td class="text-break"><?php echo $res['value'] ? htmlspecialchars($res['value']) : 'N/A'; ?></td>
                    <td><?php echo $res['description']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h5 class="mt-4 text-secondary">Additional Security Headers</h5>
    <table class="table table-bordered result-table mb-5">
        <thead class="table-light">
            <tr>
                <th class="text-center" style="width:80px;">Status</th>
                <th>Header</th>
                <th>Value</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($additionalResults as $res): ?>
                <tr class="table-sm">
                    <td class="text-center"><?php echo $res['present'] ? '✅' : '⚪'; ?></td>
                    <td><strong><?php echo htmlspecialchars($res['name']); ?></strong></td>
                    <td class="text-break small"><?php echo $res['value'] ? htmlspecialchars($res['value']) : 'Not Set'; ?></td>
                    <td class="small"><?php echo $res['description']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h5 class="mt-5">SSL Certificate Info</h5>
    <table class="table table-bordered mb-5">
        <tbody>
            <?php foreach ($certInfo as $label => $value): ?>
                <tr>
                    <th class="bg-light" style="width: 200px;"><?php echo htmlspecialchars($label); ?></th>
                    <td class="text-break"><?php echo htmlspecialchars($value); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="mt-5 p-4 rounded shadow-sm text-center" style="background: linear-gradient(135deg, #e3f2fd, #bbdefb);">
        <h5 class="mb-3 fw-bold text-primary">Want deeper insights?</h5>
        <p class="mb-3 fs-5 text-dark">You've taken the first step toward a more secure website...</p>
        <p class="mb-4 fs-6 text-secondary">Explore our affordable security packages to ensure your site is protected...</p>
        <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
            <a href="#" onclick="showSection('home-services')" class="btn btn-primary btn-lg fw-semibold px-4 position-relative overflow-hidden">View Security Packages</a>
            <a href="#" onclick="showSection('contact')" class="btn btn-outline-primary btn-lg fw-semibold px-4">📩 Talk to Us</a>
        </div>
    </div>
</div>