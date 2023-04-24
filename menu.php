<?php

function menu() {
    $menustr  = '<span style="color:black;font-weight:bold;text-decoration:none; padding:5px;">';
    $menustr .= '<a href="index.php">Quiz App</a>';
    $menustr .= '</span>';
    $menustr .= '<span style="color:blue;font-weight:bold; padding:5px;">';
    $menustr .= '<a href="questions.php">Questions</a>';
    $menustr .= '</span>';
    $menustr .= '<span style="color:blue;font-weight:bold; padding:5px;">';
    $menustr .= '<a href="statistics.php">Statistics</a>';
    $menustr .= '</span>';
    $menustr .= '<span style="color:blue;font-weight:bold; padding:5px;">';
    $menustr .= '<a href="login.php">Login</a>';
    $menustr .= '</span>';
    $menustr .= '<span style="color:blue;font-weight:bold; padding:5px;">';
    $menustr .= '<a href="registration.php">Register</a>';
    $menustr .= '</span>';
    $menustr .= '<span style="color:blue;font-weight:bold; padding:5px;">';
    $menustr .= '<a href="questionadd.php">Add question</a>';
    $menustr .= '</span>';
    $menustr .= '<span style="color:blue;font-weight:bold; padding:5px;">';
    $menustr .= '<a href="categoryAdd.php">Add category</a>';
    $menustr .= '</span>';
    

    
    return $menustr;
}

?>