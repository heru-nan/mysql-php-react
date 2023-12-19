<?php
include('functions.php');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('content-type: application/json');

if ($_SERVER['REQUEST_METHOD'] == "GET" && $_SERVER['REQUEST_URI'] != "/candidatos") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $json = get_single_votos_info($id);
        if (empty($json))
            header("HTTP/1.1 404 Not Found");
        echo json_encode($json);
    } else {
        $json = get_all_votos_list();
        echo json_encode($json);
    }
}

if ($_SERVER['REQUEST_METHOD'] == "GET" && $_SERVER['REQUEST_URI'] == "/candidatos") {
    $candidates = get_all_candidates_list();
    echo json_encode($candidates);
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);

    $alias = $data['alias'];
    $candidato = $data['candidato'];
    $comoSeEntero = $data['comoSeEntero'];
    $email = $data['email'];
    $fullName = $data['fullName'];
    $rut = $data['rut'];

    $existingvotos = check_existing_votos($rut);
    if ($existingvotos['exists']) {
        unset($existingvotos['exists']);
        echo json_encode($existingvotos);
    } else {
        $json = add_votos_info($alias, $candidato, $comoSeEntero, $email, $fullName, $rut);
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
    // $json = update_votos_info($id, $alias, $candidato, $comoSeEntero, $email, $fullName, $rut);
    // echo json_encode($json);
}

