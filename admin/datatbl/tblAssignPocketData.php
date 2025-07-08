<?php
    
    $nodeName = "";
    $Ward_No = "";
    $executive_Cd = "";
    $Pocket_Cd = "";
    
    if(isset($_SESSION['SAL_NodeName_Assign'])){
        $nodeName = $_SESSION['SAL_NodeName_Assign'];
    }else{
        $nodeName = "All";
    }
    if(isset($_SESSION['SAL_Ward_No'])){
        $Ward_No = $_SESSION['SAL_Ward_No'] ;
    }else{
        $Ward_No = "All";
    }
    if(isset($_SESSION['SAL_Pocket_Cd'])){
        $Pocket_Cd = $_SESSION['SAL_Pocket_Cd'];
    }else{
        $Pocket_Cd = "All";
    }

    if(isset($_SESSION['SAL_Executive_Cd'])){
        $executive_Cd = $_SESSION['SAL_Executive_Cd'];
    }else{
        $executive_Cd = "All";
    }

    $dateCondition = "";
    $executiveCondition = "";
    $nodeCondition = "";
    $wardCondition = "";
    $pocketCondition = "";

    

    if(isset($_GET['filter_date'])){
        $filterDate = $_GET['filter_date'];
        if($filterDate == "All"){
            $dateCondition = "";
        }
    }else{
        $dateCondition = " AND CONVERT(VARCHAR,tc.QC_DoneDate,120) BETWEEN '$fromDate' AND '$toDate'  ";
    }

    if($executive_Cd == "All"){
        $executiveCondition = " AND tc.AddedBy <> '' ";
    }else{
        $addedBy = "";
        $query1 = "SELECT top (1) 
        ISNULL(um.UserName,'') as UserName
        FROM Survey_Entry_Data..User_Master um
        INNER JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = um.Executive_Cd
        WHERE um.AppName = '$appName'
        AND ISNULL(um.Executive_Cd,0) = '$executive_Cd' 
        ";
        
        $db1=new DbOperation();
        $dataExecutiveName = $db1->getShoplicenseExecutiveData($query1, $userName, $appName, $electionName, $developmentMode);
        if(sizeof($dataExecutiveName)>0){
            $addedBy = $dataExecutiveName[0]["UserName"];
        }
        $executiveCondition = " AND tc.AddedBy = '$addedBy' ";
    }

    if($nodeName == "All"){
        // $nodeCondition = " AND wm.NodeName <> '' ";
    }else{
        // $nodeCondition = " AND wm.NodeName = '$nodeName' ";
    }

    if($Ward_No == "All"){
        $wardCondition = " AND pm.Ward_No <> '' ";
    }else{
        $wardCondition = " AND pm.Ward_No = '$Ward_No' ";
    }

    if($Pocket_Cd == "All"){
        $pocketCondition = " AND tc.Pocket_Cd <> '' ";
    }else{
        $pocketCondition = " AND tc.Pocket_Cd = '$Pocket_Cd' ";
    }

    // $queryPkt = "SELECT
    //     ISNULL(pm.Pocket_Cd,0) as Pocket_Cd,
    //     ISNULL(pm.PocketName,'') as PocketName,
    //     ISNULL(pm.PocketNameMar,'') as PocketNameMar,
    //     ISNULL(pm.KML_FileUrl,'') as KML_FileUrl,
    //     ISNULL(nm.Ward_No,0) as Ward_No,
    //     -- ISNULL(wm.WardNameOrNum,'') as WardNameOrNum,
    //     ISNULL(nm.NodeName,'') as NodeName
    //     -- ISNULL(nm.NodeAcronym,'') as NodeAcronym
    //     FROM PocketMaster pm
    //     LEFT JOIN NodeMaster nm on nm.Node_Cd = pm.Node_Cd
    //     WHERE pm.IsActive = 1
    //     AND ISNULL(pm.SRExecutiveCd,0) = 0 
    //     AND ISNULL(pm.IsCompleted,0) = 0
    // ";
    // $dbPktSummary=new DbOperation();
    // // echo $query1;
    // $dataPktSummary = $dbPktSummary->ExecutveQueryMultipleRowSALData($queryPkt, $electionName, $developmentMode);

    $query1 = "SELECT
        ISNULL(um.User_Id,0) as User_Id,
        ISNULL(um.UserName,'') as UserName,
        ISNULL(um.Executive_Cd,0) as Executive_Cd,
        ISNULL(lm.User_Type,'') as User_Type,
        ISNULL(um.ElectionName,'') as ElectionName,
        ISNULL(em.ExecutiveName,'') as ExecutiveName,
        ISNULL(em.MobileNo,'') as MobileNo,
        ISNULL(um.DeactiveFlag,'') as DeactiveFlag,
        ISNULL((SELECT top (1)
        pm.SRExecutiveCd
        FROM PocketMaster pm 
        WHERE pm.SRExecutiveCd = em.Executive_Cd
        AND pm.IsActive = 1 
        ORDER By pm.UpdatedDate DESC
        ),0) as SRExecutiveCd,

        ISNULL((SELECT top (1) pm.IsCompleted FROM PocketMaster pm 
        WHERE pm.SRExecutiveCd = em.Executive_Cd AND pm.IsActive = 1 
        ORDER By pm.UpdatedDate DESC
        ),0) as IsCompleted,

        ISNULL((SELECT top (1) pm.Pocket_Cd FROM PocketMaster pm 
        WHERE pm.SRExecutiveCd = em.Executive_Cd AND pm.IsActive = 1 ORDER By pm.UpdatedDate DESC ),0) 
        as Pocket_Cd,

        ISNULL((SELECT top (1) pm.PocketName FROM PocketMaster pm 
        WHERE pm.SRExecutiveCd = em.Executive_Cd
        AND pm.IsActive = 1 
        ORDER By pm.UpdatedDate DESC
        ),'') as PocketName,

        ISNULL((SELECT top (1)
        convert(varchar,pm.SRAssignedDate,121)
        FROM PocketMaster pm 
        WHERE pm.SRExecutiveCd = em.Executive_Cd
        AND pm.IsActive = 1 
        ORDER By pm.UpdatedDate DESC
        ),'') as SRAssignedDate,

        ISNULL((SELECT top (1)
        PocketAssignCd
        FROM PocketAssign pa 
        WHERE pa.SRExecutiveCd = em.Executive_Cd
        AND pa.PocketCd = (
            SELECT top (1)
            pm.Pocket_Cd
            FROM PocketMaster pm 
            WHERE pm.SRExecutiveCd = em.Executive_Cd
            AND pm.IsActive = 1 
            ORDER By pm.UpdatedDate DESC
        )
        ORDER By pa.UpdatedDate DESC
        ),'') as PocketAssignCd
        FROM Survey_Entry_Data..User_Master um 
        LEFT JOIN Survey_Entry_Data..Executive_Master em on em.Executive_Cd = um.Executive_Cd
        LEFT JOIN LoginMaster lm on lm.Executive_Cd = em.Executive_Cd
        WHERE um.AppName ='$appName' AND um.Executive_Cd <> 0
        AND UserType = 'A' AND lm.User_Type = 'Executive' 
        AND ISNULL(um.DeactiveFlag,'') <> 'D' 
        ORDER BY ElectionName DESC ;";

    $db1=new DbOperation();
    // echo $query1;
    $dataAssignPocketExecSummary = $db1->ExecutveQueryMultipleRowSALData($query1, $electionName, $developmentMode);

