<?php
include('functions.php');
header('content-type: application/json');

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $json = get_single_candidate_info($id);
        if (empty($json))
            header("HTTP/1.1 404 Not Found");
        echo json_encode($json);
    } else {
        $json = get_all_candidate_list();
        echo json_encode($json);
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);

    $alias = $data['alias'];
    $candidato = $data['candidato'];
    $comoSeEntero = $data['comoSeEntero'];
    $email = $data['email'];
    $fullName = $data['fullName'];
    $rut = $data['rut'];

    $existingCandidate = check_existing_candidate($rut);
    if ($existingCandidate['exists']) {
        unset($existingCandidate['exists']);
        echo json_encode($existingCandidate);
    } else {
        $json = add_candidate_info($alias, $candidato, $comoSeEntero, $email, $fullName, $rut);
        echo json_encode($json);
    }
}

if ($_SERVER['REQUEST_METHOD'] == "PUT") {
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id'];
    $alias = $data['alias'];
    $candidato = $data['candidato'];
    $comoSeEntero = $data['comoSeEntero'];
    $email = $data['email'];
    $fullName = $data['fullName'];
    $rut = $data['rut'];

    // Aquí necesitarías una función para actualizar la información del candidato
    // $json = update_candidate_info($id, $alias, $candidato, $comoSeEntero, $email, $fullName, $rut);
    // echo json_encode($json);
}