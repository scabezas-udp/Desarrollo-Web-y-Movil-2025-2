<?php
function getApiData(string $url, string $bearerToken): ?array
{
    // Set up the HTTP headers for the request.
    $options = [
        'http' => [
            'method' => 'GET',
            'header' => "Authorization: Bearer " . $bearerToken . "\r\n" .
                        "Accept: application/json\r\n"
        ]
    ];

    // Create a stream context with the specified options.
    $context = stream_context_create($options);

    // Make the request and get the response.
    $response = @file_get_contents($url, false, $context);

    // Check if the request failed.
    if ($response === false) {
        return null;
    }

    // Decode the JSON response into an associative array.
    $data = json_decode($response, true);

    // Check for JSON decoding errors.
    if (json_last_error() !== JSON_ERROR_NONE) {
        return null;
    }

    return $data;
}
?>