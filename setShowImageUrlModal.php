<?php

session_start();
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('Asia/Kolkata');

// include 'api/includes/DbOperation.php';

$shopDetail = array();

if( $_SERVER['REQUEST_METHOD'] === "POST" ) {
    if(isset($_GET['imageFileUrl']) && !empty($_GET['imageFileUrl']) ){

        try  
            {  
                $_SESSION['SAL_ElectionName'] = $_GET['electionName'];
                $imageFileUrl = $_GET['imageFileUrl'];
                $docType = $_GET['docType'];
                
            ?>
                  <!--   <div class="deal" style="background-image: url('<?php echo $imageFileUrl; ?>')">
                        
                    </div> -->

                    <style type="text/css">
                        /* embed.docimg{
                            position: relative;
                            z-index: 111;
                            transition: 0.4s ease;
                            transform-origin: 10% 30%;

                        }
                        embed.docimg:hover{
                            z-index: 111;
                            transform: scale(2.2); 
                            position: relative;
                        }*/

                        .modal-open .modal {
                           overflow: hidden;
                         }
                         .modal-body {
                           height: calc(100vh - 126px);
                           overflow-y:scroll;
                         }
                    </style>

                    <embed width="100%" height="100%" <?php if($docType=='image'){ ?> <?php }else if($docType=='pdf'){ ?> type="application/pdf" <?php } ?> class="rounded docimg" src="<?php echo $imageFileUrl; ?>" ></embed>


            <?php
               
             
            } 
            catch(Exception $e)  
            {  
                echo("Error!");  
            }
                                                              

      }else{

    }
}
?>