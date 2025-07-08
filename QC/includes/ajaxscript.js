function validateEmail(emailField){
        // var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        // if (reg.test(emailField.value) == false) 
        // {
        //     alert('Invalid Email Address');
        //     return false;
        // }

        // return true;

        var email = document.getElementById('ShopEmailAddress');
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if (!filter.test(email.value)) {
            alert('Please provide a valid email address');
            email.focus;
            return false;
        }

}

function setShopExecutiveId(qcType){

    $("#Shop_Executive_Id").select2().val(['All']).trigger("change");

}

function setValidateFromAndToDate() {
    var ajaxRequest; // The variable that makes Ajax possible!

    try {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer Browsers
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }

    ajaxRequest.onreadystatechange = function() {
            if (ajaxRequest.readyState == 4) {
                // var ajaxDisplay = document.getElementById('');
                // ajaxDisplay.innerHTML = ajaxRequest.responseText;
                // location.reload(true);
            }
        }
   
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;

    var d1 = Date.parse(fromDate);
    var d2 = Date.parse(toDate);
    if (d1 <= d2) {
 
    }else{
        alert ("Please Check the From And To Date!");
    }
}



function setFromAndToDateInSession() {
    var ajaxRequest; // The variable that makes Ajax possible!

    try {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer Browsers
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }

    ajaxRequest.onreadystatechange = function() {
            if (ajaxRequest.readyState == 4) {
                // var ajaxDisplay = document.getElementById('');
                // ajaxDisplay.innerHTML = ajaxRequest.responseText;
                location.reload(true);
            }
        }
   
    // var electionName = document.getElementsByName('electionName')[0].value;
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;

    var d1 = Date.parse(fromDate);
    var d2 = Date.parse(toDate);
    if (d1 <= d2) {
        // if (electionName === '') {
        //     alert("Please Select Corporation!");
        // } else 
        if (fromDate === '') {
            alert("Please Select From Date!");
        }else if (toDate === '') {
            alert("Please Select To Date!");
        } else {
            // var queryString = "?assignDate=" + assign_date+"&electionName="+electionName;
            var queryString = "?fromDate=" + fromDate+"&toDate=" + toDate;
            ajaxRequest.open("POST", "setFromAndToDateInSession.php" + queryString, true);
            ajaxRequest.send(null);

        }
    }else{
        alert ("Please Check the From And To Date!");
    }
}

function setPaginationPageNoInSession(pageNo) {
     var ajaxRequest; // The variable that makes Ajax possible!

    try {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer Browsers
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }

    ajaxRequest.onreadystatechange = function() {
            if (ajaxRequest.readyState == 4) {
                location.reload(true);
            }
        }
    
    if (pageNo === '') {
        alert("Please Select PageNo!");
    } else {
        var queryString = "?pageNo="+pageNo;
        ajaxRequest.open("POST", "setPaginationPageNoInSession.php" + queryString, true);
        ajaxRequest.send(null);

    }

}

function setElectionHeaderNameInSession(electionName) {
    var ajaxRequest; // The variable that makes Ajax possible!

    try {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer Browsers
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }

    ajaxRequest.onreadystatechange = function() {
            if (ajaxRequest.readyState == 4) {
                // var ajaxDisplay = document.getElementById('');
                // ajaxDisplay.innerHTML = ajaxRequest.responseText;
                location.reload(true);
            }
        }
    
    if (electionName === '') {
        alert("Please Select Corporation!");
    } else {
        var queryString = "?electionName="+electionName;
        ajaxRequest.open("POST", "setElectionNameInSession.php" + queryString, true);
        ajaxRequest.send(null);

    }

}

function setQCShopFilterData() {
    var ajaxRequest; // The variable that makes Ajax possible!

    try {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer Browsers
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }

    ajaxRequest.onreadystatechange = function() {
            if (ajaxRequest.readyState == 4) {
                // location.reload(true);
                window.location.href = 'home.php?p=shop-qc-list';
            }
        }
    
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
    var nodeCd = document.getElementsByName('Ward_No')[0].value;
    var qcType = document.getElementsByName('qcType')[0].value;
    var qcFilter = document.getElementsByName('qcFilter')[0].value;
    var shopStatus = document.getElementsByName('shopStatus')[0].value;
    var shopExecutiveCd = document.getElementsByName('Shop_Executive_Id')[0].value;
    var shopName = document.getElementsByName('shopName')[0].value;
    var shopKeeperMobile = document.getElementsByName('shopKeeperMobile')[0].value;

    if (fromDate === '') {
        alert("Please Select From Date!");
    } else if (toDate === '') {
        alert("Please Select To Date!");
    } else {
        var queryString = "?fromDate="+fromDate+"&toDate="+toDate+"&qcType="+qcType+"&qcFilter="+qcFilter+"&nodeCd="+nodeCd+"&shopExecutiveCd="+shopExecutiveCd+"&shopName="+shopName+"&shopKeeperMobile="+shopKeeperMobile+"&shopStatus="+shopStatus;
        ajaxRequest.open("POST", "setQCShopFilterInSession.php" + queryString, true);
        ajaxRequest.send(null);
    }

}

function setShowApplicationTrackingModal(shopid, schedulecallid, srNo){
    var ajaxRequest; // The variable that makes Ajax possible!

    try {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer Browsers
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }

    ajaxRequest.onreadystatechange = function() {
            if (ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                var ajaxDisplay = document.getElementById('showShopApplicationTracking');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
                $('.zero-configuration').DataTable();
               
                  // Basic Select2 select
                    $(".select2").select2({
                    // the following code is used to disable x-scrollbar when click in select input and
                    // take 100% width in responsive also
                    dropdownAutoWidth: true,
                    width: '100%'
                  });

            }
        }
    
   
    var queryString = "?shopid="+shopid+"&srNo="+srNo+"&schedulecallid="+schedulecallid;
    ajaxRequest.open("POST", "setShowApplicationTrackingByShopModal.php" + queryString, true);
    ajaxRequest.send(null);

}

function setShowShopBoardTypeModal(shopid, schedulecallid, srNo){
    var ajaxRequest; // The variable that makes Ajax possible!

    try {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer Browsers
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }

    ajaxRequest.onreadystatechange = function() {
            if (ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                var ajaxDisplay = document.getElementById('showShopBoardType');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
                $('.zero-configuration').DataTable();
               
                    $(".select2").select2({
                    dropdownAutoWidth: true,
                    width: '100%'
                  });

            }
        }
    
   
    var queryString = "?shopid="+shopid+"&srNo="+srNo+"&schedulecallid="+schedulecallid;
    ajaxRequest.open("POST", "setShowShopBoardTypeModal.php" + queryString, true);
    ajaxRequest.send(null);

}

function setDeleteScheduledShopDetail(schedulecallid){
    var ajaxRequest; // The variable that makes Ajax possible!

    try {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer Browsers
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }

    ajaxRequest.onreadystatechange = function() {
            if (ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
               $('#modalShowApplicationTracking').modal('hide');
            }
        }
    
   
    var queryString = "?schedulecallid="+schedulecallid;
    ajaxRequest.open("POST", "setDeleteScheduledShopDetail.php" + queryString, true);
    ajaxRequest.send(null);

}

