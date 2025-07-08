<?php   
    
    header('Content-Type: text/html; charset=utf-8');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Asia/Kolkata');

  //  include 'api/includes/DbOperation.php';

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

    // if(!isset($_SESSION['SAL_View_Type'])){
        $_SESSION['SAL_View_Type'] = 'ListView';
    // }
?>


    

<?php include 'setShopDetailBusinessCatFilterData.php'; ?>
<?php include 'datatbl/tblShopListData.php'; ?>
