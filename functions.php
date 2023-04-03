<?php

function connect_db()
{
    $conn = oci_connect('VARGA', 'varga', 'localhost/XE', 'AL32UTF8');
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

    // $stid = oci_parse($conn, 'SELECT * FROM Kerdes');
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

?>