function setShowShopBoardDetailForm(schedulecallid,shopid,boardid){
    var ajaxRequest; // The variable that makes Ajax possible!

    try {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer Browsers
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }

    ajaxRequest.onreadystatechange = function() {
        if (ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
            var ajaxDisplay = document.getElementById('shopBoardDetail');
            ajaxDisplay.innerHTML = ajaxRequest.responseText;
            // $('.zero-configuration').DataTable();
            
              // Basic Select2 select
                $(".select2").select2({
                // the following code is used to disable x-scrollbar when click in select input and
                // take 100% width in responsive also
                dropdownAutoWidth: true,
                width: '100%'
              });

        }
    }
    
    var queryString = "?schedulecallid="+schedulecallid+"&shopid="+shopid+"&boardid="+boardid;
    ajaxRequest.open("POST", "setShopBoardDetailAddEdit.php" + queryString, true);
    ajaxRequest.send(null);

}

function setShopListQCForm(shopid, qctype, srNo) {
    var ajaxRequest; // The variable that makes Ajax possible!

    try {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer Browsers
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }

    ajaxRequest.onreadystatechange = function() {
            if (ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                var ajaxDisplay = document.getElementById('setShopQCFormDataId');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
                // $('.zero-configuration').DataTable();
                $('#setShopQCLoaderId').hide();
                $('#setShopQCFormDataId').show();
                
                  // Basic Select2 select
                    $(".select2").select2({
                    // the following code is used to disable x-scrollbar when click in select input and
                    // take 100% width in responsive also
                    dropdownAutoWidth: true,
                    width: '100%'
                  });

            }
        }
    
    $('#setShopQCLoaderId').show();
    $('#setShopQCFormDataId').hide();
    $('html, body').animate({
        scrollTop: $("#setShopQCFormDataId").offset().top - 500
    }, 500);
    var queryString = "?shopid="+shopid+"&qctype="+qctype+"&srNo="+srNo;
    ajaxRequest.open("POST", "setShopListQCFormData.php" + queryString, true);
    ajaxRequest.send(null);


}


function setShopSurveyAndDocumentQCForm(schedulecallid,shopid, qctype, srNo) {
    var ajaxRequest; // The variable that makes Ajax possible!

    try {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer Browsers
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }

    ajaxRequest.onreadystatechange = function() {
            if (ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                var ajaxDisplay = document.getElementById('setShopQCFormDataId');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
                // $('.zero-configuration').DataTable();
                $('#setShopQCLoaderId').hide();
                $('#setShopQCFormDataId').show();
                    
                    // Basic Select2 select
                    $(".select2").select2({
                    // the following code is used to disable x-scrollbar when click in select input and
                    // take 100% width in responsive also
                    dropdownAutoWidth: true,
                    width: '100%'
                  });
            }
        }
    
    $('#setShopQCLoaderId').show();
    $('#setShopQCFormDataId').hide();
    $('html, body').animate({
        scrollTop: $("#setShopQCFormDataId").offset().top - 500
    }, 500);
    var queryString = "?schedulecallid="+schedulecallid+"&shopid="+shopid+"&qctype="+qctype+"&srNo="+srNo;
    ajaxRequest.open("POST", "setShopSurveyAndDocumentQCFormData.php" + queryString, true);
    ajaxRequest.send(null);


}

function setShopCallingQCForm(schedulecallid,callingid, shopid, qctype, srNo) {
    var ajaxRequest; // The variable that makes Ajax possible!

    try {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer Browsers
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }

    ajaxRequest.onreadystatechange = function() {
            if (ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                var ajaxDisplay = document.getElementById('setShopQCFormDataId');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
                // $('.zero-configuration').DataTable();
                $('#setShopQCLoaderId').hide();
                $('#setShopQCFormDataId').show();
                  // Basic Select2 select
                    $(".select2").select2({
                    // the following code is used to disable x-scrollbar when click in select input and
                    // take 100% width in responsive also
                    dropdownAutoWidth: true,
                    width: '100%'
                  });
            }
        }
    
    $('#setShopQCFormDataId').hide();
    $('#setShopQCLoaderId').show();

    $('html, body').animate({
        scrollTop: $("#setShopQCFormDataId").offset().top - 500
    }, 500);
    var queryString = "?schedulecallid="+schedulecallid+"&callingid="+callingid+"&shopid="+shopid+"&qctype="+qctype+"&srNo="+srNo;
    ajaxRequest.open("POST", "setShopCallingQCFormData.php" + queryString, true);
    ajaxRequest.send(null);


}

function setBusinessCatListForQC(shopCategory, shop_id){
    var ajaxRequest; // The variable that makes Ajax possible!

    try {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer Browsers
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }

    ajaxRequest.onreadystatechange = function() {
            if (ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
                var ajaxDisplay = document.getElementById(shop_id+'_NatureofBusiness');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
                // $('.zero-configuration').DataTable();
                  // Basic Select2 select
                    $(".select2").select2({
                    // the following code is used to disable x-scrollbar when click in select input and
                    // take 100% width in responsive also
                    dropdownAutoWidth: true,
                    width: '100%'
                  });
            }
        }
    

    var queryString = "?shopCategory="+shopCategory+"&shopid="+shop_id;
    ajaxRequest.open("POST", "setBusinessCatListForQCData.php" + queryString, true);
    ajaxRequest.send(null);


}

