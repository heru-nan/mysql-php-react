<?php
include 'database.php';

function add_candidate_info($alias, $candidato, $comoSeEntero, $email, $fullName, $rut)
{
    $pdo = Database::connect();
    $comoSeEnteroJson = json_encode($comoSeEntero);
    $sql = "INSERT INTO candidates (alias, candidato, comoSeEntero, email, fullName, rut) VALUES ('{$alias}', '{$candidato}', '{$comoSeEnteroJson}', '{$email}', '{$fullName}', '{$rut}')";
    $status = [];

    try {
        $query = $pdo->prepare($sql);
        $result = $query->execute();
        if ($result) {
            $status['message'] = "Candidato agregado exitosamente";
        } else {
            $status['message'] = "Data is not added";
        }

    } catch (PDOException $e) {
        $status['message'] = $e->getMessage();
    }

    Database::disconnect();
    return $status;
}

function check_existing_candidate($rut)
{
    $pdo = Database::connect();
    $sql = "SELECT * FROM candidates WHERE rut = :rut";
    $status = [];
    $status['exists'] = false;


    try {

        $query = $pdo->prepare($sql);
        $query->bindParam(':rut', $rut);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $status['exists'] = true;
            $status['message'] = "El candidato ya existe";
            $status["error"] = true;
        }

    } catch (PDOException $e) {
        $status['message'] = $e->getMessage();
    }

    Database::disconnect();
    return $status;
}

function update_candidate_info($id, $alias, $candidato, $comoSeEntero, $email, $fullName, $rut)
{
    $pdo = Database::connect();
    $comoSeEnteroJson = json_encode($comoSeEntero);
    $sql = "UPDATE candidates SET alias = '{$alias}', candidato = '{$candidato}', comoSeEntero = '{$comoSeEnteroJson}', email = '{$email}', fullName = '{$fullName}', rut = '{$rut}' WHERE id = '{$id}'";
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

function get_single_candidate_info($id)
{
    $pdo = Database::connect();
    $sql = "SELECT * FROM candidates WHERE id = '{$id}'";
    $candidate_info = [];

    try {
        $query = $pdo->prepare($sql);
        $query->execute();
        $candidate_info = $query->fetch(PDO::FETCH_ASSOC);
        $candidate_info['comoSeEntero'] = json_decode($candidate_info['comoSeEntero']);
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

    Database::disconnect();
    return $candidate_info;
}

function get_all_candidate_list()
{
    $pdo = Database::connect();
    $sql = "SELECT * FROM candidates";
    $candidate_list = [];

    try {
        $query = $pdo->prepare($sql);
        $query->execute();
        $candidate_list = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($candidate_list as $key => $candidate) {
            $candidate_list[$key]['comoSeEntero'] = json_decode($candidate['comoSeEntero']);
        }
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

    Database::disconnect();
    return $candidate_list;
}
?>