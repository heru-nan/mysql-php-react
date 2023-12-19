<?php
include 'database.php';

function add_votos_info($alias, $candidato, $comoSeEntero, $email, $fullName, $rut)
{
    $pdo = Database::connect();
    $comoSeEnteroJson = json_encode($comoSeEntero);
    $sql = "INSERT INTO votos (alias, candidato, comoSeEntero, email, fullName, rut) VALUES ('{$alias}', '{$candidato}', '{$comoSeEnteroJson}', '{$email}', '{$fullName}', '{$rut}')";
    $status = [];

    try {
        $query = $pdo->prepare($sql);
        $result = $query->execute();
        if ($result) {
            $status['message'] = "Voto agregado exitosamente";
        } else {
            $status['message'] = "Data is not added";
        }

    } catch (PDOException $e) {
        $status['message'] = $e->getMessage();
    }

    Database::disconnect();
    return $status;
}

function check_existing_votos($rut)
{
    $pdo = Database::connect();
    $sql = "SELECT * FROM votos WHERE rut = :rut";
    $status = [];
    $status['exists'] = false;


    try {

        $query = $pdo->prepare($sql);
        $query->bindParam(':rut', $rut);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $status['exists'] = true;
            $status['message'] = "El Rut ya esta registrado";
            $status["error"] = true;
        }

    } catch (PDOException $e) {
        $status['message'] = $e->getMessage();
    }

    Database::disconnect();
    return $status;
}

function update_votos_info($id, $alias, $candidato, $comoSeEntero, $email, $fullName, $rut)
{
    $pdo = Database::connect();
    $comoSeEnteroJson = json_encode($comoSeEntero);
    $sql = "UPDATE votos SET alias = '{$alias}', candidato = '{$candidato}', comoSeEntero = '{$comoSeEnteroJson}', email = '{$email}', fullName = '{$fullName}', rut = '{$rut}' WHERE id = '{$id}'";
    $status = [];

    try {
        $query = $pdo->prepare($sql);
        $result = $query->execute();
        if ($result) {
            $status['message'] = "Data updated";
        } else {
            $status['message'] = "Data is not updated";
        }

    } catch (PDOException $e) {
        $status['message'] = $e->getMessage();
    }

    Database::disconnect();
    return $status;
}

function get_single_votos_info($id)
{
    $pdo = Database::connect();
    $sql = "SELECT * FROM votos WHERE id = '{$id}'";
    $votos_info = [];

    try {
        $query = $pdo->prepare($sql);
        $query->execute();
        $votos_info = $query->fetch(PDO::FETCH_ASSOC);
        $votos_info['comoSeEntero'] = json_decode($votos_info['comoSeEntero']);
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

    Database::disconnect();
    return $votos_info;
}

function get_all_votos_list()
{
    $pdo = Database::connect();
    $sql = "SELECT * FROM votos";
    $votos_list = [];

    try {
        $query = $pdo->prepare($sql);
        $query->execute();
        $votos_list = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($votos_list as $key => $votos) {
            $votos_list[$key]['comoSeEntero'] = json_decode($votos['comoSeEntero']);
        }
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

    Database::disconnect();
    return $votos_list;
}

function get_all_candidates_list()
{
    $pdo = Database::connect();
    $sql = "SELECT * FROM candidatos";
    $query = $pdo->prepare($sql);
    $query->execute();


    try {
        $candidates = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($candidates as $key => $candidate) {
            $candidates_list[$key]['nombre'] = $candidate['nombre'];
        }
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

    // echo $candidates_list;

    Database::disconnect();
    return $candidates_list;
}

?>