function saveShopListQCFormData(shop_id){
    var shopid = document.getElementsByName(shop_id+'_Shop_Id')[0].value;
    var executiveId = document.getElementsByName('Executive_Id')[0].value;
    var natureofBusiness = document.getElementsByName(shop_id+'_NatureofBusiness')[0].value;
    var establishmentAreaCategory = document.getElementsByName(shop_id+'_EstablishmentAreaCategory')[0].value;
    var establishmentCategory = document.getElementsByName(shop_id+'_EstablishmentCategory')[0].value;

    var establishmentName = document.getElementsByName(shop_id+'_EstablishmentName')[0].value;
    var establishmentNameMar = document.getElementsByName(shop_id+'_EstablishmentNameMar')[0].value;
    
    var shopkeeperName = document.getElementsByName(shop_id+'_ShopkeeperName')[0].value;
    var shopkeeperMobileNo = document.getElementsByName(shop_id+'_ShopkeeperMobileNo')[0].value;
    var shopContactNo1 = document.getElementsByName(shop_id+'_ShopContactNo_1')[0].value;
    var shopContactNo2 = document.getElementsByName(shop_id+'_ShopContactNo_2')[0].value;

    var shopAddressLine1 = document.getElementsByName(shop_id+'_AddressLine1')[0].value;
    var shopAddressLine2 = document.getElementsByName(shop_id+'_AddressLine2')[0].value;
    var qcTypeMain = document.getElementsByName(shop_id+'_QCType_Main')[0].value;
    var qcType = document.getElementsByName(shop_id+'_QCType')[0].value;
    var qcFlag = document.getElementsByName(shop_id+'_QCFlag')[0].value;
    var qcRemark1 = document.getElementsByName(shop_id+'_QCRemark1')[0].value;
    var qcRemark2 = document.getElementsByName(shop_id+'_QCRemark2')[0].value;
    var qcRemark3 = document.getElementsByName(shop_id+'_QCRemark3')[0].value;
    // console.log(establishmentName);
   if(natureofBusiness=== ''){
        alert('Select Nature of Bussiness!');
   }else  if(establishmentAreaCategory=== ''){
        alert('Select Shop Area Category!');
   }else if(establishmentCategory === ''){
        alert('Select Shop Category!');
   }else if(establishmentName === ''){
        alert('Enter Shop Name!');
   }else if(establishmentNameMar === ''){
        alert('Enter Shop Name in Marathi!');
//    }else if(shopAddressLine1 === ''){
//         alert('Enter Address 1!');
//    }else if(shopkeeperMobileNo !== ''){
//         if(shopkeeperMobileNo.length!==10)
//         {
//             alert('Enter mobile number with 10 digits!');
//         }
//         else if(
//             (shopkeeperMobileNo.charAt(shopkeeperMobileNo.length-10) != 6) &&
//             (shopkeeperMobileNo.charAt(shopkeeperMobileNo.length-10) != 7) &&
//             (shopkeeperMobileNo.charAt(shopkeeperMobileNo.length-10) != 8) &&
//             (shopkeeperMobileNo.charAt(shopkeeperMobileNo.length-10) != 9)
//             )
//         {
//                 alert('Mobile Number Not Valid!');

//         }
   }else if(shopAddressLine2 === ''){
        alert('Enter Address 2!');
   }else if(qcTypeMain === 'ShopSurvey' && shopkeeperMobileNo === ''){
        alert('Enter Mobile No or get Mobile from Survey Executive!');
   }else{
    
    
        $.ajax({
            type: "POST",
            url: 'action/saveShopListQCData.php',
            data: {
                shopid: shopid,
                executiveId: executiveId,
                natureofBusiness: natureofBusiness,
                establishmentAreaCategory: establishmentAreaCategory,
                establishmentCategory: establishmentCategory,
                establishmentName: establishmentName,
                establishmentNameMar: establishmentNameMar,
                shopkeeperName: shopkeeperName,
                shopkeeperMobileNo: shopkeeperMobileNo,
                shopContactNo1: shopContactNo1,
                shopContactNo2: shopContactNo2,
                shopAddressLine1: shopAddressLine1,
                shopAddressLine2: shopAddressLine2,
                qcType: qcType,
                qcFlag: qcFlag,
                qcRemark1: qcRemark1,
                qcRemark2: qcRemark2,
                qcRemark3: qcRemark3
            },
            beforeSend: function() { 
                $('#'+shop_id+'_btnShopListQCId').attr("disabled", true);
            },
            success: function(dataResult) 
            {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    $("#"+shop_id+"_submitmsgsuccess").show()
                    $("#"+shop_id+"_submitmsgsuccess").html(dataResult.message);

                } else if (dataResult.error == true ) {
                    $("#"+shop_id+"_submitmsgfailed").show()
                    $("#"+shop_id+"_submitmsgfailed").html(dataResult.message);

                }
               
                // return data;
            },
            complete: function() {
                    $('#'+shop_id+'_btnShopListQCId').attr("disabled", false);
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
        
   }
    
}

function setShopDimension(ScheduleCall_Id){
    var ShopDimensionLength = document.getElementsByName(ScheduleCall_Id+'_ShopDimensionLength')[0].value;
    var ShopDimensionWidth = document.getElementsByName(ScheduleCall_Id+'_ShopDimensionWidth')[0].value;
    var ShopDimension = parseFloat (parseFloat(ShopDimensionLength) * parseFloat(ShopDimensionWidth) );
    document.getElementsByName(ScheduleCall_Id+'_ShopDimension')[0].value = parseFloat(ShopDimension);
}

function saveShopSurveyQCFormData(ScheduleCall_Id){
    var schedulecallid = document.getElementsByName(ScheduleCall_Id+'_ScheduleCall_Id')[0].value;
    var shopid = document.getElementsByName(ScheduleCall_Id+'_Shop_Id')[0].value;
    var executiveId = document.getElementsByName('Executive_Id')[0].value;

    var consumerNumber = document.getElementsByName(ScheduleCall_Id+'_ConsumerNumber')[0].value;
    var ownedRented = document.getElementsByName(ScheduleCall_Id+'_Owned_Rented')[0].value;
    var shopOwnPeriodYrs = document.getElementsByName(ScheduleCall_Id+'_ShopOwnPeriodYrs')[0].value;
    var shopOwnPeriodMonths = document.getElementsByName(ScheduleCall_Id+'_ShopOwnPeriodMonths')[0].value;
    var shopDimension = document.getElementsByName(ScheduleCall_Id+'_ShopDimension')[0].value;
    var gstNo = document.getElementsByName(ScheduleCall_Id+'_GSTNno')[0].value;
    var parwanaDetCd = document.getElementsByName(ScheduleCall_Id+'_ParwanaDetCd')[0].value;
    var shopContactNo3 = document.getElementsByName(ScheduleCall_Id+'_ShopContactNo_3')[0].value;
    var maleEmp = document.getElementsByName(ScheduleCall_Id+'_MaleEmp')[0].value;
    var femaleEmp = document.getElementsByName(ScheduleCall_Id+'_FemaleEmp')[0].value;
    var otherEmp = document.getElementsByName(ScheduleCall_Id+'_OtherEmp')[0].value;
    var shopOwnerName = document.getElementsByName(ScheduleCall_Id+'_ShopOwnerName')[0].value;
    var shopOwnerMobile = document.getElementsByName(ScheduleCall_Id+'_ShopOwnerMobile')[0].value;
    var shopEmailAddress = document.getElementsByName(ScheduleCall_Id+'_ShopEmailAddress')[0].value;
    var shopOwnerAddress = document.getElementsByName(ScheduleCall_Id+'_ShopOwnerAddress')[0].value;
    var qcType = document.getElementsByName(ScheduleCall_Id+'_QCType')[0].value;
    var qcFlag = document.getElementsByName(ScheduleCall_Id+'_QCFlag')[0].value;
    var qcRemark1 = document.getElementsByName(ScheduleCall_Id+'_QCRemark1')[0].value;
    var qcRemark2 = document.getElementsByName(ScheduleCall_Id+'_QCRemark2')[0].value;
    var qcRemark3 = document.getElementsByName(ScheduleCall_Id+'_QCRemark3')[0].value;
    
  
    if(parwanaDetCd === ''){
        alert('Select Parwana Detail!');
    }else if(ownedRented === ''){
        alert('Select Owned / Rented!');
    }else if(shopEmailAddress.length != 0 && shopEmailAddress.indexOf('@') < 0){
        alert('Enter proper email id!');
    }else{
        $.ajax({
            type: "POST",
            url: 'action/saveShopSurveyQCData.php',
            data: {
                schedulecallid: schedulecallid,
                shopid: shopid,
                executiveId: executiveId,
                

                consumerNumber: consumerNumber,
                ownedRented: ownedRented,
                shopOwnPeriodYrs: shopOwnPeriodYrs,
                shopOwnPeriodMonths: shopOwnPeriodMonths,
                shopDimension: shopDimension,
                gstNo: gstNo,
                parwanaDetCd: parwanaDetCd,
                shopContactNo3: shopContactNo3,
                maleEmp: maleEmp,
                femaleEmp: femaleEmp,
                otherEmp: otherEmp,
                shopOwnerName: shopOwnerName,
                shopOwnerMobile: shopOwnerMobile,
                shopEmailAddress: shopEmailAddress,
                shopOwnerAddress: shopOwnerAddress,
                qcType: qcType,
                qcFlag: qcFlag,
                qcRemark1: qcRemark1,
                qcRemark2: qcRemark2,
                qcRemark3: qcRemark3
            },
            beforeSend: function() { 
                $('#'+ScheduleCall_Id+'_btnShopSurveyQCId').attr("disabled", true);
            },
            success: function(dataResult) 
            {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    $("#"+ScheduleCall_Id+"_submitmsgsuccess").show()
                    $("#"+ScheduleCall_Id+"_submitmsgsuccess").html(dataResult.message);

                } else if (dataResult.error == true ) {
                    $("#"+ScheduleCall_Id+"_submitmsgfailed").show()
                    $("#"+ScheduleCall_Id+"_submitmsgfailed").html(dataResult.message);

                }
               
                // return data;
            },
            complete: function() {

                    $('#'+ScheduleCall_Id+'_btnShopSurveyQCId').attr("disabled", false);
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
   }
    
}


function saveShopBoardDetailFormData(ScheduleCall_Id){
    var schedulecallid = document.getElementsByName(ScheduleCall_Id+'_SHBScheduleCall_Id')[0].value;
    var boardid = document.getElementsByName(ScheduleCall_Id+'_SHBBoard_Id')[0].value;
    var shopid = document.getElementsByName(ScheduleCall_Id+'_SHBShop_Id')[0].value;
    var executiveId = document.getElementsByName('Executive_Id')[0].value;

    var shopBoardType = document.getElementsByName(ScheduleCall_Id+'_ShopBoardType')[0].value;
    var shopBoardHeight = document.getElementsByName(ScheduleCall_Id+'_ShopBoardHeight')[0].value;
    var shopBoardWidth = document.getElementsByName(ScheduleCall_Id+'_ShopBoardWidth')[0].value;
    var isShopBoardActive = document.getElementsByName(ScheduleCall_Id+'_IsShopBoardActive')[0].value;
    var shopBoardPhoto = document.getElementsByName(ScheduleCall_Id+'_ShopBoardPhoto')[0].files; 
    var shopBoardPhotoURL = document.getElementsByName(ScheduleCall_Id+'_ShopBoardPhoto_URL')[0].value; 
    
    var qcType = document.getElementsByName(ScheduleCall_Id+'_SHBQCType')[0].value;
    var qcFlag = document.getElementsByName(ScheduleCall_Id+'_SHBQCFlag')[0].value;
    var qcRemark1 = document.getElementsByName(ScheduleCall_Id+'_SHBQCRemark1')[0].value;
    var qcRemark2 = document.getElementsByName(ScheduleCall_Id+'_SHBQCRemark2')[0].value;
    var qcRemark3 = document.getElementsByName(ScheduleCall_Id+'_SHBQCRemark3')[0].value;
    
  
    if(shopBoardType === ''){
        alert('Select Board Type!');
    }else if(shopBoardHeight === '0'){
        alert('Please Enter Board Height!');
    }else if(shopBoardWidth === '0'){
        alert('Please Enter Board Width!');
    }else{

        var formData = new FormData();
        formData.append("file", shopBoardPhoto[0]);
        formData.append("schedulecallid", schedulecallid);
        formData.append("boardid", boardid);
        formData.append("shopid", shopid);
        formData.append("executiveId", executiveId);
        formData.append("shopBoardType", shopBoardType);
        formData.append("shopBoardHeight", shopBoardHeight);
        formData.append("shopBoardWidth", shopBoardWidth);
        formData.append("shopBoardPhotoURL", shopBoardPhotoURL);
        formData.append("isShopBoardActive", isShopBoardActive);
        formData.append("qcType", qcType);
        formData.append("qcFlag", qcFlag);
        formData.append("qcRemark1", qcRemark1);
        formData.append("qcRemark2", qcRemark2);
        formData.append("qcRemark3", qcRemark3);

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: 'action/saveShopBoardQCData.php',
            data : formData,
            mimeTypes:"multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() { 
                $('#'+ScheduleCall_Id+'_btnShopBoardId').attr("disabled", true);
            },
            success: function(dataResult) 
            {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    $("#"+ScheduleCall_Id+"_submitmsgsuccessSHB").show()
                        
                    $("#"+ScheduleCall_Id+"_submitmsgsuccessSHB").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("#"+ScheduleCall_Id+"_submitmsgsuccessSHB").append("");
                            $('#modalShowShopBoardType').modal('hide');
                        }).delay(3000).fadeOut("fast");

                } else if (dataResult.error == true ) {
                    $("#"+ScheduleCall_Id+"_submitmsgfailedSHB").show()
                    $("#"+ScheduleCall_Id+"_submitmsgfailedSHB").html(dataResult.message);

                }
               
                // return data;
            },
            complete: function() {

                    $('#'+ScheduleCall_Id+'_btnShopBoardId').attr("disabled", false);
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
   }
    
}



function uploadShopDocumentQCFormData(docId,docDetId,docdetId_schedule_id,scheduleCall_id){
    var schedulecallid = document.getElementsByName(scheduleCall_id+'_DOC_ScheduleCall_Id')[0].value;
    var shopid = document.getElementsByName(scheduleCall_id+'_Shop_Id')[0].value;
    var executiveId = document.getElementsByName('Executive_Id')[0].value;
    var qcType = document.getElementsByName(scheduleCall_id+'_DOCQCType')[0].value;
    var qcFlag = document.getElementsByName(scheduleCall_id+'_DOCQCFlag')[0].value;

    var shopDocumentPhoto = document.getElementsByName(docId+'_Doc')[0].files; 
    // console.log(shopDocumentPhoto);
       
    if (typeof shopDocumentPhoto !== 'undefined' && shopDocumentPhoto.length > 0) {
       
        var formData = new FormData();
        formData.append("file", shopDocumentPhoto[0]);
        formData.append("schedulecallid", schedulecallid);
        formData.append("shopid", shopid);
        formData.append("executiveId", executiveId);
        formData.append("qcType", qcType);
        formData.append("qcFlag", qcFlag);
        formData.append("docDetId", docDetId);
        
      $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: 'action/uploadShopDocumentQCData.php',
            data : formData,
            mimeTypes:"multipart/form-data",
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() { 
                $('#'+docdetId_schedule_id+'_btnShopDocumentUploadQCId').attr("disabled", true);
            },
            success: function(dataResult) 
            {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    $("#"+docdetId_schedule_id+"_submitmsgsuccessDocDet").show()
                        
                    $("#"+docdetId_schedule_id+"_submitmsgsuccessDocDet").html(dataResult.message);

                } else if (dataResult.error == true ) {
                    $("#"+docdetId_schedule_id+"_submitmsgfailedDocDet").show()
                    $("#"+docdetId_schedule_id+"_submitmsgfailedDocDet").html(dataResult.message);

                }
               
                // return data;
            },
            complete: function() {

                    $('#'+docdetId_schedule_id+'_btnShopDocumentUploadQCId').attr("disabled", false);
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
    
    }else{
        alert("Select Documents Photo");
    }
        
    
}

function saveShopDocumentQCFormData(scheduleCall_id){
    var schedulecallid = document.getElementsByName(scheduleCall_id+'_DOC_ScheduleCall_Id')[0].value;
    var shopid = document.getElementsByName(scheduleCall_id+'_Shop_Id')[0].value;
    var executiveId = document.getElementsByName('Executive_Id')[0].value;
    var selectedDocumentIds = document.getElementsByName(scheduleCall_id+'_selectedDocumentIds')[0].value;
    var docQCAction = document.getElementsByName(scheduleCall_id+'_docQCAction')[0].value;
    var shopQCFlag = document.getElementsByName(scheduleCall_id+'_Shop_QCFlag')[0].value;
    var qcType = document.getElementsByName(scheduleCall_id+'_DOCQCType')[0].value;
    var qcFlag = document.getElementsByName(scheduleCall_id+'_DOCQCFlag')[0].value;
    var qcRemark1 = document.getElementsByName(scheduleCall_id+'_DOCQCRemark1')[0].value;
    var qcRemark2 = document.getElementsByName(scheduleCall_id+'_DOCQCRemark2')[0].value;
    var qcRemark3 = document.getElementsByName(scheduleCall_id+'_DOCQCRemark3')[0].value;
    
   if(selectedDocumentIds=== ''){
        alert('Select Documents!');
   }else if(docQCAction === ''){
        alert('Select Action!');
   }else if(qcRemark1 === ''){
        alert('Enter at least QC Remark 1!');
   }else{
        $.ajax({
            type: "POST",
            url: 'action/saveShopDocumentQCData.php',
            data: {
                schedulecallid: schedulecallid,
                shopid: shopid,
                executiveId: executiveId,
                selectedDocumentIds: selectedDocumentIds,
                docQCAction: docQCAction,
                qcType: qcType,
                qcFlag: qcFlag,
                qcRemark1: qcRemark1,
                qcRemark2: qcRemark2,
                qcRemark3: qcRemark3
            },
            beforeSend: function() { 
                $('#'+scheduleCall_id+'_btnShopDocumentQCId').attr("disabled", true);
            },
            success: function(dataResult) 
            {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    $("#"+scheduleCall_id+"_submitmsgsuccessDC").show();
                    $("#"+scheduleCall_id+"_submitmsgsuccessDC").html(dataResult.message);

                } else if (dataResult.error == true ) {
                    $("#"+scheduleCall_id+"_submitmsgfailedDC").show();
                    $("#"+scheduleCall_id+"_submitmsgfailedDC").html(dataResult.message);

                }
               
                // return data;
            },
            complete: function() {
                    $('#'+scheduleCall_id+'_btnShopDocumentQCId').attr("disabled", false);
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
   }
    
}

function saveShopCallingQCFormData(Calling_Cd_s){
    var callingid_s = document.getElementsByName(Calling_Cd_s+'_Calling_Ids')[0].value;
    var executiveId = document.getElementsByName('Executive_Id')[0].value;
    var audioListen = document.getElementsByName(Calling_Cd_s+'_AudioListen')[0].value;
    var goodCall = document.getElementsByName(Calling_Cd_s+'_GoodCall')[0].value;
    var appreciationCall = document.getElementsByName(Calling_Cd_s+'_AppreciationCall')[0].value;
    var qcType = document.getElementsByName(Calling_Cd_s+'_QCTypeCall')[0].value;
    var qcFlag = document.getElementsByName(Calling_Cd_s+'_QCFlagCall')[0].value;
    
   if(audioListen=== ''){
        alert('Select Audio Listen!');
   }else if(goodCall === ''){
        alert('Select Good Call!');
   }else if(appreciationCall === ''){
        alert('Select Appreciate Call!');
   }else{
        $.ajax({
            type: "POST",
            url: 'action/saveShopCallingQCData.php',
            data: {
                callingid_s: callingid_s,
                executiveId: executiveId,
                audioListen: audioListen,
                goodCall: goodCall,
                appreciationCall: appreciationCall,
                qcType: qcType,
                qcFlag: qcFlag
            },
            beforeSend: function() { 
                $('#'+Calling_Cd_s+'_btnShopCallingQCId').attr("disabled", true);
            },
            success: function(dataResult) 
            {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    $("#"+Calling_Cd_s+"_submitmsgsuccessCall").show();
                    $("#"+Calling_Cd_s+"_submitmsgsuccessCall").html(dataResult.message);

                } else if (dataResult.error == true ) {
                    $("#"+Calling_Cd_s+"_submitmsgfailedCall").show();
                    $("#"+Calling_Cd_s+"_submitmsgfailedCall").html(dataResult.message);

                }
                // return data;
            },
            complete: function() {
                    $('#'+Calling_Cd_s+'_btnShopCallingQCId').attr("disabled", false);
                }
        });
   }
    
}


function saveShopCallingSurveyQCFormData(ScheduleCall_Id){
   
    var callingid = document.getElementsByName(ScheduleCall_Id+'_Calling_Id')[0].value;
    var schedulecallid = document.getElementsByName(ScheduleCall_Id+'_ScheduleCall_Id')[0].value;
    var shopid = document.getElementsByName(ScheduleCall_Id+'_Shop_Id')[0].value;
    var executiveId = document.getElementsByName('Executive_Id')[0].value;

    var natureofBusiness = document.getElementsByName(shop_id+'_NatureofBusiness')[0].value;
    var establishmentAreaCategory = document.getElementsByName(shop_id+'_EstablishmentAreaCategory')[0].value;
    var establishmentCategory = document.getElementsByName(shop_id+'_EstablishmentCategory')[0].value;

    var establishmentName = document.getElementsByName(shop_id+'_EstablishmentName')[0].value;
    var establishmentNameMar = document.getElementsByName(shop_id+'_EstablishmentNameMar')[0].value;
    
    var shopkeeperName = document.getElementsByName(shop_id+'_ShopkeeperName')[0].value;
    var shopkeeperMobileNo = document.getElementsByName(shop_id+'_ShopkeeperMobileNo')[0].value;
    var shopContactNo1 = document.getElementsByName(shop_id+'_ShopContactNo_1')[0].value;
    var shopContactNo2 = document.getElementsByName(shop_id+'_ShopContactNo_2')[0].value;

    var shopAddressLine1 = document.getElementsByName(shop_id+'_AddressLine1')[0].value;
    var shopAddressLine2 = document.getElementsByName(shop_id+'_AddressLine2')[0].value;

    var consumerNumber = document.getElementsByName(ScheduleCall_Id+'_ConsumerNumber')[0].value;
    var ownedRented = document.getElementsByName(ScheduleCall_Id+'_Owned_Rented')[0].value;
    var shopOwnPeriodYrs = document.getElementsByName(ScheduleCall_Id+'_ShopOwnPeriodYrs')[0].value;
    var shopOwnPeriodMonths = document.getElementsByName(ScheduleCall_Id+'_ShopOwnPeriodMonths')[0].value;
    var shopDimension = document.getElementsByName(ScheduleCall_Id+'_ShopDimension')[0].value;
    var gstNo = document.getElementsByName(ScheduleCall_Id+'_GSTNno')[0].value;
    var parwanaDetCd = document.getElementsByName(ScheduleCall_Id+'_ParwanaDetCd')[0].value;
    var shopContactNo3 = document.getElementsByName(ScheduleCall_Id+'_ShopContactNo_3')[0].value;
    var maleEmp = document.getElementsByName(ScheduleCall_Id+'_MaleEmp')[0].value;
    var femaleEmp = document.getElementsByName(ScheduleCall_Id+'_FemaleEmp')[0].value;
    var otherEmp = document.getElementsByName(ScheduleCall_Id+'_OtherEmp')[0].value;
    var shopOwnerName = document.getElementsByName(ScheduleCall_Id+'_ShopOwnerName')[0].value;
    var shopOwnerMobile = document.getElementsByName(ScheduleCall_Id+'_ShopOwnerMobile')[0].value;
    var shopEmailAddress = document.getElementsByName(ScheduleCall_Id+'_ShopEmailAddress')[0].value;
    var shopOwnerAddress = document.getElementsByName(ScheduleCall_Id+'_ShopOwnerAddress')[0].value;
    
    var qcCallingCategory = document.getElementsByName(ScheduleCall_Id+'_CallingCategory')[0].value;

    var qcTypeMain = document.getElementsByName(shop_id+'_QCTypeMain')[0].value;
    var qcType = document.getElementsByName(ScheduleCall_Id+'_QCType')[0].value;
    var qcFlag = document.getElementsByName(ScheduleCall_Id+'_QCFlag')[0].value;
    var qcRemark1 = document.getElementsByName(ScheduleCall_Id+'_QCRemark1')[0].value;
    var qcRemark2 = document.getElementsByName(ScheduleCall_Id+'_QCRemark2')[0].value;
    var qcRemark3 = document.getElementsByName(ScheduleCall_Id+'_QCRemark3')[0].value;
    
  
    if(natureofBusiness=== ''){
        alert('Select Nature of Bussiness!');
    }else  if(establishmentAreaCategory=== ''){
        alert('Select Shop Area Category!');
    }else if(establishmentCategory === ''){
        alert('Select Shop Category!');
    }else if(establishmentName === ''){
        alert('Enter Shop Name!');
    }else if(establishmentNameMar === ''){
        alert('Enter Shop Name in Marathi!');
    }else if(shopAddressLine1 === ''){
        alert('Enter Address 1!');
    }else if(shopAddressLine2 === ''){
        alert('Enter Address 2!');
    }else if(qcTypeMain === 'ShopCalling' && shopkeeperMobileNo === ''){
        alert('Enter Mobile No or get Mobile from Survey Executive!');
    }else if(parwanaDetCd === ''){
        alert('Select Parwana Detail!');
    }else if(ownedRented === ''){
        alert('Select Owned / Rented!');
    }else if(shopEmailAddress.length != 0 && shopEmailAddress.indexOf('@') < 0){
        alert('Enter proper email id!');
    }else{
        $.ajax({
            type: "POST",
            url: 'action/saveShopCallingSurveyQCData.php',
            data: {
                callingid: callingid,
                schedulecallid: schedulecallid,
                shopid: shopid,
                executiveId: executiveId,
                
                natureofBusiness: natureofBusiness,
                establishmentAreaCategory: establishmentAreaCategory,
                establishmentCategory: establishmentCategory,
                establishmentName: establishmentName,
                establishmentNameMar: establishmentNameMar,
                shopkeeperName: shopkeeperName,
                shopkeeperMobileNo: shopkeeperMobileNo,
                shopContactNo1: shopContactNo1,
                shopContactNo2: shopContactNo2,
                shopAddressLine1: shopAddressLine1,
                shopAddressLine2: shopAddressLine2,

                consumerNumber: consumerNumber,
                ownedRented: ownedRented,
                shopOwnPeriodYrs: shopOwnPeriodYrs,
                shopOwnPeriodMonths: shopOwnPeriodMonths,
                shopDimension: shopDimension,
                gstNo: gstNo,
                parwanaDetCd: parwanaDetCd,
                shopContactNo3: shopContactNo3,
                maleEmp: maleEmp,
                femaleEmp: femaleEmp,
                otherEmp: otherEmp,
                shopOwnerName: shopOwnerName,
                shopOwnerMobile: shopOwnerMobile,
                shopEmailAddress: shopEmailAddress,
                shopOwnerAddress: shopOwnerAddress,

                qcCallingCategory: qcCallingCategory,
                
                qcTypeMain: qcTypeMain,
                qcType: qcType,
                qcFlag: qcFlag,
                qcRemark1: qcRemark1,
                qcRemark2: qcRemark2,
                qcRemark3: qcRemark3
            },
            beforeSend: function() { 
                $('#'+ScheduleCall_Id+'_btnShopCallingSurveyQCId').attr("disabled", true);
            },
            success: function(dataResult) 
            {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    $("#"+ScheduleCall_Id+"_submitmsgsuccess").show()
                    $("#"+ScheduleCall_Id+"_submitmsgsuccess").html(dataResult.message);

                } else if (dataResult.error == true ) {
                    $("#"+ScheduleCall_Id+"_submitmsgfailed").show()
                    $("#"+ScheduleCall_Id+"_submitmsgfailed").html(dataResult.message);

                }
                // return data;
            },
            complete: function() {

                    $('#'+ScheduleCall_Id+'_btnShopCallingSurveyQCId').attr("disabled", false);
                }
        });
   }
    
}


function setDocQCRemark(scheduleCall_id){
    var selectedDocumentNames = document.getElementsByName(scheduleCall_id+"_selectedDocumentNames")[0].value;  
    var docQCAction = document.getElementsByName(scheduleCall_id+"_docQCAction")[0].value;  
    document.getElementsByName(scheduleCall_id+"_DOCQCRemark1")[0].value = selectedDocumentNames + " " + docQCAction + " Done";
}

function setSelectMultipleDocumentsQC(scheduleCall_id) {
  var input = document.getElementsByName(scheduleCall_id+"_selectDocumentsQCChk");
    // console.log(input);
  
   
  var selected = 0;
  var chkDocDetCd = "";
  var chkDocNames = "";
  for (var i = 0; i < input.length; i++) {
    if (input[i].checked) {
        var splits = input[i].value.split(",");
        var docDetCd = splits[0];
        var docNames = splits[1];
         chkDocDetCd += docDetCd+",";  
         chkDocNames += docNames+",";  
        
        selected ++;
      }
    
  }
  chkDocDetCd = chkDocDetCd.substring(0, chkDocDetCd.length - 1);
  chkDocNames = chkDocNames.substring(0, chkDocNames.length - 1);
  document.getElementsByName(scheduleCall_id+"_selectedDocumentIds")[0].value = "" + chkDocDetCd;
  document.getElementsByName(scheduleCall_id+"_selectedDocumentNames")[0].value = "" + chkDocNames;
  document.getElementsByName(scheduleCall_id+"_selectedDocumentNames")[0].value = "" + chkDocNames;
}



function saveShopScheduleFormData(scheduleCall_id){
    var schedulecallid = document.getElementsByName(scheduleCall_id+'_SCHScheduleCall_Id')[0].value;
    var shopid = document.getElementsByName(scheduleCall_id+'_SCHShop_Id')[0].value;
    var executiveId = document.getElementsByName('Executive_Id')[0].value;
    var scheduleDate = document.getElementsByName(scheduleCall_id+'_SCHScheduleDate')[0].value;
    var scheduleCategory = document.getElementsByName(scheduleCall_id+'_SCHScheduleCategory')[0].value;
    var callReason = document.getElementsByName(scheduleCall_id+'_SCHCallReason')[0].value;
    var remark = document.getElementsByName(scheduleCall_id+'_SCHRemark')[0].value;

   if(scheduleDate=== ''){
        alert('Enter Schedule Date!');
   }else if(scheduleCategory=== ''){
        alert('Select Schedule Category!');
   }else if(callReason === ''){
        alert('Enter Shop Scheduled Reason!');
   }else{
        $.ajax({
            type: "POST",
            url: 'action/saveShopScheduleData.php',
            data: {
                schedulecallid: schedulecallid,
                shopid: shopid,
                executiveId: executiveId,
                scheduleDate: scheduleDate,
                scheduleCategory: scheduleCategory,
                callReason: callReason,
                remark: remark
            },
            beforeSend: function() { 
                $('#'+scheduleCall_id+'_btnShopScheduleId').attr("disabled", true);
            },
            success: function(dataResult) 
            {
                console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    $("#"+scheduleCall_id+"_submitmsgsuccessSCH").show();
                    $("#"+scheduleCall_id+"_submitmsgsuccessSCH").html(dataResult.message);

                } else if (dataResult.error == true ) {
                    $("#"+scheduleCall_id+"_submitmsgfailedSCH").show();
                    $("#"+scheduleCall_id+"_submitmsgfailedSCH").html(dataResult.message);

                }
               
                // return data;
            },
            complete: function() {
                    $('#'+scheduleCall_id+'_btnShopScheduleId').attr("disabled", false);
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
   }
    
}

function saveShopStatusFormData(scheduleCall_id){
    var schedulecallid = document.getElementsByName(scheduleCall_id+'_ShopStatusScheduleCall_Id')[0].value;
    var shopid = document.getElementsByName(scheduleCall_id+'_ShopStatusShop_Id')[0].value;
    var executiveId = document.getElementsByName('Executive_Id')[0].value;
    var shopStatus = document.getElementsByName(scheduleCall_id+'_ShopStatus')[0].value;
    var shopStatusRemark = document.getElementsByName(scheduleCall_id+'_ShopStatusRemark')[0].value;

   if(shopStatus=== ''){
        alert('Select Application Status!');
   }else if(shopStatusRemark === ''){
        alert('Enter Application Status Remark!');
   }else{
        $.ajax({
            type: "POST",
            url: 'action/saveShopStatusData.php',
            data: {
                schedulecallid: schedulecallid,
                shopid: shopid,
                executiveId: executiveId,
                shopStatus: shopStatus,
                shopStatusRemark: shopStatusRemark
            },
            beforeSend: function() { 
                $('#'+scheduleCall_id+'_btnShopStatusId').attr("disabled", true);
            },
            success: function(dataResult) 
            {
                console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    $("#"+scheduleCall_id+"_submitmsgsuccessSS").show();
                    $("#"+scheduleCall_id+"_submitmsgsuccessSS").html(dataResult.message);

                } else if (dataResult.error == true ) {
                    $("#"+scheduleCall_id+"_submitmsgfailedSS").show();
                    $("#"+scheduleCall_id+"_submitmsgfailedSS").html(dataResult.message);

                }
               
                // return data;
            },
            complete: function() {
                    $('#'+scheduleCall_id+'_btnShopStatusId').attr("disabled", false);
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
   }
    
}

function getSearchSocietyList() {
    var ajaxRequest;
    try {
        ajaxRequest = new XMLHttpRequest();
    } catch (e) {
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                alert("Your browser broke!");
                return false;
            }
        }
    }

    ajaxRequest.onreadystatechange = function() {
        if (ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
            var ajaxDisplay = document.getElementById('societyMasterListId');
            ajaxDisplay.innerHTML = ajaxRequest.responseText;
            $('.zero-configuration').DataTable();
            $('html, body').animate({
                scrollTop: $("#societyMasterListId").offset().top
            }, 500);
        }
    }

    var nodeName = document.getElementsByName('nodeName')[0].value;
    var filterBy = document.getElementsByName('filterBy')[0].value;
    var searchValue = document.getElementsByName('searchValue')[0].value;
    
    if (nodeName === '') {
        alert("Please Select Node Name!");
    } else if (filterBy === '') {
        alert("Please Select Filter By!");
    } else if (searchValue === '') {
        alert("Please Select Search Value!");
    } else {
        var queryString = "?nodeName=" + nodeName+"&filterBy="+filterBy + "&searchValue=" +searchValue;
        ajaxRequest.open("POST", "datatbl/tblSearchSocietyMasterData.php" + queryString, true);
        ajaxRequest.send(null);

    }
}



// Basic Info Preview Img
function PreviewImageEstablishmestImgOut1() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("EstablishmentImages").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("EstablishmentImagesView").src = oFREvent.target.result;
    };
};

function EstablishmestImgOut1Validation() {
    var fileInput = 
        document.getElementById('EstablishmentImages');
    
    var filePath = fileInput.value;
    // Allowing file type
    var allowedExtensions = 
            /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        alert('Invalid file type!!!\njpg, jpeg & png allowed only');
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
    {
    
        // Image preview
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(
                    'imagePreview').innerHTML = 
                    '<img src="' + e.target.result
                    + '"/>';
            };
            
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
}


function PreviewImageEstablishmestImgOut2() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("EstablishmentImages2").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("EstablishmentImagesView2").src = oFREvent.target.result;
    };
};

