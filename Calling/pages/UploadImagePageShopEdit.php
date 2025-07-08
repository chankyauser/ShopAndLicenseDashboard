                  

<div class="row">

     <?php foreach($DocumentUploadList as $list){?>
        
            <div class="col-12 col-sm-4">
            <form action="action/saveShopDocumentsUpload.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="controls">
                            <label><?php echo $list['DocumentName'];?></label> 
                            
                            <?php if($list['DocumentName'] == 'C.C. , O.C. Document' || $list['DocumentName'] == 'Shop Act'
                                    || $list['DocumentName'] == 'Fire Challan' || $list['DocumentName'] == 'NOC of Society' 
                                    || $list['DocumentName'] == 'Rent Agreement if Applicable' || $list['DocumentName'] == 'Property Tax Challan'
                                    || $list['DocumentName'] == 'Water Tax Challan'){
                            ?>  
                            <label style="color:red;">*</label>
                            <?php } ?>

                            <input type="file" name="fileupload_<?php echo $list['Document_Cd'];?>" 
                                                id="fileupload_<?php echo $list['Document_Cd'];?>" 
                                                class="form-control" >
                                                


                            <input type="hidden" name="Document_Cd_<?php echo $list['Document_Cd'];?>" 
                                                value="<?php echo $list['Document_Cd'];?>">

                            <br>
                            
                                <embed src="<?php
                                foreach($DocumentFileData as $key => $value){
                                    if($value['Document_Cd'] == $list['Document_Cd']){
                                            echo $value['FileURL'];
                                    }
                                }
                                ?>" id="filePreview_<?php echo $list['Document_Cd'];?>" 
                                    name="filePreview_<?php echo $list['Document_Cd'];?>" 
                                    style="width: 150px; height: 150px;border-style: solid; border-width: 2px;"/>
                            

                            <!-- <img src="<?php
                                    // foreach($DocumentFileData as $key => $value){
                                    //     if($value['Document_Cd'] == $list['Document_Cd']){
                                    //             echo $value['FileURL'];
                                    //     }
                                    // }
                                    ?>" id="filePreview_<?php //echo $list['Document_Cd'];?>" 
                                        name="filePreview_<?php //echo $list['Document_Cd'];?>" 
                                        style="width: 150px; height: 150px;border-style: solid; border-width: 2px;"/> -->
                                    
                        </div>
                    </div>

                    <div>
                        <input type="hidden" id="Shop_Cd" name="Shop_Cd" value="<?php echo $Shop_Cd; ?>" >
                        <input type="hidden" id="ShopName" name="ShopName" value="<?php echo $getShopName; ?>" >
                        <input type="hidden" id="action" name="action" value="<?php echo $action; ?>" >
                    </div>
                    <div>
                        <button type="button" style="margin-top:-150px;margin-left:234px;padding-left:5px;padding-right:5px;padding-top:5px;padding-bottom:5px;" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1" ><a href="action/deleteDocumentsFromEditPage.php?action=<?php echo $action;?>&Shop_Cd=<?php echo $Shop_Cd; ?>&Document_Cd=<?php echo $list['Document_Cd'];?>" style="color:white;">Delete</a></button>
                    </div>

                    <div>
                        <button type="submit" id="submit" style="margin-top:-130px;margin-left:233px;padding-left:5px;padding-right:5px;padding-top:5px;padding-bottom:5px;" class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1" >Upload</button>
                    </div>
                   
                    </form>    
            </div> 
            
    <?php } ?>
    
</div>

<script>
<?php foreach($DocumentUploadList as $list){ 
    $Document_Cd = $list['Document_Cd'];
    $DocumentName = $list['DocumentName'];
?>
    fileupload_<?php echo $list['Document_Cd'];?>.onchange = evt => {
    const [file] = fileupload_<?php echo $list['Document_Cd'];?>.files
    if (file) {
        filePreview_<?php echo $list['Document_Cd'];?>.src = URL.createObjectURL(file)
    }

    }
<?php } ?>

<?php foreach($DocumentUploadList as $list){ 
    $Document_Cd = $list['Document_Cd'];
    $DocumentName = $list['DocumentName'];
?>
function fileValidation() {
    var fileInput = document.getElementById('fileupload_<?php echo $list['Document_Cd'];?>');
      
    var filePath = fileInput.value;
  
    // Allowing file type
    var allowedExtensions = 
            /(\.jpg|\.jpeg|\.png|\.pdf)$/i;


    if (!allowedExtensions.exec(filePath)) {
        alert('Invalid file type!!!\njpg, jpeg ,pdf & png allowed only');
        fileInput.value = '';
        return false;
    }
    if (typeof (fileInput.files) != "undefined") {

        var size = parseFloat(fileInput.files[0].size / 1024).toFixed(2);

        if(size > 500) {

            alert('Please select image size less than 500 KB');
            fileInput.value = '';
            return false;
        }
    }
    else 
    {   }
}
<?php } ?>
</script>