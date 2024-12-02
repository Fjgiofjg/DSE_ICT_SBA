<?php
// Define the test function
/**
 * Sends a request to update the quantity of a product.
 *
 * @param string $url The URL to send the request to.
 * @param string $cookies The cookies to include in the request.
 */
function testUpdateQuantity($url, $cookies) {
    $ch = curl_init();

    // Set the URL and options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if (!empty($cookies)) {
        curl_setopt($ch, CURLOPT_COOKIE, $cookies);
    }

    // Execute the request
    $output = curl_exec($ch);

    // Check for errors
    if ($output === false) {
        echo "Curl error: " . curl_error($ch) . "\n";
    } else {
        echo "Request to $url was successful.\n";
    }

    // Close the handle
    curl_close($ch);
}

// Define the test cases
$baseUrl = 'http://localhost/updateQuantity.php';
// The cookie string used for authentication, format: 'key=value'
$cookie = 'uid=17181234'; // Replace with a valid user ID

// Test case 1: Increase quantity
testUpdateQuantity("$baseUrl?product=1314520&action=increase", $cookie);

// Test case 2: Decrease quantity
testUpdateQuantity("$baseUrl?product=1314520&action=decrease", $cookie);

// Test case 3: Invalid action
testUpdateQuantity("$baseUrl?product=1314520&action=invalid", $cookie);

// Test case 4: No action
testUpdateQuantity("$baseUrl?product=1314520", $cookie);

// Test case 5: No product ID
testUpdateQuantity("$baseUrl?action=increase", $cookie);

// Test case 6: No user cookie
testUpdateQuantity("$baseUrl?product=1314520&action=increase", '');

// Test case 7: Non-existent product ID
testUpdateQuantity("$baseUrl?product=999&action=increase", $cookie);

?>