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
    $menustr .= '<a href="#">Login</a>';
    $menustr .= '</span>';
    $menustr .= '<span style="color:blue;font-weight:bold; padding:5px;">';
    $menustr .= '<a href="#">Register</a>';
    $menustr .= '</span>';
    

    
    return $menustr;
}

?>