<?php   
    
    header('Content-Type: text/html; charset=utf-8');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Asia/Kolkata');

    // include '../Client/setOwnerCollectionReport.php'; 
    include 'setShopSurveyDetailFilterData.php'; 
    include './datatbl/tblShopOwnerCollectionReport.php';
?>

<script>
    $(document).ready(function(){
        $('#showPageDetails .page-header').addClass('d-none');
    });
</script>