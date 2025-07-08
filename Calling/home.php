<?php 

    include 'includes/header.php'; 

        $PageDir='pages';
        if (!empty($_GET['p'])){
            
            $pagesFolder=scandir($PageDir, 0);
            unset($pagesFolder[0], $pagesFolder[1]);
            // print_r($pages);
            $PageName=$_GET['p'];
            if (in_array($PageName.'.php', $pagesFolder)){
            include($PageDir.'/'.$PageName.'.php');
            }else {
            include($PageDir.'/auth-404.php');
            } 
        }else {
            include($PageDir.'/home-dashboard.php');
        }
       
    include 'includes/footer.php';

?> 