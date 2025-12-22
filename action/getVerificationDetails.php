<?php
session_start();
include '../api/includes/DbOperation.php';
$Document = new DbOperation();

$Shop_Cd = $_POST['Shop_Cd'];
$electionName = $_SESSION['SAL_ElectionName'];
$developmentMode= $_SESSION['SAL_DevelopmentMode'];

$VerificationDetailsQuery = "SELECT COALESCE(aas.Approval_Stage_Id, 0) as Approval_Stage_Id, 
                                    COALESCE(aas.Stage_Number,0) as Stage_Number,
                                    COALESCE(aas.Role_Id,0) as Role_Id,
                                    COALESCE(dm.DValue, '') AS Role_Name,
                                    COALESCE(aad.Status, '') AS Status,
                                    COALESCE(aad.Hold_Remark, '') AS Hold_Remark,
                                    COALESCE(aad.Hold_Remark, '') AS Hold_Remark,
                                    COALESCE(aad.Rejection_Reason, '') AS Rejection_Reason,
                                    COALESCE(aad.Rejection_Remark, '') AS Rejection_Remark,
                                    COALESCE(aad.Updated_By, '') AS Updated_By,
                                    COALESCE(dm2.DValue, '') AS Updated_By_Role_Name,
                                    ISNULL(CONVERT(VARCHAR, aad.Updated_Date, 120), '') AS Updated_Date,
                                    COALESCE(em.ExecutiveName, '') AS Updated_By_Executive_Name
                            FROM Application_Approval_Stages as aas 
                            LEFT JOIN Application_Approval_Details AS aad on aad.Approval_Stage_Id = aas.Approval_Stage_Id AND aad.Shop_Cd = '$Shop_Cd'
                            LEFT JOIN DropDownMaster AS dm ON aas.Role_Id = dm.DropDown_Cd AND dm.DTitle = 'ApprovalRoles'
                            LEFT JOIN LoginMaster AS lm 
                                ON lm.User_Cd = aad.Updated_By
                            LEFT JOIN DropDownMaster AS dm2 
                                ON lm.Role_Id = dm2.DropDown_Cd AND dm2.DTitle = 'ApprovalRoles'
                            LEFT JOIN Survey_Entry_Data.dbo.Executive_Master AS em
                                ON lm.Executive_Cd = em.Executive_Cd
                            WHERE aas.IsActive = 1 ";

$VerificationDetails = $Document->ExecutveQueryMultipleRowSALData($VerificationDetailsQuery, $electionName, $developmentMode);


$RejectionReasonsQuery = "SELECT COALESCE(ddm.DropDown_Cd, '') AS DropDown_Cd,
                                 COALESCE(ddm.DValue, '') AS Reason_Text
                          FROM DropDownMaster AS ddm
                          WHERE ddm.DTitle = 'RejectionReasons'";
$RejectionReasons = $Document->ExecutveQueryMultipleRowSALData($RejectionReasonsQuery, $electionName, $developmentMode);


echo json_encode([
    'verifications' => $VerificationDetails ?: [],
    'reasons' => $RejectionReasons ?: []
]);
?>