function EstablishmestImgOut2Validation() {
    var fileInput = 
        document.getElementById('EstablishmentImages2');
    
    var filePath = fileInput.value;
    // Allowing file type
    var allowedExtensions = 
            /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        alert('Invalid file type!!!\njpg, jpeg & png allowed only');
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
    {
    
        // Image preview
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(
                    'imagePreview').innerHTML = 
                    '<img src="' + e.target.result
                    + '"/>';
            };
            
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
}
// Basic Info Preview Img


// Advanced Info Preview Img
function PreviewImageBoardType1() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("BoardType1Image").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("BoardType1ImageView").src = oFREvent.target.result;
    };
};

function BoardType1ImageValidation() {
    var fileInput = 
        document.getElementById('BoardType1Image');
    
    var filePath = fileInput.value;
    // Allowing file type
    var allowedExtensions = 
            /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        alert('Invalid file type!!!\njpg, jpeg & png allowed only');
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
    {
    
        // Image preview
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(
                    'imagePreview').innerHTML = 
                    '<img src="' + e.target.result
                    + '"/>';
            };
            
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
}

function PreviewImageBoardTypeQC(scheduleCall_id) {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById(scheduleCall_id+"_ShopBoardPhoto").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById(scheduleCall_id+"_ShopBoardPhoto_URL").src = oFREvent.target.result;
    };
};

