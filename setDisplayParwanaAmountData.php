<?php

    function IND_money_format($number){
        $decimal = (string)($number - floor($number));
        $money = floor($number);
        $length = strlen($money);
        $delimiter = '';
        $money = strrev($money);

        for($i=0;$i<$length;$i++){
            if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$length){
                $delimiter .=',';
            }
            $delimiter .=$money[$i];
        }

        $result = strrev($delimiter);
        $decimal = preg_replace("/0\./i", ".", $decimal);
        $decimal = substr($decimal, 0, 3);

        if( $decimal != '0'){
            $result = $result.$decimal;
        }

        return $result;
    }
    
session_start();
include 'api/includes/DbOperation.php'; 

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
  
  if(isset($_GET['electionName']) && !empty($_GET['electionName']) ){

    try  
        {  
            
            $_SESSION['SAL_ElectionName'] = $_GET['electionName'];
            $parwanaDetId = $_GET['parwanaDetId'];

            if(empty($parwanaDetId)){ 
                $parwanaDetId = 0;
            }
                if(isset($_SESSION['SAL_UserName']) && !empty($_SESSION['SAL_UserName'])){
                    $userName=$_SESSION['SAL_UserName'];
                }
                $appName=$_SESSION['SAL_AppName'];
                $electionName=$_SESSION['SAL_ElectionName'];
                $developmentMode=$_SESSION['SAL_DevelopmentMode'];

                $db=new DbOperation();
                $query12 = "SELECT pd.ParwanaDetCd, pd.Parwana_Cd, pd.IsRenewal, pm.Parwana_Name_Eng, pm.Parwana_Name_Mar, pd.PDetNameEng, pd.PDetNameMar, pd.Amount from ParwanaDetails pd  INNER JOIN ParwanaMaster pm on pm.Parwana_Cd = pd.Parwana_Cd
                WHERE pd.ParwanaDetCd = $parwanaDetId AND pd.IsActive = 1;";

                $ParwanaDetailData = $db->ExecutveQuerySingleRowSALData($query12, $electionName, $developmentMode);
                // print_r($ParwanaDetailData);
    ?>

                    
                <div class="col-sm-12 col-md-10">
                    <label>Parwana Detail  <?php if(sizeof($ParwanaDetailData)>0){  echo " : ".$ParwanaDetailData["PDetNameEng"]; } ?> </label>
                </div>
                <div class="col-sm-12 col-md-2">
                    <?php if(sizeof($ParwanaDetailData)>0){ ?>
                        <label style="float:right;"> 
                           <?php if($ParwanaDetailData["Amount"] !=0){ ?> Demand : <i class="fa-solid fa-indian-rupee-sign"></i> <?php  echo IND_money_format($ParwanaDetailData["Amount"])."/-"; } ?>
                        </label>
                    <?php  } ?> 
                </div>
                        

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

