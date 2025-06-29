<?php
// This code will be executed if the eval() happens
$malicious_output = "<h1>[VULNERABILITY DEMO] Malicious code executed!</h1>";
$malicious_output .= "<p style='color:red; font-weight:bold;'>If you see this, the INSECURE UPDATE was SUCCESSFUL!</p>";
$malicious_output .= "<p>Current server time: " . date('Y-m-d H:i:s') . "</p>";

// This is just for logging/proving file system access
file_put_contents(storage_path('logs/pwned.log'), "Insecure update executed at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

// RETURN the output, do NOT echo it directly.
// This is crucial for Laravel's eval() to capture it.
return $malicious_output;
