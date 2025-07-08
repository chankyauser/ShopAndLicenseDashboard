<?php
    // session_start();
    // include '../../api/includes/DbOperation.php';

    $db=new DbOperation();
    $userName=$_SESSION['CHCZ_UserName'];
    $appName=$_SESSION['CHCZ_AppName'];
    $electionCd=$_SESSION['CHCZ_Election_Cd'];
    $electionName=$_SESSION['CHCZ_ElectionName'];
    $developmentMode=$_SESSION['DevelopmentMode'];
    $condition = "AllNodeMasterList";
    $nodeCd = 0;
    $nodeMasterData = $db->getNodeMasterData($userName, $appName, $electionCd, $electionName, $developmentMode, $condition, $nodeCd);
    // print_r($nodeCd);
    // die();
    // print_r(json_decode(json_encode($questionAnswerData), true));
    // $questionAnswerData = json_decode($questionAnswerData, true);
    // print_r($a['questionsList']);
    // $b=$a['questionsList'];
    // print_r($b);
    // foreach ($b as $key => $value) {
    //     $c = $value['answersList'];
    // }
    // foreach ($c as $key1 => $value1) {
    //     echo $value1['Answer'];
    // }
// }
?>

<!-- Data list view starts -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Node Master - List</h4>
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
                                                        <th>Node</th>
                                                        <th>Contact Person</th>
                                                        <th>Contact Number</th>
                                                        <th>Police Station</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $srNo = 1;
                                                        foreach ($nodeMasterData as $key => $value) {
                                                        ?> 
                                                            <tr>
                                                                <td><?php echo $srNo++; ?></td>
                                                                <td><?php echo $value["NodeName"]; ?></td>
                                                                <td><?php echo $value["ContactPersonName"]; ?></td>
                                                                <td><?php echo $value["ContactNumber"]; ?></td>
                                                                <td><?php echo $value["PoliceStnName"]; ?></td>
                                                                <td>
                                                                    <a href="home.php?p=node-master&action=edit&nodeCd=<?php echo $value["NodeCd"]; ?>"><i class="feather icon-edit"></i></a>
                                                                    <!-- <a href=""><i class="feather icon-trash"></i></a> -->
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                    <th>Sr No</th>
                                                        <th>Node</th>
                                                        <th>Contact Person</th>
                                                        <th>Contact Number</th>
                                                        <th>Police Station</th>
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
</div>
<!-- Data list view end -->