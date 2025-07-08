<?php
if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['boardid']) && !empty($_GET['boardid']) ){
    
    session_start();
    include '../api/includes/DbOperation.php';

    try  
        {  
            
            $BoardId = $_GET['boardid'];
            $ScheduleCall_Cd = $_GET['schedulecallid'];
            $Shop_Cd = $_GET['shopid'];

            $db=new DbOperation();
            $userName=$_SESSION['SAL_UserName'];
            $appName=$_SESSION['SAL_AppName'];
            $electionName=$_SESSION['SAL_ElectionName'];
            $developmentMode=$_SESSION['SAL_DevelopmentMode'];


            $loginExecutiveCd = 0;
            $userId = $_SESSION['SAL_UserId'];
            if($userId != 0){
                $exeData = $db->ExecutveQuerySingleRowSALData("SELECT Executive_Cd FROM LoginMaster WHERE User_Cd = $userId ", $electionName, $developmentMode);
                if(sizeof($exeData)>0){
                    $loginExecutiveCd = $exeData["Executive_Cd"];
                }
            }

            $boardDetailData = $db->ExecutveQuerySingleRowSALData("SELECT BoardID,BoardType,BoardHeight,BoardWidth,Shop_Cd,ISNULL(BoardPhoto,'') as BoardPhoto,IsActive FROM ShopBoardDetails WHERE BoardID = $BoardId ", $electionName, $developmentMode);
            if(sizeof($boardDetailData)>0){
                $BoardId = $boardDetailData["BoardID"];
                $BoardType = $boardDetailData["BoardType"];
                $BoardHeight = $boardDetailData["BoardHeight"];
                $BoardWidth = $boardDetailData["BoardWidth"];
                $BoardPhoto = $boardDetailData["BoardPhoto"];
				if(empty($BoardPhoto)){
					$shopOutsidePhotoData = $db->ExecutveQuerySingleRowSALData("SELECT ISNULL(ShopOutsideImage1,'') as ShopOutsideImage1 FROM ShopMaster WHERE Shop_Cd  = $Shop_Cd ", $electionName, $developmentMode);
					$BoardPhoto = $shopOutsidePhotoData["ShopOutsideImage1"];
				}
                $IsBoardActive = $boardDetailData["IsActive"];

                include 'getShopBoardDetailAddEdit.php'; 
            }
        } 
        catch(Exception $e)  
        {  
            echo("Error!");  
        }
                                                          

  }else{
    //echo "ddd";
  }

}
?>