function BoardTypeQCImageValidation(scheduleCall_id) {
    var fileInput = 
        document.getElementById(scheduleCall_id+'_ShopBoardPhoto');
    
    var filePath = fileInput.value;
    // Allowing file type
    var allowedExtensions = 
            /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        alert('Invalid file type!!!\njpg, jpeg & png allowed only');
        fileInput.value = '';
        return false;
    } 
    if (typeof (fileInput.files) != "undefined") {

        var size = parseFloat(fileInput.files[0].size / 1024).toFixed(2); 

        if(size > 500) {

            alert('Please select image size less than 500 KB');
            fileInput.value = '';
            return false;
        }else{
            // Image preview
            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(scheduleCall_id+"_ShopBoardPhoto_URL").src = e.target.result;
                };
                
                reader.readAsDataURL(fileInput.files[0]);
           
            }
        }
    }
   
}


function DocumentQCImageValidation(docid) {
    var fileInput = 
        document.getElementById(docid+"_Doc");
    
    var filePath = fileInput.value;
    // Allowing file type
    var allowedExtensions = 
            /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        alert('Invalid file type!!!\njpg, jpeg & png allowed only');
        fileInput.value = '';
        return false;
    } 
    if (typeof (fileInput.files) != "undefined") {

        var size = parseFloat(fileInput.files[0].size / 1024).toFixed(2); 

        if(size > 500) {

            alert('Please select image size less than 500 KB');
            fileInput.value = '';
            return false;
        }else{
            // Image preview
            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(docid+"_Upload").src = e.target.result;
                };
                
                reader.readAsDataURL(fileInput.files[0]);
           
            }

           // document.getElementById(docid+"_Upload").hide();
           // $("#"docid+"_URL"+"").hide();
        }
    }
   
}

