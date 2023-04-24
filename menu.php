<nav>
    <ul class="nav justify-content-center p-3">
        <li class="nav-item"><a class="nav-link" href="index.php">Quiz App</a></li>
        
    
        <?php if (isset($_SESSION["user"])) { ?>
        <li class="nav-item"><a class="nav-link text-white" href="questions.php">Questions</a></li>
        <li class="nav-item"><a class="nav-link" href="statistics.php">Statistics</a></li>
        <li class="nav-item"><a class="nav-link" href="questionadd.php">Add question</a></li>
        <li class="nav-item"><a class="nav-link "href="categoryAdd.php">Add category</a></li>
        <?php } else { ?>
        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        <li class="nav-item"><a class="nav-link"href="registration.php">Registration</a></li>
        
        <?php } ?>
        
        <?php if (isset($_SESSION["user"])) { ?>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        <!-- <p>print_r($_SESSION["user"]);</p> -->
        <?php } ?>
        
    </ul>
</nav>


<!-- <?php

// function menu() {
//     $menustr  = '<span style="color:black;font-weight:bold;text-decoration:none; padding:5px;">';
//     $menustr .= '<a href="index.php">Quiz App</a>';
//     $menustr .= '</span>';
//     $menustr .= '<span style="color:blue;font-weight:bold; padding:5px;">';
//     $menustr .= '<a href="questions.php">Questions</a>';
//     $menustr .= '</span>';
//     $menustr .= '<span style="color:blue;font-weight:bold; padding:5px;">';
//     $menustr .= '<a href="statistics.php">Statistics</a>';
//     $menustr .= '</span>';
//     $menustr .= '<span style="color:blue;font-weight:bold; padding:5px;">';
//     $menustr .= '<a href="login.php">Login</a>';
//     $menustr .= '</span>';
//     $menustr .= '<span style="color:blue;font-weight:bold; padding:5px;">';
//     $menustr .= '<a href="registration.php">Register</a>';
//     $menustr .= '</span>';
//     $menustr .= '<span style="color:blue;font-weight:bold; padding:5px;">';
//     $menustr .= '<a href="questionadd.php">Add question</a>';
//     $menustr .= '</span>';
//     $menustr .= '<span style="color:blue;font-weight:bold; padding:5px;">';
//     $menustr .= '<a href="categoryAdd.php">Add category</a>';
//     $menustr .= '</span>';
    

//     return $menustr;
// }

?> -->