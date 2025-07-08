<?php
if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['shopCategory']) && !empty($_GET['shopCategory']) ){
    
    session_start();
    include '../api/includes/DbOperation.php';

    try  
        {  
            
            $getShopCategory = $_GET['shopCategory'];
            
            $Shop_Cd = $_GET['shopid'];

            $db=new DbOperation();
            $userName=$_SESSION['SAL_UserName'];
            $appName=$_SESSION['SAL_AppName'];
            $electionName=$_SESSION['SAL_ElectionName'];
            $developmentMode=$_SESSION['SAL_DevelopmentMode'];

            if(!empty($getShopCategory)){
               $shopCatCondition =  " AND prm.Category = '".$getShopCategory."' " ;
            }else{
                $shopCatCondition = " ";
            }

            $query2 = "SELECT bcm.BusinessCat_Cd, bcm.BusinessCatName, bcm.BusinessCatNameMar FROM BusinessCategoryMaster bcm INNER JOIN ParwanaMaster prm on bcm.BusinessCat_Cd = prm.BusinessCat_Cd WHERE prm.IsActive = 1 $shopCatCondition GROUP BY bcm.BusinessCat_Cd, bcm.BusinessCatName, bcm.BusinessCatNameMar;";
            $NatureOfBusinesDropDown = $db->ExecutveQueryMultipleRowSALData($query2, $electionName, $developmentMode);

            $queryShop = "SELECT ISNULL(BusinessCat_Cd,0) as BusinessCat_Cd FROM ShopMaster WHERE Shop_Cd = $Shop_Cd;";

            $getNature_of_BusinessData = $db->ExecutveQuerySingleRowSALData($queryShop, $electionName, $developmentMode);
            $getNature_of_Business = $getNature_of_BusinessData["BusinessCat_Cd"];
            ?>

            <option value="">--Select--</option>
                <?php   
                    if (sizeof($NatureOfBusinesDropDown)>0) 
                    {
                        foreach($NatureOfBusinesDropDown as $key => $value)
                        {
                            if($getNature_of_Business == $value["BusinessCat_Cd"])
                            {
                            ?> 
                                <option selected="true" value="<?php echo $value['BusinessCat_Cd'];?>"><?php echo $value['BusinessCatName'];?></option>
                                <?php }
                                else
                                { ?>
                                <option value="<?php echo $value["BusinessCat_Cd"];?>"><?php echo $value["BusinessCatName"];?></option>
                        <?php }
                        }
                    }else{ 
                ?>
                    <option value="">--Select--</option>
                <?php
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

