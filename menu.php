<nav>
    <ul class="nav justify-content-center p-3">
        
        
    
        <?php if (isset($_SESSION["user"])) { ?>
            <li class="nav-item"><a class="nav-link" href="index.php">Quiz App</a></li>
            <li class="nav-item"><a class="nav-link" href="statistics.php">Statistics</a></li>
            <li class="nav-item"><a class="nav-link" href="last.php">Newly registered</a></li>
        
            <?php if ($_SESSION["admine"] == 1) { ?>
                <li class="nav-item"><a class="nav-link text-white" href="questions.php">Questions</a></li>
                <li class="nav-item"><a class="nav-link" href="category.php">Category's</a></li>
                <li class="nav-item"><a class="nav-link" href="questionadd.php">Add question</a></li>
                <li class="nav-item"><a class="nav-link" href="categoryAdd.php">Add category</a></li>
                <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
            <?php } ?>    
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
