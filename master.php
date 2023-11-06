<?php

include "koneksi.php";

// Menentukan metode request
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');

switch($method) {
    case 'GET':
        $sql = "SELECT * FROM wisata_semarang";
        $stmt = $pdo->query($sql);
        $wisata_semarang = $stmt->fetchAll();
        echo json_encode($pariwisata);
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->nama) && isset($data->lokasi) && isset($data->deskripsi)) {
            $sql = "INSERT INTO wisata_semarang (nama, lokasi, deskripsi) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->nama, $data->lokasi, $data->deskripsi]);
            echo json_encode(['message' => 'wisata_semarang berhasil ditambahkan']);
        } else {
            echo json_encode(['message' => 'Data tidak lengkap']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->id) && isset($data->nama) && isset($data->lokasi) && isset($data->deskripsi)) {
            $sql = "UPDATE pariwisata SET nama=?, lokasi=?, deskripsi=? WHERE id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->nama, $data->lokasi, $data->deskripsi, $data->id]);
            echo json_encode(['message' => 'pariwisata berhasil diperbarui']);
        } else {
            echo json_encode(['message' => 'Data tidak lengkap']);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        if(isset($data->id)) {
            $sql = "DELETE FROM pariwisata WHERE id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->id]);
            echo json_encode(['message' => 'pariwisata berhasil dihapus']);
        } else {
            echo json_encode(['message' => 'ID tidak ditemukan']);
        }
        break;

    default:
        echo json_encode(['message' => 'Metode tidak dikenali']);
        break;
}

?>
