<?php

ob_start();
print 'Date generated: ' . date('c') . "\n\n";
phpinfo();
$info = ob_get_clean();

$data = json_encode(
    [
        'public' => 'true',
        'files'  => [
            $argv[2] => ['content' => $info],
        ],
    ]
);

$url = 'https://api.github.com/gists/' . $argv[1];
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt(
    $ch,
    CURLOPT_HTTPHEADER,
    [
        'Content-Type: application/javascript',
        'Authorization: token ' . trim(file_get_contents(getenv('HOME') . '/.gist')),
        'User-Agent: php/curl',
    ]
);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);

print_r($result);
