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
function getSuccesrate($session){
    $conn = connect_db();
    if (!$conn) {
        die("Sikertelen kapcsolódás az adatbázishoz.");
    }

    $stid = oci_parse($conn, 'SELECT get_success_rate(s.sid) as success_rate FROM felhasznalo f, statisztika s, statisztikaja st WHERE f.fid = :1 AND st.sid = s.sid AND st.fid = f.fid');
    oci_bind_by_name($stid, ":1", $session);
    var_dump($session);
    oci_execute($stid);

    $result = oci_fetch_array($stid, OCI_ASSOC);

    oci_free_statement($stid);
    oci_close($conn);

    return number_format($result['SUCCESS_RATE'], 2);;
}
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

function getCategory()
{
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

function getStatistic()
{
    if (!($conn = connect_db())) { // If we couldn't connect, then we return false.
        return false;
    }

    $stid = oci_parse($conn, 'SELECT Felhasznalo.nev, Statisztika.helyes_v_szam, Statisztika.megval_k_szam
    FROM Statisztika
    INNER JOIN Felhasznalo ON Statisztika.SID = Felhasznalo.FID
    ORDER BY Statisztika.helyes_v_szam DESC');

    // $stid = oci_parse($conn, 'SELECT nev, helyes_v_szam, megval_k_szam
    // FROM Felhasznalo JOIN Statisztika ON Felhasznalo.FID = Statisztika.SID');

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

function questionAdd($K_kaid,$K_kerdes, $k_A, $k_B, $k_C, $k_D, $k_H, $k_szint){
    $conn = connect_db();
    if (!$conn) {
        return false;
    }

    // Lekérjük a következő szabad KeID értéket
    $stmt = oci_parse($conn, 'SELECT KeID FROM (
                                SELECT KeID+1 AS KeID
                                FROM Kerdes
                                WHERE NOT EXISTS (SELECT 1 FROM Kerdes k2 WHERE k2.KeID = Kerdes.KeID+1)
                                ORDER BY KeID
                            ) WHERE ROWNUM = 1');
    if (!$stmt) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    $sikeres = oci_execute($stmt);
    if (!$sikeres) {
        $e = oci_error($stmt);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Változóban tároljuk az új KeID értéket
    $row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS);
    $K_Keid = $row['KEID'];

    // Beszúrjuk az új kérdést
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

    $stmt = oci_parse($conn, 'SELECT KAID FROM Kategoria WHERE NEV = :1');
    if (!$stmt) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    oci_bind_by_name($stmt, ':1', $K_kaid);

    $r = oci_execute($stmt);
    if (!$r) {
        $e = oci_error($stmt);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    $oneRow = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS);

    $Kat = $oneRow['KAID'];
    oci_free_statement($stmt);

    $stmt = oci_parse($conn, 'INSERT INTO TARTALMAZ (KAID, KEID) VALUES (:1,:2)');
    if (!$stmt) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    oci_bind_by_name($stmt, ':1', $Kat, -1, SQLT_INT);
    oci_bind_by_name($stmt, ':2', $K_Keid,-1, SQLT_INT);

    $sikeres = oci_execute($stmt);
    if (!$sikeres) {
        $e = oci_error($stmt);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    oci_free_statement($stmt);
    oci_close($conn);

    return $sikeres;
}

function categoryAdd($K_nev) {
    $conn = connect_db();
    if (!$conn) {
        return false;
    }

    $stmt = oci_parse($conn, 'INSERT INTO kategoria (kaid, nev) VALUES  (category_seq.NEXTVAL, :1)');
    if (!$stmt) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    oci_bind_by_name($stmt, ':1', $K_nev);

    $sikeres = oci_execute($stmt);
    if (!$sikeres) {
        $e = oci_error($stmt);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    oci_free_statement($stmt);
    oci_close($conn);

    return $sikeres;
}

function getUsernames()
{
    if (!($conn = connect_db())) { // If we couldn't connect, then we return false.
        return false;
    }

    $stid = oci_parse($conn, 'SELECT FID, admine, nev, jelszo FROM Felhasznalo');

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

function create_statistics($id){
    if (!($conn = connect_db())) { // If we couldn't connect, then we return false.
        return false;
    }

    $helyes_v = null;
    $megval_v = null;

    $stmt = oci_parse($conn, 'INSERT INTO Statisztika (SID, helyes_v_szam, megval_k_szam) 
                                VALUES (:1, :2, :3)');
    
    oci_bind_by_name($stmt, ':1', $id);
    oci_bind_by_name($stmt, ':2', $helyes_v);
    oci_bind_by_name($stmt, ':3', $megval_v);

    $success = oci_execute($stmt);
    if (!$success) {
        $e = oci_error($stmt);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    oci_free_statement($stmt);
    oci_close($conn);

    create_statistics($id);

    return $success;

}

function addNewUser($id, $name, $password)
{
    if (!($conn = connect_db())) { // If we couldn't connect, then we return false.
        return false;
    }

    $admin = 0; 

    $stmt = oci_parse($conn, 'INSERT INTO Felhasznalo (FID, Admine, nev, jelszo) 
                                VALUES (:1, :2, :3, :4)');

    oci_bind_by_name($stmt, ':1', $id);
    oci_bind_by_name($stmt, ':2', $admin);
    oci_bind_by_name($stmt, ':3', $name);
    oci_bind_by_name($stmt, ':4', $password);

    $success = oci_execute($stmt);
    if (!$success) {
        $e = oci_error($stmt);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // create statistics
    $helyes_v = 0;
    $megval_v = 0;

    $stmt = oci_parse($conn, 'INSERT INTO Statisztika (SID, helyes_v_szam, megval_k_szam) 
                                VALUES (:1, :2, :3)');
    
    oci_bind_by_name($stmt, ':1', $id);
    oci_bind_by_name($stmt, ':2', $helyes_v);
    oci_bind_by_name($stmt, ':3', $megval_v);

    $success = oci_execute($stmt);
    if (!$success) {
        $e = oci_error($stmt);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }



    oci_free_statement($stmt);
    oci_close($conn);

    
    // create_statistics($id);

    return $success;

}
function update_category($id, $category){
    $conn = connect_db();
    $category=ucfirst(strtolower($category));
    // keresd meg a kategória KAID értékét
    $sql = "SELECT kaid FROM Kategoria WHERE nev = :nev";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":nev", $category);
    oci_execute($stmt);
    $result = oci_fetch_assoc($stmt);
    $kaid = $result["KAID"];

    // a kapott KAID és az adott fid alapján frissítsd vagy inserteld az adatot
    $sql = "MERGE INTO valaszt
            USING (SELECT :kaid AS kaid, :fid AS fid FROM dual) src
            ON (valaszt.kaid = src.kaid AND valaszt.fid = src.fid)
            WHEN MATCHED THEN
              UPDATE SET valaszt = valaszt + 1
            WHEN NOT MATCHED THEN
              INSERT (kaid, fid, valaszt)
              VALUES (src.kaid, src.fid, 1)";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":kaid", $kaid);
    oci_bind_by_name($stmt, ":fid", $id);
    $result = oci_execute($stmt);

    oci_free_statement($stmt);
    oci_close($conn);
    return $result;
}
function setQuestions($chosencategory, $chosendifficulty){
    if (!($conn = connect_db())) { // If we couldn't connect, then we return false.
        return false;
    }

    $stid = oci_parse($conn, 'SELECT k.kerdes, k.A_valasz, k.B_valasz, k.C_valasz, k.D_valasz, k.helyes_v as "helyes_v"
                FROM Kerdes k
                INNER JOIN tartalmaz t ON k.KeID = t.KeID
                INNER JOIN Kategoria ka ON t.KaID = ka.KaID
                WHERE ka.nev =:1 and k.szint =:2');

    //$strtolower = strtolower($chosencategory);
    oci_bind_by_name($stid,':1', $chosencategory);
    oci_bind_by_name($stid,':2',$chosendifficulty);

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

function randomizeQuestionArray(){
    $questions = setQuestions(ucfirst($_SESSION["kategoria"]), $_SESSION["nehezseg"]);
    $randomizedQuestions = array();
    $numberOfQuestions = 5;

    while ($question = oci_fetch_array($questions, OCI_ASSOC + OCI_RETURN_NULLS)){
        array_push($randomizedQuestions, $question);
    }
    oci_free_statement($questions);

    $randomKeys = array_rand($randomizedQuestions, $numberOfQuestions);
    shuffle($randomKeys);
    $solution = array();

    for ($i = 0; $i<$numberOfQuestions; $i++){
        $currentKey = $randomKeys[$i];
        array_push($solution, $randomizedQuestions[$currentKey]);
    }
    //print_r($solution);
    return $solution;
}

function printOptionsRandomly($letter, $i, $questionArray){
    //echo '<input type="radio" id="A_valasz' . $i . '" name="kivalasztott' . $i . '" value="'.$questionarray["A_VALASZ"].'" ><label for="A_valasz' . $i . '">' . $questionarray["A_VALASZ"] . '</label><br>';
    echo '<input type="radio" 
    id="' . $letter . '_valasz' . $i . '" 
    name="kivalasztott' . $i . '" 
    value="'.$questionArray[$letter."_VALASZ"].'" >
    <label for="' . $letter . '_valasz' . $i . '">' . $questionArray[$letter . "_VALASZ"] . '</label><br>';
}

function delete_statistics($FID){
    if (!($conn = connect_db())) { // If we couldn't connect, then we return false.
        return false;
    }

    $stid = oci_parse($conn, 'DELETE FROM Statisztika WHERE SID = :1');
    oci_bind_by_name($stid, ':1', $FID);
    
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

    // delete_statistics($FID);

    return $stid;
}

function delete_user($FID){
    if (!($conn = connect_db())) { // If we couldn't connect, then we return false.
        return false;
    }

    $stid = oci_parse($conn, 'DELETE FROM Felhasznalo WHERE FID = :1');
    oci_bind_by_name($stid, ':1', $FID);

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

    delete_statistics($FID);

    return $stid;
}

function modify_user($modUserID, $modUsername){
    if (!($conn = connect_db())) { // If we couldn't connect, then we return false.
        return false;
    }

    $stid = oci_parse($conn, 'UPDATE Felhasznalo SET nev = :1 WHERE FID = :2');
    oci_bind_by_name($stid, ':1', $modUsername);
    oci_bind_by_name($stid, ':2', $modUserID);

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

function update_statistics($id, $score){
    if (!($conn = connect_db())) { // If we couldn't connect, then we return false.
        return false;
    }

    $stid = oci_parse($conn, 'SELECT HELYES_V_SZAM, MEGVAL_K_SZAM FROM Statisztika WHERE SID = :1');
    oci_bind_by_name($stid, ':1', $id);

    if (!$stid) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    $getstatisticsByID = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS);


    $questionsnum = $getstatisticsByID["MEGVAL_K_SZAM"] + 5;
    $correctquestionnum = $getstatisticsByID["HELYES_V_SZAM"] + $_SESSION["pontszam"];

    $stid = oci_parse($conn, 'UPDATE Statisztika SET helyes_v_szam = :1, megval_k_szam = :2 
    WHERE SID = :3');
    oci_bind_by_name($stid, ':1', $correctquestionnum);
    oci_bind_by_name($stid, ':2', $questionsnum);
    oci_bind_by_name($stid, ':3', $id);
    // oci_bind_by_name($stid, ':4', $id);

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


//function countCategory($categoryName, $userName){
//    if (!($conn = connect_db())) {
//        return false;
//    }
//
//    $stid = oci_parse($conn,
//        'SELECT COUNT(valaszt) from valaszt where FID = :2');
//
//    oci_bind_by_name($stid,':2',$userID);
//
//    if($stid == 0 ){ //null
//        $new = oci_parse($conn,'INSERT INTO VALASZT (KAID, FID, VALASZT) VALUES (:1, :2, 1)');
//
//        oci_bind_by_name($new,':1',$categoryID);
//        oci_bind_by_name($new,':2',$userID);
//
//
//        if (!$new) {
//            $e2 = oci_error($conn);
//            trigger_error(htmlentities($e2['message'], ENT_QUOTES), E_USER_ERROR);
//        }
//        $r2 = oci_execute($new);
//        if (!$r2) {
//            $e2 = oci_error($new);
//            trigger_error(htmlentities($e2['message'], ENT_QUOTES), E_USER_ERROR);
//        }
//
//        return $new;
//    }else{
//        $plus = oci_parse($conn,'UPDATE valaszt SET valaszt = valaszt + 1 WHERE kaid = :1 and fid = :2');
//
//        oci_bind_by_name($plus,':1',$categoryID);
//        oci_bind_by_name($plus,':2',$userID);
//
//        if (!$plus) {
//            $e3 = oci_error($conn);
//            trigger_error(htmlentities($e3['message'], ENT_QUOTES), E_USER_ERROR);
//        }
//        $r3 = oci_execute($plus);
//        if (!$r3) {
//            $e3 = oci_error($plus);
//            trigger_error(htmlentities($e3['message'], ENT_QUOTES), E_USER_ERROR);
//        }
//
//        return $plus;
//    }
//
//    $categoryData = getCategory();
//    while ($cdata = oci_fetch_array($categoryData, OCI_ASSOC + OCI_RETURN_NULLS)) {
//        if ($cdata["NEV"] === $categoryName){
//            $categoryID = $cdata["KAID"];
//        }
//    }
//
//    $userData = getUsernames();
//    while ($data = oci_fetch_array($userData, OCI_ASSOC + OCI_RETURN_NULLS)) {
//        if ($data["NEV"] === $userName){
//            $userID = $data["FID"];
//        }
//    }
//
//    if (!$stid) {
//        $e = oci_error($conn);
//        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
//    }
//    $r = oci_execute($stid);
//    if (!$r) {
//        $e = oci_error($stid);
//        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
//    }
//
//    oci_close($conn);
//    return $stid;
//
//    //    if ($categoryName == 'History'){ $categoryID = 01;}
////    if ($categoryName == 'General Knowledge'){ $categoryID = 02;}
////    if ($categoryName == 'Music'){ $categoryID = 03;}
////    if ($categoryName == 'Sport'){ $categoryID = 04;}
////    if ($categoryName == 'Science'){ $categoryID = 05;}
//    //$key = array_search($categoryName, $kat);
//
//}

?>
