<?php

function connect_db()
{
    $conn = oci_connect('system', 'oracle', 'localhost/XE', 'AL32UTF8');
    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    return $conn;
}
;

function getQuestions()
{
    if (!($conn = connect_db())) { // If we couldn't connect, then we return false.
        return false;
    }

    $stid = oci_parse($conn, 'SELECT k.kerdes, k.A_valasz, k.B_valasz, k.C_valasz, k.D_valasz, k.helyes_v, k.szint, ka.Nev
    FROM Kerdes k
    INNER JOIN tartalmaz t ON k.KeID = t.KeID
    INNER JOIN Kategoria ka ON t.KaID = ka.KaID');
    if (!$stid) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    oci_close($conn);
    return $stid;
}

function getCategory(){
    if (!($conn = connect_db())) { // If we couldn't connect, then we return false.
        return false;
    }

    $stid = oci_parse($conn, 'SELECT * FROM Kategoria');

    if (!$stid) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    oci_close($conn);
    return $stid;
}

function getStatistic(){
    if (!($conn = connect_db())) { // If we couldn't connect, then we return false.
        return false;
    }

    $stid = oci_parse($conn, 'SELECT nev, helyes_v_szam, megval_k_szam
    FROM Felhasznalo JOIN Statisztika ON Felhasznalo.FID = Statisztika.SID');

    if (!$stid) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    oci_close($conn);
    return $stid;
}
function questionAdd($K_Keid, $K_kerdes, $k_A, $k_B, $k_C, $k_D, $k_H, $k_szint) {
    $conn = connect_db();
    if (!$conn) {
        return false;
    }

    $stmt = oci_parse($conn, 'INSERT INTO Kerdes (KeID, kerdes, A_valasz, B_valasz, C_valasz, D_valasz, helyes_v, szint) VALUES (:1, :2, :3, :4, :5, :6, :7, :8)');
    if (!$stmt) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    oci_bind_by_name($stmt, ':1', $K_Keid);
    oci_bind_by_name($stmt, ':2', $K_kerdes);
    oci_bind_by_name($stmt, ':3', $k_A);
    oci_bind_by_name($stmt, ':4', $k_B);
    oci_bind_by_name($stmt, ':5', $k_C);
    oci_bind_by_name($stmt, ':6', $k_D);
    oci_bind_by_name($stmt, ':7', $k_H);
    oci_bind_by_name($stmt, ':8', $k_szint);

    $sikeres = oci_execute($stmt);
    if (!$sikeres) {
        $e = oci_error($stmt);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    oci_free_statement($stmt);
    oci_close($conn);

    return $sikeres;
}
function categoryAdd($K_Kaid, $K_nev) {
    $conn = connect_db();
    if (!$conn) {
        return false;
    }

    $stmt = oci_parse($conn, 'INSERT INTO kategoria (kaid, nev) VALUES  (:1, :2)');
    if (!$stmt) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    oci_bind_by_name($stmt, ':1', $K_Kaid);
    oci_bind_by_name($stmt, ':2', $K_nev);

    $sikeres = oci_execute($stmt);
    if (!$sikeres) {
        $e = oci_error($stmt);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    oci_free_statement($stmt);
    oci_close($conn);

    return $sikeres;
}

?>