function PreviewImageBoardType2() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("BoardType2Image").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("BoardType2ImageView").src = oFREvent.target.result;
    };
};

function BoardType2ImageValidation() {
    var fileInput = 
        document.getElementById('BoardType2Image');
    
    var filePath = fileInput.value;
    // Allowing file type
    var allowedExtensions = 
            /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        alert('Invalid file type!!!\njpg, jpeg & png allowed only');
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
    {
    
        // Image preview
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(
                    'imagePreview').innerHTML = 
                    '<img src="' + e.target.result
                    + '"/>';
            };
            
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
}

function PreviewImageBoardType3() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("BoardType3Image").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("BoardType3ImageView").src = oFREvent.target.result;
    };
};

function BoardType3ImageValidation() {
    var fileInput = 
        document.getElementById('BoardType3Image');
    
    var filePath = fileInput.value;
    // Allowing file type
    var allowedExtensions = 
            /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        alert('Invalid file type!!!\njpg, jpeg & png allowed only');
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
    {
    
        // Image preview
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(
                    'imagePreview').innerHTML = 
                    '<img src="' + e.target.result
                    + '"/>';
            };
            
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
}


function PreviewImageEstablishmentImgIn1() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("ImagesofEstablishment").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("ImagesofEstablishmentView").src = oFREvent.target.result;
    };
};

