<?php
    session_start();
    include '../../api/includes/DbOperation.php';

    $db=new DbOperation();
    $userName=$_SESSION['SAL_UserName'];
    $appName=$_SESSION['SAL_AppName'];
    $electionName=$_SESSION['SAL_ElectionName'];
    $developmentMode=$_SESSION['SAL_DevelopmentMode'];
    
    $updatedByUser = $userName;

    
    $Shop_Cd = '';

    $EstablishmentName= '';
    $NatureofBusiness= '';
    $ShopkeeperName= '';
    $ShopkeeperMobileNo= '';
    $IsCertificateIssuedPreviously = '';
    
    $DueDateofLicenseRenewal = '';
    $LetterGiventoShopkeeper = '';
    $SecondaryContactNumber = '';
    $AddressLine1 = '';
    $AddressLine2 = '';
    $EstablishmentImages = '';
    $EstablishmentImages2 = '';

    $UploadShopBasicInfoData = array();

        $action = '';
        $action = $_POST['action'];
        $Shop_Cd = $_POST['Shop_Cd'];

        $EstablishmentName = $_POST['EstablishmentName'];
        $NatureofBusiness = $_POST['NatureofBusiness'];
        $ShopkeeperName = $_POST['ShopkeeperName'];
        $ShopkeeperMobileNo = $_POST['ShopkeeperMobileNo'];
        $IsCertificateIssuedPreviously = $_POST['IsCertificateIssuedPreviously'];
        
        $DueDateofLicenseRenewal = $_POST['DueDateofLicenseRenewal'];

        $RenewalDate = date("Y-m-d", strtotime($DueDateofLicenseRenewal));
        

        $LetterGiventoShopkeeper = $_POST['LetterGiventoShopkeeper'];
        $SecondaryContactNumber = $_POST['SecondaryContactNumber'];
        $AddressLine1 = $_POST['AddressLine1'];
        $AddressLine2 = $_POST['AddressLine2'];

        $oldEstablishmentImages = $_POST['oldEstablishmentImages'];
        
        $oldEstablishmentImages2 = $_POST['oldEstablishmentImages2'];
        
        



//Establishment Image 1 Outside Upload Code -----------------------------------------------------------------------------------
        if(isset($_FILES['EstablishmentImages']['name']))
        {
            //Starts from here 
            $target_path1 = "../uploads/ShopBasicInfo/Establishment_Image_1_Outside/";

            $temp = explode(".", $_FILES["EstablishmentImages"]["name"]);
            $target_filename = round(microtime(true)) . '_' . $electionName . '_' . $Shop_Cd . '.' . end($temp);
            $target_path1 = $target_path1 . $target_filename;

            // file extension
            $file_extension = pathinfo($target_path1, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);
         
            // Valid extensions
            $valid_ext = array("jpg","png","jpeg");

            if(in_array($file_extension,$valid_ext))
            {
                if (move_uploaded_file($_FILES['EstablishmentImages']['tmp_name'], $target_path1)) 
                {

                    $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
                            "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .
                        $_SERVER['REQUEST_URI'];
            
                    $file_Name_php = basename($link);
                    $new_link = str_replace($file_Name_php, '', $link);
            
                    $EstablishmentImages = $new_link . $target_path1;
                }
            }
        }
    
        if(isset($_FILES['EstablishmentImages']['name']) && empty($_FILES['EstablishmentImages']['name']))
        {
            $EstablishmentImages = $oldEstablishmentImages;
        }



//Establishment Image 1 Outside Upload Code Ends -----------------------------------------------------------------------------------

