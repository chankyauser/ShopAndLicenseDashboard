<style type="text/css">
    img.galleryimg{
        transition: 0.4s ease;
        transform-origin: 50% 50%;
    }

    img.galleryimg:hover{
        z-index: 999999;
        transform: scale(3.2);
    }

    .avatar {
        background-color: transparent;
    }
</style>

<div class="content-body">
    <section id="dashboard-analytics">

    <?php
            
        
            
            // $currentDate = date('Y-m-d', strtotime('-2 days'));
            $currentDate = date('Y-m-d');
            $curDate = date('Y');
            $from_Date = $currentDate;
            $to_Date = $currentDate;
           
            

            

?>
    <div id="qclogDetailId">
            <?php include 'datatbl/tblShopsQCLogDetailData.php';  ?>
    </div>

        

    </section>


</div>