?> 
        <div class="col-xl-12 col-md-12 col-xs-12" id="removePocketFromExecutive">
            
        </div>

        <div class="col-xl-12 col-md-12 col-xs-12" id="openClosePocket">
            
        </div>
    
        <div class="col-xl-12 col-md-12 col-xs-12">
            <div class="card">
                
                <div class="row">
                    <div class="col-xl-11 col-md-11 col-xs-11">
                        <div class="card-header">
                            <h4 class="card-title">
                                Assign Pocket Executive Summary 
                            </h4>
                        </div>
                    </div>
                   <!--  <div class="col-xl-1 col-md-1 col-xs-1">
                        <a class="nav-link dropdown-toggle" id="dropdown-flag" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-flag"> -->
                             <?php 
                               // $srNo1 = 1;
                                   // foreach ($dataPktSummary as $key => $value) {
                                      //  $kmlFilePresent="";
                                      //  if(!empty($value["KML_FileUrl"])){ $kmlFilePresent = "File Found!"; }else{ $kmlFilePresent = "Files Not Found!"; }
                                ?> 
                                     <!-- <a class="dropdown-item" href="home.php?p=pocket-master&action=edit&Pocket_Cd=<?php //echo $value["Pocket_Cd"]; ?>" > <?php //echo $srNo1++.") Pocket : ".$value["PocketName"]." Node : ".$value["NodeName"]."\n KML File : ".$kmlFilePresent; ?></a> -->
                                <?php
                                    //}
                                ?>
                        <!-- </div>
                    </div> -->
                </div>
                <div class="card-content">
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table class="table zero-configuration table-hover-animation table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Pocket Open/Close</th>
                                        <th>Executive</th>
                                        <th>User Rights</th>
                                        <th>Mobile</th>
                                        <th>Corporation</th>
                                        <th>Pocket Name</th>
                                        <th>AssignDate</th>
                                        <th>Assign Pocket</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $srNo = 1;
                                        
                                        foreach ($dataAssignPocketExecSummary as $key => $value) {
                                        ?> 
                                            <tr>
                                                <td><?php echo $srNo++; ?></td>
                                                 <td>
                                                    <?php if($value["PocketName"] != '') { ?>
                                                    <div class="custom-control custom-switch switch-md custom-switch-success mr-2 mb-1">
                                                        <p class="mb-0"></p></br>
                                                        <input type="checkbox" class="custom-control-input" id="customSwitch<?php echo $value['Pocket_Cd'];?>" 
                                                        <?php if($value['IsCompleted'] == 0)
                                                        {
                                                            echo "checked";
                                                        } ?> 
                                                        
                                                        onchange="openClosePocket('<?php echo $value['User_Id']; ?>','<?php echo $value['Executive_Cd']; ?>','<?php echo $value['ExecutiveName']; ?>','<?php echo $value['Pocket_Cd']; ?>','<?php echo $value['PocketName']; ?>','<?php echo $value['PocketAssignCd']; ?>')">
                                                        <label class="custom-control-label" for="customSwitch<?php echo $value['Pocket_Cd'];?>">
                                                            <span class="switch-text-left">Open</span>
                                                            <span class="switch-text-right">Close</span>
                                                        </label>
                                                    </div>
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo $value["ExecutiveName"]; ?></td>
                                                <td><?php echo $value["User_Type"]; ?></td>
                                                <td><?php echo $value["MobileNo"]; ?></td>
                                                <td><?php echo $value["ElectionName"]; ?></td>
                                                <td><?php echo $value["PocketName"]; ?></td>
                                                <td>
                                                    <?php 
                                                        if( ($value["SRExecutiveCd"] <> 0 && $value["IsCompleted"] == 0 && $value["Pocket_Cd"] != 0 ) ){ 
                                                            echo date('d/m/Y h:i a', strtotime($value["SRAssignedDate"]));
                                                        } 
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php  if( ( $value["SRExecutiveCd"] == 0 && ( $value["IsCompleted"] == 0 && $value["Pocket_Cd"] == 0 ) ||  ($value["SRExecutiveCd"] <> 0 && $value["IsCompleted"] == 1)  ) ){  ?>  
                                                        <a onclick="setAssignPocketToExecutive('<?php echo $value['User_Id']; ?>','<?php echo $value['Executive_Cd']; ?>')" ><i class="feather icon-layers" style="font-size: 1.5rem;color:#c90d41;" title="Assign Pocket"></i></a>
                                                    <?php }else if( ($value["SRExecutiveCd"] <> 0 && $value["IsCompleted"] == 0) ){    //echo $value["PocketName"]; ?>
                                                        <a onclick="setRemovePocketFromExecutiveForm('<?php echo $value['User_Id']; ?>','<?php echo $value['Executive_Cd']; ?>','<?php echo $value['ExecutiveName']; ?>','<?php echo $value['Pocket_Cd']; ?>','<?php echo $value['PocketName']; ?>','<?php echo $value['PocketAssignCd']; ?>')" ><i class="feather icon-trash-2" style="font-size: 1.5rem;color:red;" title="Remove Pocket"></i></a>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>