//Establishment Image 2 Outside Upload Code Starts-----------------------------------------------------------------------------------

        if(isset($_FILES['EstablishmentImages2']['name']))
        {
            //Starts from here 
            $target_path1 = "../uploads/ShopBasicInfo/Establishment_Image_2_Outside/";

            $temp = explode(".", $_FILES["EstablishmentImages2"]["name"]);
            $target_filename = round(microtime(true)) . '_' . $electionName . '_' . $Shop_Cd . '.' . end($temp);
            $target_path1 = $target_path1 . $target_filename;

            // file extension
            $file_extension = pathinfo($target_path1, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);
         
            // Valid extensions
            $valid_ext = array("jpg","png","jpeg");

            if(in_array($file_extension,$valid_ext))
            {
                if (move_uploaded_file($_FILES['EstablishmentImages2']['tmp_name'], $target_path1)) 
                {

                    $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
                            "https" : "http") . "://" . $_SERVER['HTTP_HOST'] .
                        $_SERVER['REQUEST_URI'];
            
                    $file_Name_php = basename($link);
                    $new_link = str_replace($file_Name_php, '', $link);
            
                    $EstablishmentImages2 = $new_link . $target_path1;
                }
            }
        }
    
        if(isset($_FILES['EstablishmentImages2']['name']) && empty($_FILES['EstablishmentImages2']['name']))
        {
            $EstablishmentImages2 = $oldEstablishmentImages2;
        }

//Establishment Image 2 Outside Upload Code Ends-----------------------------------------------------------------------------------

    
    $querySel = "SELECT Shop_Cd FROM ShopMaster WHERE Shop_Cd = $Shop_Cd AND IsActive = 1";
    $dataSel = $db->ExecutveQuerySingleRowSALData($querySel, $electionName, $developmentMode);

    if(sizeof($dataSel)>0)
    {

          $sql2 = "UPDATE ShopMaster SET
                    ShopName = N'$EstablishmentName',
                    ShopKeeperName = N'$ShopkeeperName',
                    ShopKeeperMobile = N'$ShopkeeperMobileNo', 
                    IsCertificateIssued = $IsCertificateIssuedPreviously, 
                    RenewalDate =  '$RenewalDate', 
                    LetterGiven = '$LetterGiventoShopkeeper', 
                    ShopContactNo_2 = N'$SecondaryContactNumber',
                    ShopAddress_1 = N'$AddressLine1', 
                    ShopAddress_2 = N'$AddressLine2', 
                    ShopOutsideImage1 = N'$EstablishmentImages', 
                    ShopOutsideImage2 = N'$EstablishmentImages2',
                    BusinessCat_Cd = $NatureofBusiness,
                    UpdatedByUser = '$updatedByUser',
                    UpdatedDate = GETDATE()
                WHERE Shop_Cd = $Shop_Cd;";
        
        $executeBasicShop = $db->RunQueryData($sql2, $electionName, $developmentMode);

        if($executeBasicShop){
            $UploadShopBasicInfoData = array('Flag' => 'U' );
        }

        // $UploadShopBasicInfoData = $db->UploadShopBasicInfoData($userName, $appName, $electionName, $developmentMode,
        //             $Shop_Cd, $EstablishmentName, $NatureofBusiness, $ShopkeeperName,
        //             $ShopkeeperMobileNo, $IsCertificateIssuedPreviously, $RenewalDate,
        //             $LetterGiventoShopkeeper, $SecondaryContactNumber, $AddressLine1, 
        //             $AddressLine2, $EstablishmentImages, $EstablishmentImages2, $updatedByUser);

    }
    else
    {
        echo json_encode(array('statusCode' => 404, 'msg' => 'Error!! Data Not Updated!'));
        $success = false;
        header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'&success='.$success."&tab=basic-info");
    }


    if (sizeof($UploadShopBasicInfoData) > 0) {

        $flag = $UploadShopBasicInfoData['Flag'];

        if($flag == 'U') {
            echo json_encode(array('statusCode' => 204, 'msg' => 'Updated successfully!'));
            $success = true;
            header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'&success='.$success."&tab=basic-info");
        } elseif($flag == 'I'){
            echo json_encode(array('statusCode' => 200, 'msg' => 'Insert successfully!'));
            $success = true;
            header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'&success='.$success."&tab=basic-info");
        } 
    }
    else
    {
        echo json_encode(array('statusCode' => 404, 'msg' => 'Error.. Please try again!'));
        $success = false;
        header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'&success='.$success."&tab=basic-info");
    }

    // header('Location:../home.php?p=shoplist-edit&action='.$action.'&Shop_Cd='.$Shop_Cd.'');
?>
