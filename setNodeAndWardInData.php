<?php

session_start();
include 'api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['electionName']) && !empty($_GET['electionName']) ){

    try  
        {  
            
            $_SESSION['SAL_ElectionName'] = $_GET['electionName'];
            $nodeName = $_GET['nodeName'];
            $_SESSION['SAL_Node_Name'] = $nodeName;

            if($nodeName=="All"){
                $nodeNameCondition = "  ";
                $_SESSION['SAL_Node_Cd'] = "All";
            }else{
                $nodeNameCondition = " AND NodeMaster.NodeName = '$nodeName' ";
            }

            if(!isset($_SESSION['SAL_Node_Cd'])){
                $_SESSION['SAL_Node_Cd'] = "All";
                $nodeCd = $_SESSION['SAL_Node_Cd'];
            }else{
                $nodeCd = $_SESSION['SAL_Node_Cd'];
            }


            if(isset($_SESSION['SAL_UserName']) && !empty($_SESSION['SAL_UserName'])){
                $userName=$_SESSION['SAL_UserName'];
            }
            $appName=$_SESSION['SAL_AppName'];
            $electionName=$_SESSION['SAL_ElectionName'];
            $developmentMode=$_SESSION['SAL_DevelopmentMode'];

            $queryNode = "SELECT COUNT(DISTINCT(ShopMaster.Shop_Cd))  as ShopCount,
                ISNULL(NodeMaster.Node_Cd,0) as Node_Cd,
                ISNULL(NodeMaster.NodeName,'') as NodeName,
                ISNULL(NodeMaster.NodeNameMar,'') as NodeNameMar,
                ISNULL(NodeMaster.Ac_No,0) as Ac_No,
                ISNULL(NodeMaster.Ward_No,0) as Ward_No,
                ISNULL(NodeMaster.Address,'') as Address,
                ISNULL(NodeMaster.Area,'') as Area
            FROM NodeMaster 
            INNER JOIN PocketMaster on PocketMaster.Node_Cd = NodeMaster.Node_Cd 
            INNER JOIN ShopMaster on ( ShopMaster.Pocket_Cd = PocketMaster.Pocket_Cd AND ShopMaster.IsActive = 1  AND ShopMaster.AddedDate IS NOT NULL )
            WHERE NodeMaster.IsActive = 1 $nodeNameCondition
            GROUP BY NodeMaster.Node_Cd, NodeMaster.NodeName,
            NodeMaster.NodeNameMar, NodeMaster.Ac_No,
            NodeMaster.Ward_No, NodeMaster.Address, NodeMaster.Area
            ORDER BY NodeMaster.Area";
            $db=new DbOperation();
            $dataNode = $db->ExecutveQueryMultipleRowSALData($queryNode, $electionName, $developmentMode);
    ?>

                
                        <option value="All">All Ward </option>
                        <?php 
                            foreach ($dataNode as $key => $valueNode) {
                                if($nodeCd==$valueNode["Node_Cd"]){
                        ?>
                                    <option selected value="<?php echo $valueNode["Node_Cd"]; ?>"><?php echo "".$valueNode["Ward_No"]." - ".$valueNode["Area"]; ?></option>
                        <?php
                                }else{
                         ?>
                                    <option value="<?php echo $valueNode["Node_Cd"]; ?>"><?php echo "".$valueNode["Ward_No"]." - ".$valueNode["Area"]; ?></option>
                        <?php            
                                }
                            }
                        ?>  
                    

    <?php
           
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

