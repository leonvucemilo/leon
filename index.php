<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/leon/auth') {
    $post_data = json_decode(file_get_contents('php://input'), true);

    if (isset($post_data['secret']) && $post_data['secret'] === $secret_code) {
        // Autorizacija je uspješna, generiranje tokena i spremanje u bazu
        $token = generate_token();
		$sql = "INSERT INTO tokens (token) VALUES ('$token')";
		$conn->query($sql);

        // Pošalji token kao odgovor
        http_response_code(200);
        header('Content-Type: application/json');
        echo json_encode(['token' => $token]);
        exit;
    } else {
		// Autorizacija nije uspješna
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && strpos($_SERVER['REQUEST_URI'], '/leon/voucher/get') === 0) {
    $headers = getallheaders();

    if (isset($headers['Authorization']) && strpos($headers['Authorization'], 'Bearer ') === 0) {
        $token = substr($headers['Authorization'], 7); // Dohvati token

        // Provjera je li token važeći, ako jest dohvati voucher
        if (is_token_valid($token)) {
            $voucher_provider = $_GET['voucher_provider'];
            $voucher_amount = $_GET['voucher_amount'];

            $voucher = get_voucher($voucher_provider, $voucher_amount);

            if ($voucher) {
                http_response_code(200);
                header('Content-Type: application/json');
                echo json_encode($voucher);
                exit;
            } else {
                http_response_code(422);
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Unprocessable entity']);
                exit;
            }
        }
    }

    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Unauthorized']);
    exit;
} else {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Not Found']);
    exit;
}

function generate_token() {
    global $conn;

    do {
        $token = bin2hex(random_bytes(16)); // Generiranje string-a, random unique value

        // Provjeri je li token već prisutan u bazi
        $check_token = "SELECT * FROM tokens WHERE token = '$token'";
        $result = $conn->query($check_token);
    } while ($result->num_rows > 0);

    return $token;
}

function is_token_valid($token) {
	global $conn;
    // Provjera je li token važeći
	$token = $conn->real_escape_string($token);
    $check_token = "SELECT * FROM tokens WHERE token = '$token' AND is_used = 0";
    $result = $conn->query($check_token);

    if ($result->num_rows > 0) {
        // Ako je token važeći i nije korišten, označi ga kao korištenog i 
        $conn->query("UPDATE tokens SET is_used = 1 WHERE token = '$token'");
        return true;
    }
    return false;
}

function get_voucher($provider, $amount) {
	global $conn;
    //Dohvaćanje vouchera iz baze podataka, provjeri je li važeći i je li iskorišten
    $provider = $conn->real_escape_string($provider);
    $amount = (float) $conn->real_escape_string($amount);

    $sql = "SELECT * FROM vouchers WHERE voucher_provider = '$provider' AND voucher_amount = $amount AND is_used = 0 AND expires_at > NOW() LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
		$voucher_number = $row["voucher_number"];
        $conn->query("UPDATE vouchers SET is_used = 1 WHERE voucher_number = '$voucher_number'");

		//Ispis vouchera
        return [
            "voucher_number" => $row["voucher_number"],
            "expires_at" => $row["expires_at"]
        ];
    } else {
        return null;
    }
}
?>