<?php 
        $db=new DbOperation();
        $userName=$_SESSION['CHCZ_UserName'];
        $appName=$_SESSION['CHCZ_AppName'];
        $electionCd=$_SESSION['CHCZ_Election_Cd'];
        $electionName=$_SESSION['CHCZ_ElectionName'];
        $developmentMode=$_SESSION['DevelopmentMode'];
        $currenDate = date('Y-m-d');
        $condition = "";
        if(isset($_SESSION['User_Designation']) && !empty($_SESSION['User_Designation'])){
            if($_SESSION['User_Designation'] == "Tracing Executive"){
                $condition = "TracingExecutiveCallAssignSummary";
            }else if($_SESSION['User_Designation'] == "Ward Officer"){
                $condition = "WardOfficerCallAssignSummary";
            }else if($_SESSION['User_Designation'] == "Medical Officer"){
                $condition = "MedicalOfficerCallAssignSummary";
            }


        }
        
        $fromDate = $currenDate." ".$_SESSION['StartTime'];
        $toDate =$currenDate." ".$_SESSION['EndTime'];
        $nodeName = "";
        if(isset($_SESSION['CZ_Node_Name'])){
            $nodeName = $_SESSION['CZ_Node_Name'];
        }
        $callAssignSummaryData = $db->getNodeWiseCallAssignSummaryData($userName, $appName, $electionCd, $electionName, $developmentMode, $condition, $fromDate, $toDate, $nodeName);
        // print_r($callAssignSummaryData);
   
      

 ?>


<!-- Data list view starts -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Call Assign Summary </h4>
            </div>
            <div class="content-body">
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration table-hover-animation table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Select</th>
                                                        <th>Society Name</th>
                                                        <th>Assigned Patient</th>
                                                        <th>Not Assigned Patient</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $srNo=0;
                                                        foreach ($callAssignSummaryData as $key => $value) {
                                                            $srNo = $srNo +1;
                                                        ?> 
                                                            <tr>
                                                                <!-- <td><?php //echo $srNo; ?></td> -->
                                                                <td>
                                                                    <input type="checkbox" name="assignPatient" value="<?php echo $value["SocietyCd"].",".$value["NotAssigned"];?>" onclick="setSelectMultipleSociety()">
                                                                </td>
                                                                <td>
                                                                    <?php 
                                                                        $condition = "SocietyNameByCd";
                                                                        $societyCd = $value["SocietyCd"];
                                                                        $db1 = new DbOperation();
                                                                        $societyNameData = $db1->getSocietyMasterData($userName, $appName, $electionCd, $electionName, $developmentMode, $condition, $nodeCd, $societyCd); 
                                                                        if(sizeof($societyNameData)>0){
                                                                            foreach ($societyNameData as $key => $valueSociety) {
                                                                                if(!empty($valueSociety["ImageURL"])){
                                                                                ?>
                                                                                    <img src="<?php echo "https://csmcshoplicenses.com/image-proxy.php?url=".$valueSociety["ImageURL"]; ?>" height= "100" width = "100" >
                                                                                <?php    
                                                                                }
                                                                                echo $valueSociety["BuildingName"]."</br>".$valueSociety["UHPName"].", ".$valueSociety["NodeName"];
                                                                            }
                                                                        }
                                                                    ?>
                                                                </td>
                                                                <td><?php echo $value["Assigned"]; ?></td>
                                                                <td><?php echo $value["NotAssigned"]; ?></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Sr No</th>
                                                        <th>Society Name</th>
                                                        <th>Assigned Patient</th>
                                                        <th>Not Assigned Patient</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<!-- Data list view end -->