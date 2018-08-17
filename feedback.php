<?php
function isv($is='', $a=false)
{
    if (isset($_POST[$is]) and !$a) {
        return $_POST[$is];
    } elseif (isset($_GET[$is])) {
        return $_GET[$is];
    }
    return false;
}
function sparkpost($method, $uri, $payload = [], $headers = [])
{
    $defaultHeaders = [ 'Content-Type: application/json' ];

    $curl = curl_init();
    $method = strtoupper($method);

    $finalHeaders = array_merge($defaultHeaders, $headers);

    $url = 'https://api.sparkpost.com:443/api/v1/'.$uri;

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    if ($method !== 'GET') {
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
    }

    curl_setopt($curl, CURLOPT_HTTPHEADER, $finalHeaders);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

$payload = [
    'options' => [
        'sandbox' => false,
    ],
    'content' => [
        'from' => [
            'name' => isv('name'),
            'email' => 'from@email.mohtasmbelah.com',
        ],
        'subject' => isv("subject"),
        'html' => '<html><body><p>'.isv("message").'</p></body></html>',
        "reply_to"=> isv('email')
    ],
    'recipients' => [
        [ 'address' => 'mohtasmsawilh1@gmail.com', ],
    ],
];
$headers = [ 'Authorization: 49a0ce53d4d1d95db780979dc2c22f2bac6f4346' ];
$email_results = sparkpost('POST', 'transmissions', $payload, $headers);
echo "email  is  sent !!";
