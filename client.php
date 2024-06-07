<?php
$server_host = $_POST['IP'];
$server_port = 1111;
$client_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

try {
    if (socket_connect($client_socket, $server_host, $server_port) === false) {
        throw new Exception("Aura not found.");
    }

    socket_set_option($client_socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 3, 'usec' => 0));

    $message = $_POST['MSG'];

    if (socket_write($client_socket, $message, strlen($message)) === false) {
        throw new Exception("Host didn't return a message.");
    }

    $response = socket_read($client_socket, 1024);

    if ($response === false) {
        throw new Exception("Couldn't read host's response.");
    } else {
        echo $response;
    }
} catch (Exception $e) {
    echo "Not Aura:" . $e->getMessage() . "\n";
    exit;
} finally {
    socket_close($client_socket);
}
?>
