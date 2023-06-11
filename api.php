<?php
header('Content-Type: application/json; charset=utf8');

// Allow cross-origin requests
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

$koneksi = mysqli_connect("localhost", "root", "", "assesmen");

if ($_SERVER['REQUEST_METHOD'] === 'GET') { // Menampilkan Semua Data + Bisa lebih spesifik
    $sql = "SELECT * FROM userbase";
    $query = mysqli_query($koneksi, $sql);
    $array_data = array();
    while ($data = mysqli_fetch_assoc($query)) {
        $array_data[] = $data;
    }
    echo json_encode($array_data, JSON_PRETTY_PRINT);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') { // [POST] Menambahkan data + Use Body, x-www-form-urlencoded in Postman
    $id = $_POST['id_user']; // All Required since it's new data
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $sql = "INSERT INTO userbase (id, username, nama, email, gender) VALUES ('$id', '$username', '$nama', '$email', '$gender')";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "berhasil"
        ];
        echo json_encode($data, JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "tidak berhasil"
        ];
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') { // [DELETE] Id only + Use Param in Postman
    $id = $_GET['id_user'];
    $sql = "DELETE FROM userbase WHERE id = '$id'";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "berhasil"
        ];
        echo json_encode($data, JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "tidak berhasil"
        ];
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') { // [PUT] Use All + Use Params in Postman
    parse_str(file_get_contents("php://input"), $_PUT);
    $id = $_PUT['id_user_update'];
    $username = $_PUT['username_update'];
    $nama = $_PUT['nama_update'];
    $email = $_PUT['email_update'];
    $gender = $_PUT['gender_update'];

    $sql = "UPDATE userbase SET username = '$username', nama = '$nama', email = '$email', gender = '$gender' WHERE id = '$id'";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "berhasil"
        ];
        echo json_encode($data, JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "gagal"
        ];
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
}
?>
