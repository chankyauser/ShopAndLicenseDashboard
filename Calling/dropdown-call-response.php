
<!-- <div class="col-sm-12"> -->
<div class="form-group">
        <label>Calling Response</label>
        <div class="controls">
            <select class="select2 form-control" name="CallResponse">
                <?php 

                    $callingResponse = "All";

                    if(isset($_SESSION['SAL_SHOP_LIST_CallingResponseFilter'])){
                        $callingResponse = $_SESSION['SAL_SHOP_LIST_CallingResponseFilter'];
                    }
                ?>
                        <option <?php echo $callingResponse == 'All' ? 'selected=true' : '';
                                if($callingResponse == 'All'){
                                $_SESSION['SAL_SHOP_LIST_CallingResponseFilter'] = $callingResponse;
                            }
                ?> value="All">All</option>
                <option <?php echo $callingResponse == 'Received' ? 'selected=true' : '';
                                if($callingResponse == 'Received'){
                                $_SESSION['SAL_SHOP_LIST_CallingResponseFilter'] = $callingResponse;
                            }
                ?> value="Received">Received</option>
                <option <?php echo $callingResponse == 'Others' ? 'selected=true' : '';
                                if($callingResponse == 'Others'){
                                $_SESSION['SAL_SHOP_LIST_CallingResponseFilter'] = $callingResponse;
                            }
                ?> value="Others">Others</option>
              
                    
            </select>
        </div>
    </div>
<!-- </div> -->