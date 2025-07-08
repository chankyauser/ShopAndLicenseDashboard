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
            if( 
                ( isset($_SESSION['SAL_UserName']) && !empty($_SESSION['SAL_UserName']) ) &&
                ( isset($_SESSION['SAL_UserType']) && !empty($_SESSION['SAL_UserType']) ) &&
                ( ($_SESSION['SAL_UserType'] == 'Client' || $_SESSION['SAL_UserType'] == 'Admin') )
              )
              {
                include($PageDir.'/home-dashboard.php');
              }
              else
              { 
                header('Location:../index.php'); 
              }
        }
       
    include 'includes/footer.php';

?>