function ImagesofEstablishment1Validation() {
    var fileInput = 
        document.getElementById('ImagesofEstablishment');
    
    var filePath = fileInput.value;
    // Allowing file type
    var allowedExtensions = 
            /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        alert('Invalid file type!!!\njpg, jpeg & png allowed only');
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
    {
    
        // Image preview
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(
                    'imagePreview').innerHTML = 
                    '<img src="' + e.target.result
                    + '"/>';
            };
            
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
}

function PreviewImageEstablishmentImgIn2() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("ImagesofEstablishment2").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("ImagesofEstablishmentView2").src = oFREvent.target.result;
    };
};

function ImagesofEstablishment2Validation() {
    var fileInput = 
        document.getElementById('ImagesofEstablishment2');
    
    var filePath = fileInput.value;
    // Allowing file type
    var allowedExtensions = 
            /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        alert('Invalid file type!!!\njpg, jpeg & png allowed only');
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
    {
    
        // Image preview
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(
                    'imagePreview').innerHTML = 
                    '<img src="' + e.target.result
                    + '"/>';
            };
            
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
}
// Advanced Info Preview Img


function isNumberKey(evt, obj) {

    var charCode = (evt.which) ? evt.which : event.keyCode
    var value = obj.value;
    var dotcontains = value.indexOf(".") != -1;
    if (dotcontains)
        if (charCode == 46) return false;
    if (charCode == 46) return true;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}


