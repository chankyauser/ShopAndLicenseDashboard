
<section id="category-master">
    <?php
        $categoryCd = 0;
        $categoryName = '';
        $categoryDescription = '';
        $color = '';
        $isActive = 1;
        $remark = "";
        $dataCategotyMaster = array();
        if(isset($_GET['categoryCd']) && $_GET['categoryCd'] != 0 ){
                $db=new DbOperation();
                $userName=$_SESSION['CHCZ_UserName'];
                $appName=$_SESSION['CHCZ_AppName'];
                $electionCd=$_SESSION['CHCZ_Election_Cd'];
                $electionName=$_SESSION['CHCZ_ElectionName'];
                $developmentMode=$_SESSION['DevelopmentMode'];
                $categoryCd = $_GET['categoryCd'];
                $condition = "CategoryByCd";
                $dataCategotyMaster = $db->getZoneCategoryMasterData($userName, $appName, $electionCd, $electionName, $developmentMode, $condition, $categoryCd);
                // print_r($dataCategotyMaster);
                // die();
                if(sizeof($dataCategotyMaster)>0){
                    // Array ( [0] => Array ( [CategoryCd] => 1 [CategoryName] => Cat 1 [CategoryDescription] => High Frequency 
                    // [Color] => #ff0000 [Remark] => Max no of covid positive patients updated [IsActive] => 1 ) )

                    $categoryCd = $dataCategotyMaster[0]['CategoryCd'];
                    $categoryName = $dataCategotyMaster[0]['CategoryName'];
                    $categoryDescription = $dataCategotyMaster[0]['CategoryDescription'];
                    $color = $dataCategotyMaster[0]['Color'];
                    $remark = $dataCategotyMaster[0]['Remark'];
                    $isActive = $dataCategotyMaster[0]['IsActive'];
                }
        }
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Category Master - <?php if(isset($_GET['categoryCd']) && $_GET['categoryCd'] != 0 ){ ?> Edit <?php }else{ ?> New <?php } ?></h4>
                    <!-- <?php //if( !isset($_GET['p']) && $_GET['p'] != 'category-master' ){ ?>   <button onclick="goBack()">Go Back</button>  <?php //} ?> -->
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" novalidate>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Category Name</label>
                                        <div class="controls"> 
                                            <input type="text" name="categoryName" value="<?php echo $categoryName; ?>"  class="form-control" placeholder="Category Name" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Category Description</label>
                                        <div class="controls"> 
                                            <input type="text" name="categoryDescription" value="<?php echo $categoryDescription; ?>"  class="form-control" placeholder="Category Description" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Color</label>
                                        <div class="controls"> 
                                            <input type="color" name="color" value="<?php echo $color; ?>"  class="form-control" placeholder="Color" >
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Remark</label>
                                        <div class="controls"> 
                                            <input type="text" name="remark" value="<?php echo $remark; ?>"  class="form-control" placeholder="Remark" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-md-6 col-xl-8 text-right">
                                    <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                     <input type="hidden" name="categoryCd" value="<?php echo $categoryCd; ?>" >
                                     <input type="hidden" name="isActive" value="<?php echo $isActive; ?>" >
                                     <div id="submitmsgsuccess" class="controls alert alert-success text-center" role="alert" style="display: none;"></div>
                                     <div id="submitmsgfailed"  class="controls alert alert-danger text-center" role="alert" style="display: none;"></div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-xl-4 text-right">
                                     <label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                     <div class="controls text-right">
                                        <button id="submitCategoryMasterBtnId" type="button" class="btn btn-primary" onclick="submitCategoryMasterFormData()" > Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
           
        </div>
        <div class="col-lg-3 col-md-6 col-12">
            
        </div>
        <div class="col-lg-3 col-md-6 col-12">
          
        </div>
    </div> -->
</section>

<script>
    // (function(){
    //     getCategoryMasterTable();
    // })();
</script>
<div id="catMasterTblId">
    <?php include 'datatbl/tblCategoryMaster.php';  ?>
</div>


         