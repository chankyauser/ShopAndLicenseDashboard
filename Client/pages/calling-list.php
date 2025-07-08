<?php   
    
    header('Content-Type: text/html; charset=utf-8');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Asia/Kolkata');

  //  include '../api/includes/DbOperation.php';

        $surveyStatedQue = "SELECT Top 1 CONVERT(varchar,AddedDate, 23) as FromDate FROM ShopMaster 
        WHERE IsActive = 1
        ORDER BY AddedDate ASC";
        $dbC =new DbOperation();
        $surveyStatedDate = $dbC->ExecutveQuerySingleRowSALData($surveyStatedQue, $electionName, $developmentMode);


    $db2=new DbOperation();

    if(isset($_SESSION['SAL_UserName']) && !empty($_SESSION['SAL_UserName'])){
        $userName=$_SESSION['SAL_UserName'];
    }
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $userId = $_SESSION['SAL_UserId'];
    if($userId != 0){
        $userData = $db->ExecutveQuerySingleRowSALData("SELECT UserName FROM Survey_Entry_Data..User_Master WHERE User_Id = $userId ", $electionName, $developmentMode);
        if(sizeof($userData)>0){
            $_SESSION['SAL_UserName'] = $userData["UserName"];
        }
    }else{
        session_unset();
        session_destroy();
        header('Location:index.php');
    }

        $currentDate = date('Y-m-d');
        $curDate = date('Y');
        //$fromDate = date('Y-m-d', strtotime('-365 days'));
        $fromDate = $surveyStatedDate['FromDate'];
        $toDate = $currentDate;

        //$_SESSION['SAL_FromDate'] = '2022-10-01' ;

        if(isset($_GET['fromDate'])){
            $fromDate = $_GET['fromDate'];
            $_SESSION['SAL_FromDate'] = $fromDate ;
        }
        else if(isset($_SESSION['SAL_FromDate'])){
            $fromDate  = $_SESSION['SAL_FromDate']; 
        }else{
            $_SESSION['SAL_FromDate'] = $fromDate ;
        }

        if(isset($_GET['toDate'])){
            $toDate = $_GET['toDate'];
            $_SESSION['SAL_ToDate'] = $toDate ;
        }
        else if(isset($_SESSION['SAL_ToDate'])){
            $toDate  = $_SESSION['SAL_ToDate']; 
        }else{
            $_SESSION['SAL_ToDate'] = $toDate ;
        }

        // if(!isset($_SESSION['SAL_FromDate'])){
        //     $_SESSION['SAL_FromDate'] = $fromDate ;
        // }else{
        //     $fromDate  = $_SESSION['SAL_FromDate'];
        // }

        // if(!isset($_SESSION['SAL_ToDate'])){
        //     $_SESSION['SAL_ToDate'] = $toDate;
        // }else{
        //     $toDate = $_SESSION['SAL_ToDate'];
        //     if($toDate != date('Y-m-d')){
        //         $_SESSION['SAL_ToDate'] = date('Y-m-d');
        //         $toDate = $_SESSION['SAL_ToDate'];
        //     }
        // }
        //unset($_SESSION['SAL_Node_Cd']);

        if(isset($_GET['nodeCd'])){
            $nodeCd = $_GET['nodeCd'];
            $_SESSION['SAL_Node_Cd'] = $nodeCd ;
        }
        else if(isset($_SESSION['SAL_Node_Cd'])){
            $nodeCd = $_SESSION['SAL_Node_Cd'];
            // if(isset($_GET['nodeId'])){
            //     $node_Cd = $_GET['nodeId'];
            //     $_SESSION['SAL_Node_Cd'] = $node_Cd;
            // }
        }else {
            $nodeCd = 0;
        }
        
        if(isset($_GET['pocketId'])){
            $pocket_Cd = $_GET['pocketId'];
            $_SESSION['SAL_Pocket_Cd'] = $pocket_Cd;
        }else if(isset($_SESSION['SAL_Pocket_Cd'])){
            $pocket_Cd = $_SESSION['SAL_Pocket_Cd'];    
        }else{
            $pocket_Cd = 0;  
        }

        if(isset($_GET['Calling_Category_Cd'])){
            $Calling_Category_Cd = $_GET['Calling_Category_Cd'];
            $_SESSION['SAL_Calling_Category_Cd'] = $Calling_Category_Cd;
        }else if(isset($_SESSION['SAL_Calling_Category_Cd'])){
            $Calling_Category_Cd = $_SESSION['SAL_Calling_Category_Cd'];    
        }else{
            $Calling_Category_Cd = 0;  
        }

    // if(!isset($_SESSION['SAL_View_Type'])){
        $_SESSION['SAL_View_Type'] = 'ListView';
    // }

    if($Calling_Category_Cd == 0){
        $CallingCategoryCondition = " AND ShopMaster.Calling_Category_Cd <> '' ";
    }else{
        $CallingCategoryCondition = " AND ShopMaster.Calling_Category_Cd = $Calling_Category_Cd ";
    }

    $_SESSION['SAL_View_Type'] = 'ListView';
?>

<?php include 'setShopCallingDetailBusinessCatFilterData.php'; ?>
<?php include 'datatbl/tblShopListData.php'; ?>

<main class="main" id="showPageDetails1">
