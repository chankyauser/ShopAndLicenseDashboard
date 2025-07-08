<?php
    session_start();
include '../api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['nodeCd']) && !empty($_GET['nodeCd']) ){

    try  
        {  
            $node_Cd = $_GET['nodeCd'];
            if($node_Cd == 'All'){
                $_SESSION['SAL_Node_Cd'] = $node_Cd;
            }else{
                $query = "SELECT
                ISNULL(Node_Cd,0) as Node_Cd,
                ISNULL(NodeName,'') as NodeName,
                ISNULL(NodeNameMar,'') as NodeNameMar,
                ISNULL(Ac_No,0) as Ac_No,
                ISNULL(Ward_No,0) as Ward_No,
                ISNULL(Address,'') as Address,
                ISNULL(Area,'') as Area
                FROM NodeMaster
                WHERE Node_Cd = $node_Cd";
                $db1=new DbOperation();
                $userName=$_SESSION['SAL_UserName'];
                $appName=$_SESSION['SAL_AppName'];
                $electionName=$_SESSION['SAL_ElectionName'];
                $developmentMode=$_SESSION['SAL_DevelopmentMode'];
                $nodeData = $db1->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);

                 

                
                if(sizeof($nodeData)>0){
                    $nodeCd = $nodeData[0]["Node_Cd"];
                    $nodeName = $nodeData[0]["NodeName"];    
                    $wardNo = $nodeData[0]["Ward_No"];    
                }else{
                    $nodeCd = 0; 
                    $nodeName = ""; 
                    $wardNo = ""; 
                }
                
                $_SESSION['SAL_Node_Cd'] = $nodeCd;
                $_SESSION['SAL_Node_Name'] = $nodeName;
                $_SESSION['SAL_Ward_No'] = $wardNo; 
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

