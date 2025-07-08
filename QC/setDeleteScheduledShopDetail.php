<?php
if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['schedulecallid']) && !empty($_GET['schedulecallid']) ){
    
    session_start();
    include '../api/includes/DbOperation.php';

    try  
        {  
            
        $ScheduleCall_Cd = $_GET['schedulecallid'];
        

        $db=new DbOperation();
        $userName=$_SESSION['SAL_UserName'];
        $appName=$_SESSION['SAL_AppName'];
        $electionName=$_SESSION['SAL_ElectionName'];
        $developmentMode=$_SESSION['SAL_DevelopmentMode'];

        $query15 = "SELECT ScheduleCall_Cd FROM ScheduleDetails WHERE ScheduleCall_Cd = $ScheduleCall_Cd;";

        $isScheduleExists = $db->ExecutveQueryMultipleRowSALData($query15, $electionName, $developmentMode);
                   
       
        if(sizeof($isScheduleExists)>0){
            $dbSD=new DbOperation();
            $sqlSDDet = "DELETE FROM ScheduleDetails WHERE ScheduleCall_Cd = $ScheduleCall_Cd;";
            $deleteSDDet = $dbSD->RunQueryData($sqlSDDet, $electionName, $developmentMode);
                 
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

