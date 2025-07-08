<?php
    
    $db1=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName']; 
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];

    $query = "SELECT ISNULL(pm.Pocket_Cd,0) as Pocket_Cd,
        ISNULL(pm.PocketName,'') as PocketName,
        ISNULL(pm.PocketNameMar,'') as PocketNameMar, 
        ISNULL(nm.Ward_No,0) as Ward_No,
        ISNULL(pm.KML_FileUrl,'') as KML_FileUrl,  
        ISNULL(pm.IsActive,0) as IsActive,
        ISNULL(CONVERT(VARCHAR,pm.DeActiveDate,23),'') as DeActiveDate  
        FROM PocketMaster pm 
        LEFT JOIN NodeMaster nm ON pm.Node_Cd = nm.Node_Cd ORDER BY pm.PocketName";
    // echo $query;
        // echo "$electionName, $developmentMode";
    $PocketMasterListData = $db1->ExecutveQueryMultipleRowSALData($query, $electionName, $developmentMode);
    // print_r($PocketMasterListData);
  
?>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Pocket Master - List</h4>
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
                                                        <th>Sr No</th>
                                                        <th>Pocket Name</th>
                                                        <th>Pocket Name Marathi</th>
                                                        <th>Ward No</th>
                                                        <th>KML File</th>
                                                        <th>DeActive Date</th>
                                                        <th>Is Active</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $srNo = 1;
                                                        foreach ($PocketMasterListData as $key => $value) {
                                                        ?> 
                                                            <tr>
                                                                <td><?php echo $srNo++; ?></td>
                                                                <td><?php echo $value["PocketName"]; ?></td>
                                                                <td><?php echo $value["PocketNameMar"]; ?></td>
                                                                <td><?php echo $value["Ward_No"]; ?></td>
                                                                <td><?php if(filter_var($value["KML_FileUrl"], FILTER_VALIDATE_URL)){ echo "Uploaded"; } ?></td>
                                                                <td><?php if(!empty($value["DeActiveDate"])){ echo date('d/m/Y h:i a',strtotime($value["DeActiveDate"])); } ?></td>
                                                                <td><?php if($value["IsActive"]==1){ echo "Yes"; }else{ echo "No"; } ?></td>
                                                                <td>
                                                                    <a href="home.php?p=pocket-master&action=edit&Pocket_Cd=<?php echo $value["Pocket_Cd"]; ?>"><i class="feather icon-edit"></i></a>
                                                                    <a href="home.php?p=pocket-master&action=delete&Pocket_Cd=<?php echo $value["Pocket_Cd"]; ?>"><i class="feather icon-trash"></i></a>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Sr No</th>
                                                        <th>Pocket Name</th>
                                                        <th>Pocket Name Marathi</th>
                                                        <th>Ward No</th>
                                                        <th>KML File</th>
                                                        <th>DeActive Date</th>
                                                        <th>Is Active</th>
                                                        <th>Action</th>
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