// Calling Module Functions End's Here

function setShopDataValidationData() {
    var ajaxRequest; // The variable that makes Ajax possible!

    try {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer Browsers
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }

    ajaxRequest.onreadystatechange = function() {
            if (ajaxRequest.readyState == 4) {
                // location.reload(true);
                window.location.href = 'home.php?p=shop-data-validation';
            }
        }
    
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
    var nodeCd = document.getElementsByName('Ward_No')[0].value;
    var dataValidation = document.getElementsByName('dataValidation')[0].value;

    // var qcType = document.getElementsByName('qcType')[0].value;
    // var qcFilter = document.getElementsByName('qcFilter')[0].value;
    // var shopStatus = document.getElementsByName('shopStatus')[0].value;
    // var shopName = document.getElementsByName('shopName')[0].value;

    if (fromDate === '') {
        alert("Please Select From Date!");
    } else if (toDate === '') {
        alert("Please Select To Date!");
    }
    else if (dataValidation === '') {
        alert("Please Select Data Validation Type!");
    } else {
        var queryString = "?fromDate="+fromDate+"&toDate="+toDate+"&nodeCd="+nodeCd+"&dataValidation="+dataValidation;
        ajaxRequest.open("POST", "setShopDataValidationInSession.php" + queryString, true);
        ajaxRequest.send(null);
    }

}