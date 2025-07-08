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

function getLicenseRenewalList(){
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
                if (ajaxRequest.readyState == 4) {
                    var ajaxDisplay = document.getElementById('DefaulterListId');
                    ajaxDisplay.innerHTML = ajaxRequest.responseText;
                    window.location.href='home.php?p=shop-license-renewal';
    
                }
            }
        }
      
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
    var pocketCd = document.getElementsByName('pocket_Name')[0].value;
    
        var queryString = "?fromDate="+fromDate+"&toDate="+toDate
        +"&pocketCd="+pocketCd;
        ajaxRequest.open("POST", "setLicenseRenewalList.php" + queryString, true);
        ajaxRequest.send(null);
}


function getShopLicenseDefaulterDetail(){
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
                if (ajaxRequest.readyState == 4) {
                    var ajaxDisplay = document.getElementById('shopLicenseDefaulterDetailId');
                    ajaxDisplay.innerHTML = ajaxRequest.responseText;
                    window.location.href='home.php?p=shop-license-defaulter-details';
    
                }
            }
        }
      
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
    var pocketCd = document.getElementsByName('pocket_Name')[0].value;
    
        var queryString = "?fromDate="+fromDate+"&toDate="+toDate
        +"&pocketCd="+pocketCd;
        ajaxRequest.open("POST", "setShopLicenseDefaulterList.php" + queryString, true);
        ajaxRequest.send(null);
}


function getPocketWiseSurveySummary(){
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
                // var ajaxDisplay = document.getElementById('pocketWiseSurveySummaryId');
                // ajaxDisplay.innerHTML = ajaxRequest.responseText;
                location.reload(true);
            }
        }
        // var splits = partyCd.split(",");
        // var partyCd = splits[0];
        // var party = splits[1];

    // var electionName = document.getElementsByName('electionName')[0].value;
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
    var nodeCd = document.getElementsByName('node_Cd')[0].value;
    // if (electionName === '') {
    //     alert("Please Select Corporation!");
    // }else 
    if (nodeCd === '') {
        alert("Please Select Ward Name!");
    } else {
        // var queryString = "?nodeCd=" + nodeCd+"&electionName="+electionName+"&fromDate="+fromDate+"&toDate="+toDate;
        var queryString = "?nodeCd=" + nodeCd+"&fromDate="+fromDate+"&toDate="+toDate;
        ajaxRequest.open("POST", "setPocketWiseSurveySummary.php" + queryString, true);
        ajaxRequest.send(null);

    }
}

function getPocketWiseSurveyDetail(){
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
                var ajaxDisplay = document.getElementById('pocketWiseSurveyDetailId');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
                window.location.href='home.php?p=shop-survey-details';

            }
        }
   
    // var electionName = document.getElementsByName('electionName')[0].value;
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
    var pocketCd = document.getElementsByName('pocket_Name')[0].value;
    // if (electionName === '') {
    //     alert("Please Select Corporation!");
    // } else 
    if (pocketCd === '') {
        alert("Please Select Pocket!");
    } else {
        // var queryString = "?pocketCd=" + pocketCd+"&electionName="+electionName+"&fromDate="+fromDate+"&toDate="+toDate;
        var queryString = "?pocketCd=" + pocketCd+"&fromDate="+fromDate+"&toDate="+toDate;
        ajaxRequest.open("POST", "setPocketWiseSurveyDetail.php" + queryString, true);
        ajaxRequest.send(null);

    }
}

function getCallingSurveyAllDetail(){
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
                var ajaxDisplay = document.getElementById('shopCallingSurveyDetailId');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
                window.location.href='home.php?p=shop-calling-details';

            }
        }
   
    // var electionName = document.getElementsByName('electionName')[0].value;
    var pocketCd = document.getElementsByName('pocket_Name')[0].value;
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
    var calling_Category = document.getElementsByName('calling_Category')[0].value;
    // if (electionName === '') {
    //     alert("Please Select Corporation!");
    // } else 
    if (pocketCd === '') {
        alert("Please Select Pocket!");
    }
    else if (calling_Category === '') {
        alert("Please Select calling Category!");
    } 
    else {
        // var queryString = "?pocketCd=" + pocketCd+"&electionName="+electionName+"&fromDate="+fromDate+"&toDate="+toDate;
        var queryString = "?calling_Category=" + calling_Category+"&pocketCd=" + pocketCd+"&fromDate="+fromDate+"&toDate="+toDate;
        ajaxRequest.open("POST", "setCallingSurveyAllDetail.php" + queryString, true);
        ajaxRequest.send(null);

    }
}

function getLicenseSurveyAllDetail(){
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
                var ajaxDisplay = document.getElementById('shopLicenseSurveyDetailId');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
                window.location.href='home.php?p=shop-license-details';

            }
        }
   
    // var electionName = document.getElementsByName('electionName')[0].value;
    var pocketCd = document.getElementsByName('pocket_Name')[0].value;
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
    // if (electionName === '') {
    //     alert("Please Select Corporation!");
    // } else 
    if (pocketCd === '') {
        alert("Please Select Pocket!");
    }
    else {
        // var queryString = "?pocketCd=" + pocketCd+"&electionName="+electionName+"&fromDate="+fromDate+"&toDate="+toDate;
        var queryString = "?pocketCd=" + pocketCd+"&fromDate="+fromDate+"&toDate="+toDate;
        ajaxRequest.open("POST", "setLicenseSurveyDetail.php" + queryString, true);
        ajaxRequest.send(null);

    }
}



function getExecutiveWiseSurveyDetail(){
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
                var ajaxDisplay = document.getElementById('executiveWiseSurveyDetailId');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
                window.location.href='home.php?p=executive-wise-survey-detail';

            }
        }
   
    // var electionName = document.getElementsByName('electionName')[0].value;
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
    var executiveCd = document.getElementsByName('executive_Name')[0].value;
    // if (electionName === '') {
    //     alert("Please Select Corporation!");
    // } else 
    if (executiveCd === '') {
        alert("Please Select ExecutiveName!");
    } else {
        // var queryString = "?executiveCd=" + executiveCd+"&electionName="+electionName+"&fromDate="+fromDate+"&toDate="+toDate;
        var queryString = "?executiveCd=" + executiveCd+"&fromDate="+fromDate+"&toDate="+toDate;
        ajaxRequest.open("POST", "setExecutiveWiseSurveyDetail.php" + queryString, true);
        ajaxRequest.send(null);

    }
}

function setSelectMultiplePockets() {
  var input = document.getElementsByName("assignPockets");
  
  
   
  var selected = 0;
  var total = 0;
  var chkPocketCd = "";
  var chkNotAssigned = "";
  for (var i = 0; i < input.length; i++) {
    if (input[i].checked) {
        var splits = input[i].value.split(",");
        var pocketCd = splits[0];
        var notAssigned = splits[1];
         chkPocketCd += pocketCd+",";  
         // console.log(chkPocketCd);
        total += parseFloat(notAssigned);
        selected ++;
      }
    
  }
  chkPocketCd = chkPocketCd.substring(0, chkPocketCd.length - 1);
  document.getElementsByName("multiplePockets")[0].value = "" + chkPocketCd;
  document.getElementsByName("shopsCount")[0].value = "" + total.toFixed(0);
  document.getElementsByName("pocketsCount")[0].value = "" + selected.toFixed(0);
}




function submitLoginMasterFormData() {
    var electionName = document.getElementsByName('electionName')[0].value;
    var loginCd = document.getElementsByName('loginCd')[0].value;
    var userCd = document.getElementsByName('userName')[0].value;
    var czDesignation = document.getElementsByName('czDesignation')[0].value;
    var nodeCd = document.getElementsByName('node_Name')[0].value;
    var wardCd = document.getElementsByName('wardName')[0].value;
    var uhpCd = document.getElementsByName('uhpName')[0].value;
    var remark = document.getElementsByName('remark')[0].value;
    var isActive = document.getElementsByName('isActive')[0].value;
   
    if (electionName === '') {
        alert("Select Corporation!!");
    } else if (userCd === '') {
        alert("Select User!!");
    } else if (czDesignation === '') {
        alert("Select Designation!!");
    } else  {
        $.ajax({
            type: "POST",
            url: 'action/saveLoginMasterFormData.php',
            data: {
                electionName: electionName,
                loginCd: loginCd,
                userCd: userCd,
                czDesignation: czDesignation,
                nodeCd: nodeCd,
                wardCd: wardCd,
                uhpCd: uhpCd,
                remark: remark,
                isActive: isActive
            },
            beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('#submitLoginMasterBtnId').attr("disabled", true);
                $('html').addClass("ajaxLoading");
            },
            success: function(dataResult) {
                var dataResult = JSON.parse(dataResult);
                if (dataResult.statusCode == 200 || dataResult.statusCode == 204 || dataResult.statusCode == 206 ) {
                   
                    $("#submitmsgsuccess").html(dataResult.msg)
                        .hide().fadeIn(800, function() {
                            $("submitmsgsuccess").append("");
                            window.location.href = 'index.php?p=login-master';
                        }).delay(3000).fadeOut("fast");

                } else if (dataResult.statusCode == 404 || dataResult.statusCode == 203) {
                    $("#submitmsgfailed").html(dataResult.msg)
                        .hide().fadeIn(800, function() {
                            $("submitmsgfailed").append("");
                        }).delay(3000).fadeOut("fast");

                }
               
                // return data;
            },
            complete: function() {
                    $('#submitLoginMasterBtnId').attr("disabled", false);
                    $('html').removeClass("ajaxLoading");
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
    }
}


// AK Code Category-Master
function submitCategoryMasterFormData() {
    var categoryCd = document.getElementsByName('categoryCd')[0].value;
    var categoryName = document.getElementsByName('categoryName')[0].value;
    var categoryDescription = document.getElementsByName('categoryDescription')[0].value;
    var color = document.getElementsByName('color')[0].value;
    var remark = document.getElementsByName('remark')[0].value;
    var isActive = document.getElementsByName('isActive')[0].value;
   
    if (categoryName === '') {
        alert("Select Category Name!!");
    } else if (color === '') {
        alert("Select Color !!");
    } else  {
        $.ajax({
            type: "POST",
            url: 'action/saveCategoryMasterFormData.php',
            data: {
                categoryCd: categoryCd,
                categoryName: categoryName,
                categoryDescription: categoryDescription,
                color: color,
                remark: remark,
                isActive: isActive
            },
            beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('#submitCategoryMasterBtnId').attr("disabled", true);
                $('html').addClass("ajaxLoading");
            },
            success: function(dataResult) {
                var dataResult = JSON.parse(dataResult);
                if (dataResult.statusCode == 200 || dataResult.statusCode == 204 || dataResult.statusCode == 206 ) {
                   
                    $("#submitmsgsuccess").html(dataResult.msg)
                        .hide().fadeIn(800, function() {
                            $("submitmsgsuccess").append("");
                            window.location.href = 'index.php?p=category-master';
                            // getCategoryMasterTable();
                        }).delay(3000).fadeOut("fast");

                } else if (dataResult.statusCode == 404 || dataResult.statusCode == 203) {
                    $("#submitmsgfailed").html(dataResult.msg)
                        .hide().fadeIn(800, function() {
                            $("submitmsgfailed").append("");
                        }).delay(3000).fadeOut("fast");

                }
               
                // return data;
            },
            complete: function() {
                    $('#submitCategoryMasterBtnId').attr("disabled", false);
                    $('html').removeClass("ajaxLoading");
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



// Pocket Assign Function Starts From Here

function setNodeNameInSession(nodeName) {
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
    
    if (nodeName === '') {
        alert("Please Select Node!");
    } else {
        var queryString = "?nodeName="+nodeName;
        // ajaxRequest.open("POST", "setNodeNameInSessionPocketAssign.php" + queryString, true);
        ajaxRequest.open("POST", "setNodeNameInSession.php" + queryString, true);
        ajaxRequest.send(null);

        // console.log(nodeName);

    }

}


function setWardInSession(Ward_No) {
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
    
    if (Ward_No === '') {
        alert("Please Select Ward!");
    } else {
        var queryString = "?Ward_No="+Ward_No;
        ajaxRequest.open("POST", "setWardInSession.php" + queryString, true);
        ajaxRequest.send(null);

        console.log(Ward_No);
    }

}


function setAssignPocketToExecutive(userId,executiveCd){
    var electionCd = document.getElementsByName('electionName')[0].value;
    var pocketName = document.getElementsByName('pocketName')[0].value;
    var assignDate = document.getElementsByName('assignDate')[0].value;
   
    if (electionCd === '') {
        alert("Select Corporation!!");
    } else if (pocketName === '') {
        alert("Select Pocket!!");
    } else if (assignDate === '') {
        alert("Enter Assign Date !!");
    } else {
        $.ajax({
            type: "POST",
            url: 'action/setAssignPocketToExecutiveData.php',
            data: {
                electionCd: electionCd,
                pocketName: pocketName,
                assignDate: assignDate,
                userId: userId,
                executiveCd:executiveCd
            },
           
            beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                // $('#submitPopUpMasterBtnId').attr("disabled", true);
                // $('html').addClass("ajaxLoading");
                // $("#idAssignPocketMsg").style.display='block';
                $("#idAssignPocketMsg").html("<h5> Please wait... </h5>")
            },
            success: function(dataResult) {           
                var dataResult = JSON.parse(dataResult);
                console.log(dataResult);

                if (dataResult.statusCode == 200 ) {
                    // $("#idAssignPocketMsgSuccess").style.display='block';

                        $("#idAssignPocketMsgSuccess").html("<h5> "+dataResult.msg+" </h5>")
                        .hide().fadeIn(800, function() {
                            // $("idAssignPocketMsgFailure").append("");
                            window.location.href = 'home.php?p=pocket-assign';
                        }).delay(3000).fadeOut("fast");
                } else if (dataResult.statusCode == 204 ) {
                    // $("#idAssignPocketMsgFailure").style.display='block';
                    $("#idAssignPocketMsgFailure").html("<h5> "+dataResult.msg+" </h5>")
                        .hide().fadeIn(800, function() {
                            // $("idAssignPocketMsgFailure").append("");
                            // window.location.href = 'home.php?p=pocket-assign';
                        }).delay(3000).fadeOut("fast");
                }
               
                // return data;
            },
            complete: function() {
                    // $('#submitPopUpMasterBtnId').attr("disabled", false);
                    // $('html').removeClass("ajaxLoading");
                   
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
    }
}


function setRemovePocketFromExecutiveForm(usrId,exeCd,exeName,pcktCd,pcktName,pcktAssgnCd) {
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
            var ajaxDisplay = document.getElementById('removePocketFromExecutive');
            ajaxDisplay.innerHTML = ajaxRequest.responseText;
                $('html, body').animate({
                   scrollTop: $("#removePocketFromExecutive").offset().top - 100
               }, 500);
        }
    }


    var queryString = "?usrId="+usrId+"&exeCd="+exeCd+"&exeName="+exeName+"&pcktCd="+pcktCd+"&pcktName="+pcktName+"&pcktAssgnCd="+pcktAssgnCd;
    ajaxRequest.open("POST", "setRemovePocketFromExecutiveForm.php" + queryString, true);
    ajaxRequest.send(null);

}


function setRemovePocketFromExecutiveData(){
    var electionCd = document.getElementsByName('electionName')[0].value;
    var usrId = document.getElementsByName('usrId')[0].value;
    var exeCd = document.getElementsByName('exeCd')[0].value;
    var pcktCd = document.getElementsByName('pcktCd')[0].value;
    var pcktAssgnCd = document.getElementsByName('pcktAssgnCd')[0].value;
    var srPocketRemoveRemark = document.getElementsByName('srPocketRemoveRemark')[0].value;
   
    if (electionCd === '') {
        alert("Select Corporation!!");
    } else if (usrId === '') {
        alert("Select User!!");
    } else if (exeCd === '') {
        alert("Select Executive !!");
    } else if (srPocketRemoveRemark === '') {
        alert("Enter Remark !!");
    } else {
        $.ajax({
            type: "POST",
            url: 'action/setRemovePocketFromExecutiveData.php',
            data: {
                electionCd: electionCd,
                usrId: usrId,
                exeCd: exeCd,
                pcktCd: pcktCd,
                pcktAssgnCd: pcktAssgnCd,
                srPocketRemoveRemark:srPocketRemoveRemark
            },
            beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                // $('#submitPopUpMasterBtnId').attr("disabled", true);
                // $('html').addClass("ajaxLoading");
                // $("#idAssignPocketMsg").style.display='block';
                // $("#idAssignPocketMsg").html("<h5> Please wait... </h5>")
            },
            success: function(dataResult) {
                var dataResult = JSON.parse(dataResult);
                if (dataResult.statusCode == 200 ) {
                    // $("#idAssignPocketMsgSuccess").style.display='block';
                    $("#idAssignPocketMsgSuccess").html("<h5> "+dataResult.msg+" </h5>")
                        .hide().fadeIn(800, function() {
                            // $("idAssignPocketMsgFailure").append("");
                            window.location.href = 'home.php?p=pocket-assign';
                        }).delay(3000).fadeOut("fast");
                } else if (dataResult.statusCode == 204 ) {
                    // $("#idAssignPocketMsgFailure").style.display='block';
                    $("#idAssignPocketMsgFailure").html("<h5> "+dataResult.msg+" </h5>")
                        .hide().fadeIn(800, function() {
                            // $("idAssignPocketMsgFailure").append("");
                            // window.location.href = 'home.php?p=pocket-assign';
                        }).delay(3000).fadeOut("fast");
                }
               
                // return data;
            },
            complete: function() {
                    // $('#submitPopUpMasterBtnId').attr("disabled", false);
                    // $('html').removeClass("ajaxLoading");
                   
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
    }
}
// Pocket Assign Function Ends Here

// License Tracking Display Block on Click

function showShopTracking(){
    

    var ShopCd = document.getElementsByName('ShopName')[0].value;
    if(ShopCd == ''){
        alert('Please Select Shop Name');
    }
    else{

        $.ajax({
            type: "POST",
            url: 'setShopDetailData.php',
            data: {
                //electionName: electionName,
                shopId: ShopCd
            },
            beforeSend: function() { 
            },
            success: function(dataResult) {
                 window.location.href = 'index.php?p=shop-tracking';
                // return data;
            },
            complete: function() {
            }
        });

        // document.getElementById("trackingdetails").style.display = "";

        // document.getElementById('post_shopDet').innerHTML= "Shop Name / No :    "+shopNameNo;
       
    }
}
// License Tracking Display Block on Click

// Payment Receipt Display Block on Click

function ShowDiv_Receipt(){
    
    var shopNameNoForReceipt = document.getElementsByName('shopNameNoForReceipt')[0].value;
    if(shopNameNoForReceipt == ''){
        alert('Please Enter Shop Name / Shop No');        
    }
    else{
        document.getElementById("Receipt_Format").style.display = "";
        // console.log(shopNameNoForReceipt);
        document.getElementById('shopName/No').innerHTML= "Hi,  "+shopNameNoForReceipt;
    }
}
// Payment Receipt Display Block on Click


// Shop List Calling Start Here
function setShopListCallingCategoryInSession() {
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
   
    var ShopListCallingCategory = document.getElementsByName('CallingCategory')[0].value;
     if (ShopListCallingCategory === '') {
        alert("Please Select Calling Category!");
    } else {
        var queryString = "?ShopListCallingCategoryCd=" + ShopListCallingCategory;
        ajaxRequest.open("POST", "setShopListCallingCategoryInSession.php" + queryString, true);
        ajaxRequest.send(null);

    }

}


function setShopListExecutiveNameInSession() {
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
   
    var ShopListExecutiveName = document.getElementsByName('ExecutiveName')[0].value;
     if (ShopListExecutiveName === '') {
        alert("Please Select Executive!");
    } else {
        var queryString = "?ShopListExecutiveNameCd=" + ShopListExecutiveName;
        ajaxRequest.open("POST", "setShopListExecutiveNameInSession.php" + queryString, true);
        ajaxRequest.send(null);

    }

}


function setCallAssignDateInSession() {
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
   
    var CallAssignDate = document.getElementsByName('callassigndate')[0].value;
     if (CallAssignDate === '') {
        alert("Please Select Call Assign Date!");
    } else {
        var queryString = "?CallAssignDate=" + CallAssignDate;
        ajaxRequest.open("POST", "setShopListCallAssignDateInSession.php" + queryString, true);
        ajaxRequest.send(null);

    }

}
// Shop List Calling Function End's Here


// Calling Module Functions Start's Here

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


// Upload Document Preview Img
function PreviewImageCCOCimg() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("CCOCimg").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("CCOCimgView").src = oFREvent.target.result;
    };
};

function CCOCimgValidation() {
    var fileInput = 
        document.getElementById('CCOCimg');
    
    var filePath = fileInput.value;
    // Allowing file type
    var allowedExtensions = 
            /(\.jpg|\.jpeg|\.png)$/i;

    if(fileInput === ''){
        alert("Please Choose C.C. O.C Document");
    }
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

function PreviewImageShopActImg() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("ShopActImg").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("ShopActImgView").src = oFREvent.target.result;
    };
};

function ShopActImgValidation() {
    var fileInput = 
        document.getElementById('ShopActImg');
    
    var filePath = fileInput.value;
    // Allowing file type
    var allowedExtensions = 
            /(\.jpg|\.jpeg|\.png)$/i;

    if(fileInput === ''){
        alert("Please Choose Shop Act Document");
    }
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

function PreviewImageFDACertificateImg() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("FDACertificateImg").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("FDACertificateImgview").src = oFREvent.target.result;
    };
};

function FDACertificateImgValidation() {
    var fileInput = 
        document.getElementById('FDACertificateImg');
    
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

function PreviewImageFireChallanImg() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("FireChallanImg").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("FireChallanImgView").src = oFREvent.target.result;
    };
};

function FireChallanImgValidation() {
    var fileInput = 
        document.getElementById('FireChallanImg');
    
    var filePath = fileInput.value;
    // Allowing file type
    var allowedExtensions = 
            /(\.jpg|\.jpeg|\.png)$/i;

    if(fileInput === ''){
            alert("Please Choose Fire Challan");
    }
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

function PreviewImageNOCofSocietyImg() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("NOCofSocietyImg").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("NOCofSocietyImgView").src = oFREvent.target.result;
    };
};

function NOCofSocietyImgValidation() {
    var fileInput = 
        document.getElementById('NOCofSocietyImg');
    
    var filePath = fileInput.value;
    // Allowing file type
    var allowedExtensions = 
            /(\.jpg|\.jpeg|\.png)$/i;
           
    if(fileInput === ''){
        alert("Please Choose NOC Of Society");
    }

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

function PreviewImagePestControlCertificateImg() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("PestControlCertificateImg").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("PestControlCertificateImgView").src = oFREvent.target.result;
    };
};

function PestControlCertificateImgValidation() {
    var fileInput = 
        document.getElementById('PestControlCertificateImg');
    
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

function PreviewImageRentAgreement() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("RentAgreement").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("RentAgreementView").src = oFREvent.target.result;
    };
};

function RentAgreementValidation() {
    var fileInput = 
        document.getElementById('RentAgreement');
    
    var filePath = fileInput.value;
    // Allowing file type
    var allowedExtensions = 
            /(\.jpg|\.jpeg|\.png)$/i;

    if(fileInput === ''){
        alert("Please Choose Rent Agreement");
    }

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

function PreviewImagePropertyTaxChallan() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("PropertyTaxChallan").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("PropertyTaxChallanView").src = oFREvent.target.result;
    };
};

function PropertyTaxChallanValidation() {
    var fileInput = 
        document.getElementById('PropertyTaxChallan');
    
    var filePath = fileInput.value;
    // Allowing file type
    var allowedExtensions = 
            /(\.jpg|\.jpeg|\.png)$/i;

    if(fileInput === ''){
        alert("Please Choose Property Tax Challan");
    }

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

function PreviewImageWaterTaxChallan() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("WaterTaxChallan").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("WaterTaxChallanView").src = oFREvent.target.result;
    };
};

function WaterTaxChallanValidation() {
    var fileInput = 
        document.getElementById('WaterTaxChallan');
    
    var filePath = fileInput.value;
    // Allowing file type
    var allowedExtensions = 
            /(\.jpg|\.jpeg|\.png)$/i;

    if(fileInput === ''){
        alert("Please Choose Water Tax Challan");
    }

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

function PreviewImageGSTCertificate() {
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("GSTCertificate").files[0]);

    oFReader.onload = function (oFREvent) {
        document.getElementById("GSTCertificateView").src = oFREvent.target.result;
    };
};

function GSTCertificateValidation() {
    var fileInput = 
        document.getElementById('GSTCertificate');
    
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

// Upload Document Preview Img

function sendValue(){
    var image = document.getElementById('CCOCimgView').getAttribute('src');
    console.log(image);
    var w = window.open("","_blank");
    w.document.write(image.outerHTML);
    w.document.close();
}


function submitShopDocuments() {

    var action = document.getElementsByName('action')[0].value;
    var CCOCimg = document.getElementsByName("CCOCimg")[0].value; 
    var ShopActImg = document.getElementsByName("ShopActImg")[0].value; 
    var FDACertificateImg = document.getElementsByName("FDACertificateImg")[0].value; 
    var FireChallanImg = document.getElementsByName("FireChallanImg")[0].value; 
    var NOCofSocietyImg = document.getElementsByName("NOCofSocietyImg")[0].value; 
    var PestControlCertificateImg = document.getElementsByName("PestControlCertificateImg")[0].value; 
    var RentAgreement = document.getElementsByName("RentAgreement")[0].value; 
    var PropertyTaxChallan = document.getElementsByName("PropertyTaxChallan")[0].value; 
    var WaterTaxChallan = document.getElementsByName("WaterTaxChallan")[0].value; 
    var GSTCertificate = document.getElementsByName("GSTCertificate")[0].value; 

    var Shop_Cd = document.getElementsByName('Shop_Cd')[0].value;

    // var CCOCimg1 = document.getElementsByName("CCOCimg")[0].files; 
    // var ShopActImg1 = document.getElementsByName("ShopActImg")[0].files; 
    // var FDACertificateImg1 = document.getElementsByName("FDACertificateImg")[0].files; 
    // var FireChallanImg1 = document.getElementsByName("FireChallanImg")[0].files; 
    // var NOCofSocietyImg1 = document.getElementsByName("NOCofSocietyImg")[0].files; 
    // var PestControlCertificateImg1 = document.getElementsByName("PestControlCertificateImg")[0].files; 
    // var RentAgreement1 = document.getElementsByName("RentAgreement")[0].files; 
    // var PropertyTaxChallan1 = document.getElementsByName("PropertyTaxChallan")[0].files; 
    // var WaterTaxChallan1 = document.getElementsByName("WaterTaxChallan")[0].files; 
    // var GSTCertificate1 = document.getElementsByName("GSTCertificate")[0].files; 


    if (CCOCimg === '') {
        alert("Choose C.C.O.C. Document!!");
    } 
    else if (ShopActImg === '') {
        alert("Choose Shop Act License !!");
    } 
    else if (FireChallanImg === '') {
        alert("Choose Fire Challan !!");
    }
    else if (NOCofSocietyImg === '') {
        alert("Choose NOC of Society !!");
    }
    else if (RentAgreement === '') {
        alert("Choose Rent Agreement !!");
    }
    else if (PropertyTaxChallan === '') {
        alert("Choose Property Tax Challan !!");
    }
    else if (WaterTaxChallan === '') {
        alert("Choose Water Tax Challan !!");
    }
    else {
            console.log("Success");
            // var formData = new FormData();
            // formData.append("Shop_Cd", Shop_Cd);
            // formData.append("action", action);
            // formData.append("CCOCimg", CCOCimg1[0]);
            // formData.append("ShopActImg", ShopActImg1[0]);
            // formData.append("FDACertificateImg", FDACertificateImg1[0]);
            // formData.append("FireChallanImg", FireChallanImg1[0]);
            // formData.append("NOCofSocietyImg", NOCofSocietyImg1[0]);
            // formData.append("PestControlCertificateImg", PestControlCertificateImg1[0]);
            // formData.append("RentAgreement", RentAgreement1[0]);
            // formData.append("PropertyTaxChallan", PropertyTaxChallan1[0]);
            // formData.append("WaterTaxChallan", WaterTaxChallan1[0]);
            // formData.append("GSTCertificate", GSTCertificate1[0]);
            
            // $.ajax({
            //     type: "POST",
            //     enctype: 'multipart/form-data',
            //     url: 'action/saveShopDocumentsUpload.php',
            //     data : formData,
            //     mimeTypes:"multipart/form-data",
            //     contentType: false,
            //     cache: false,
            //     processData: false,


            //     beforeSend: function() {

            //         console.log("Before Sending");

            //         // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
            //         $('#submitShoppDocumentsBtnId').attr("disabled", true);
            //         $('html').addClass("ajaxLoading");
            //     },
                
            //     success: function(dataResult) {

            //         console.log("Success");

            //         var dataResult = JSON.parse(dataResult);

            //         if (dataResult.statusCode == 204) {
                    
            //             $("#submitmsgsuccess").html(dataResult.msg)
            //                 .hide().fadeIn(800, function() {
            //                     $("submitmsgsuccess").append("");
            //                     // window.location.href = 'index.php?p=tree-master';
            //                 }).delay(3000).fadeOut("fast");

            //         }else if (dataResult.statusCode == 404 ) {

            //             $("#submitmsgfailed").html(dataResult.msg)
            //                 .hide().fadeIn(800, function() {
            //                     $("submitmsgfailed").append("");
            //                 }).delay(3000).fadeOut("fast");

            //         }

            //     },
            //     complete: function() {

            //             $('#submitShoppDocumentsBtnId').attr("disabled", false);
            //             $('html').removeClass("ajaxLoading");
            //         }
            // });
    }
}

// Calling Module Functions End's Here

//new functions 

function setShopBusinessCategoriesFilter(pageNo, businessCatCd){
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
            if (ajaxRequest.readyState == 4) {
                var ajaxDisplay = document.getElementById('showPageDetails');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;

                if ($(".categories-button-active").hasClass("open")) {
                    $(".categories-button-active").removeClass("open");
                    $(".categories-dropdown-active-large").removeClass("open");
                }
                
                var tempDivZoomContainer = document.querySelectorAll(".zoomContainer");
                for (var i = 0; i < tempDivZoomContainer.length; i++) {
                    tempDivZoomContainer[i].style.height = "0px";
                    tempDivZoomContainer[i].style.width = "0px";
                }

                var tempDivZoomWindow = document.querySelectorAll(".zoomWindow");
                for (var i = 0; i < tempDivZoomWindow.length; i++) {
                    tempDivZoomWindow[i].style.height = "0px";
                    tempDivZoomWindow[i].style.width = "0px";
                }

                $('html, body').animate({
                    scrollTop: $("#showPageDetails").offset().top - 200
                }, 500);

            }   
        }
    }

  
      
    //var electionName = document.getElementsByName('electionName')[0].value;
    var nodeCd = document.getElementsByName('nodeCd')[0].value;
    if(businessCatCd === ''){
        alert('Select Shop Category');
    }else{
        var queryString = "?pageNo="+pageNo+"&nodeCd="+nodeCd+"&businessCatCd="+businessCatCd;
        ajaxRequest.open("POST", "setShopBusinessCategoriesFilter.php" + queryString, true);
        ajaxRequest.send(null);
    }
    
}


function setShopCallingBusinessCategoriesFilter(pageNo, businessCatCd){

    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;

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
            if (ajaxRequest.readyState == 4) {

                //window.location.href="index.php?p=calling-list";
                var ajaxDisplay = document.getElementById('showPageDetails');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;

                if ($(".categories-button-active").hasClass("open")) {
                    $(".categories-button-active").removeClass("open");
                    $(".categories-dropdown-active-large").removeClass("open");
                }
                
                var tempDivZoomContainer = document.querySelectorAll(".zoomContainer");
                for (var i = 0; i < tempDivZoomContainer.length; i++) {
                    tempDivZoomContainer[i].style.height = "0px";
                    tempDivZoomContainer[i].style.width = "0px";
                }

                var tempDivZoomWindow = document.querySelectorAll(".zoomWindow");
                for (var i = 0; i < tempDivZoomWindow.length; i++) {
                    tempDivZoomWindow[i].style.height = "0px";
                    tempDivZoomWindow[i].style.width = "0px";
                }

                $('html, body').animate({
                    scrollTop: $("#showPageDetails").offset().top - 200
                }, 500);

            }   
        }
    }

  
      
    //var electionName = document.getElementsByName('electionName')[0].value;
    var nodeCd = document.getElementsByName('nodeCd1')[0].value;
    var calling_Category = document.getElementsByName('calling_Category')[0].value;

    console.log(nodeCd);
    if(businessCatCd === ''){
        alert('Select Shop Category');
    }
    else if(calling_Category === ''){
        alert('Select Calling Category');
    }else{
        var queryString = "?fromDate="+fromDate+"&toDate="+toDate+"&pageNo="+pageNo+"&nodeCd="+nodeCd+"&Calling_Category_Cd="+calling_Category+"&businessCatCd="+businessCatCd;
        ajaxRequest.open("POST", "setShopCallingBusinessCategoriesFilter.php" + queryString, true);
        ajaxRequest.send(null);
    }
    
}


function setShopSurveyBusinessCategoriesFilter(pageNo, businessCatCd){

    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;

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
            if (ajaxRequest.readyState == 4) {

                //window.location.href="index.php?p=calling-list";
                var ajaxDisplay = document.getElementById('showPageDetails');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;

                if ($(".categories-button-active").hasClass("open")) {
                    $(".categories-button-active").removeClass("open");
                    $(".categories-dropdown-active-large").removeClass("open");
                }
                
                var tempDivZoomContainer = document.querySelectorAll(".zoomContainer");
                for (var i = 0; i < tempDivZoomContainer.length; i++) {
                    tempDivZoomContainer[i].style.height = "0px";
                    tempDivZoomContainer[i].style.width = "0px";
                }

                var tempDivZoomWindow = document.querySelectorAll(".zoomWindow");
                for (var i = 0; i < tempDivZoomWindow.length; i++) {
                    tempDivZoomWindow[i].style.height = "0px";
                    tempDivZoomWindow[i].style.width = "0px";
                }

                $('html, body').animate({
                    scrollTop: $("#showPageDetails").offset().top - 200
                }, 500);

            }   
        }
    }

  
      
    //var electionName = document.getElementsByName('electionName')[0].value;
    var nodeCd = document.getElementsByName('nodeCd1')[0].value;

    console.log(nodeCd);
    if(businessCatCd === ''){
        alert('Select Shop Category');
    }
    else{
        var queryString = "?fromDate="+fromDate+"&toDate="+toDate+"&pageNo="+pageNo+"&nodeCd="+nodeCd+"&businessCatCd="+businessCatCd;
        ajaxRequest.open("POST", "setShopSurveyBusinessCategoriesFilter.php" + queryString, true);
        ajaxRequest.send(null);
    }
    
}

function setShopDetailData(shopId){

    var electionName = document.getElementsByName('electionName')[0].value;

    if (electionName === '') {
        alert("Select Corporation!!");
    } else  {
        $.ajax({
            type: "POST",
            url: 'setShopDetailData.php',
            data: {
                electionName: electionName,
                shopId: shopId
            },
            beforeSend: function() { 
            },
            success: function(dataResult) {
                 window.location.href = 'index.php?p=shop-detail';
                // return data;
            },
            complete: function() {
            }
        });
    }
      
}

function shopQuickViewShopDetailModal(shopId){
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
            if (ajaxRequest.readyState == 4) {
                var ajaxDisplay = document.getElementById('showQuickShopDetails');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;

                if ($(".categories-button-active").hasClass("open")) {
                    $(".categories-button-active").removeClass("open");
                    $(".categories-dropdown-active-large").removeClass("open");
                }
                $("#quickViewShopDetailModal").modal("show");

            }   
        }
    }
      
    var electionName = document.getElementsByName('electionName')[0].value;

    if(shopId === ''){
        alert('Select Shop');
    }else{
        var queryString = "?shopId="+shopId+"&electionName="+electionName;
        ajaxRequest.open("POST", "setQuickViewShopDetailModal.php" + queryString, true);
        ajaxRequest.send(null);
    }
}



function shopVerifyAndApproveShopDetailModal(shopId, pageNo){
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
            if (ajaxRequest.readyState == 4) {
                var ajaxDisplay = document.getElementById('showQuickShopDetails');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;

                if ($(".categories-button-active").hasClass("open")) {
                    $(".categories-button-active").removeClass("open");
                    $(".categories-dropdown-active-large").removeClass("open");
                }
                $("#quickViewShopDetailModal").modal("show");
                $("#modalCloseId").hide();
                $("#modalHeaderId").show();

            }   
        }
    }
      
    var electionName = document.getElementsByName('electionName')[0].value;

    if(shopId === ''){
        alert('Select Shop');
    }else{
        var queryString = "?electionName="+electionName+"&shopId="+shopId+"&pageNo="+pageNo;
        ajaxRequest.open("POST", "setShopVerifyAndApproveShopDetailModal.php" + queryString, true);
        ajaxRequest.send(null);
    }
}

function payShopLicenseFeeDetailModal(shopId, pageNo, billingId){
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
            if (ajaxRequest.readyState == 4) {
                var ajaxDisplay = document.getElementById('showShopLicenseFeeDetails');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;

                if ($(".categories-button-active").hasClass("open")) {
                    $(".categories-button-active").removeClass("open");
                    $(".categories-dropdown-active-large").removeClass("open");
                }
                $("#payShopLicenseFeeModal").modal("show");
                $("#modalPaymentFooterId").show();
                $("#payShopLicenseFeeBtnId").show();
                $("#modalPaymentCloseId").hide();
                $("#modalPaymentHeaderId").show();

            }   
        }
    }
      
    var electionName = document.getElementsByName('electionName')[0].value;

    if(shopId === ''){
        alert('Select Shop');
    }else{
        var queryString = "?electionName="+electionName+"&shopId="+shopId+"&pageNo="+pageNo+"&billingId="+billingId;
        ajaxRequest.open("POST", "setShowPayShopLicenseFeeDetailModal.php" + queryString, true);
        ajaxRequest.send(null);
    }
}

function viewShopLicenseDetailModal(shopId){
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
            if (ajaxRequest.readyState == 4) {
                var ajaxDisplay = document.getElementById('showShopLicenseFeeDetails');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;

                if ($(".categories-button-active").hasClass("open")) {
                    $(".categories-button-active").removeClass("open");
                    $(".categories-dropdown-active-large").removeClass("open");
                }
                $("#payShopLicenseFeeModal").modal("show");
                $("#modalPaymentFooterId").hide();
                $("#payShopLicenseFeeBtnId").hide();
                $("#modalPaymentHeaderId").hide();
                $("#modalPaymentCloseId").show();

            }   
        }
    }
      
    var electionName = document.getElementsByName('electionName')[0].value;

    if(shopId === ''){
        alert('Select Shop');
    }else{
        var queryString = "?electionName="+electionName+"&shopId="+shopId;
        ajaxRequest.open("POST", "setShowShopLicenseDetailModal.php" + queryString, true);
        ajaxRequest.send(null);
    }
}

function licensePrinting(){
    var c=document.getElementById("PrintLicenseID").innerHTML;
    var a=window.open("","print_content","width=800,height=1000,resizable=1,scrollbars=1");
    a.document.open();
    a.document.write('<html><Title>Shop License</Title><body onload="window.print()">'+c+'</body></html>');
    a.document.close()
}

function setShopSurveyDetailFilter(pageNo){
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
            if (ajaxRequest.readyState == 4) {
                var ajaxDisplay = document.getElementById('showPageDetails');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;

                if ($(".categories-button-active").hasClass("open")) {
                    $(".categories-button-active").removeClass("open");
                    $(".categories-dropdown-active-large").removeClass("open");
                }

                $('html, body').animate({
                    scrollTop: $("#showPageDetails").offset().top - 200
                }, 500);


                var tempDivZoomContainer = document.querySelectorAll(".zoomContainer");
                for (var i = 0; i < tempDivZoomContainer.length; i++) {
                    tempDivZoomContainer[i].style.height = "0px";
                    tempDivZoomContainer[i].style.width = "0px";
                }

                var tempDivZoomWindow = document.querySelectorAll(".zoomWindow");
                for (var i = 0; i < tempDivZoomWindow.length; i++) {
                    tempDivZoomWindow[i].style.height = "0px";
                    tempDivZoomWindow[i].style.width = "0px";
                }


                var dataList10Paging = $('.table-10').DataTable({
                    responsive: true,
                    columnDefs: [
                        {
                            orderable: false,
                            targets: 0,
                        }
                    ],
                    oLanguage: {
                        sLengthMenu: "_MENU_",
                        sSearch: ""
                    },
                    // aLengthMenu: [[1, 4, 10, 15, 20], [1, 4, 10, 15, 20]],
                    searching: false,
                    order: [[0, "asc"]],
                    bInfo: false,
                    lengthChange: false,
                    ordering: false,
                    info: false,
                    pageLength: 10,
                    paging:false,
                    iDisplayLength: 10
                });


            }   
        }
    }
      

    var electionName = document.getElementsByName('electionName')[0].value;
    var nodeName = document.getElementsByName('nodeName')[0].value;
    var nodeCd = document.getElementsByName('nodeCd')[0].value;
    var documentStatus = document.getElementsByName('documentStatus')[0].value;
  
    var queryString = "?electionName="+electionName+"&pageNo="+pageNo+"&nodeName="+nodeName+"&nodeCd="+nodeCd+"&documentStatus="+documentStatus;
    ajaxRequest.open("POST", "setShopSurveyDetailFilter.php" + queryString, true);
    ajaxRequest.send(null);

}



function setShopSurveyDetailView(pageNo, viewType){
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
            if (ajaxRequest.readyState == 4) {
                setShopSurveyDetailFilter(pageNo);
            }
        }
    }

    var queryString = "?viewType="+viewType;
    ajaxRequest.open("POST", "setShopSurveyDetailView.php" + queryString, true);
    ajaxRequest.send(null);

}


function setShopLicenseDetailFilter(pageNo){
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
            if (ajaxRequest.readyState == 4) {
                var ajaxDisplay = document.getElementById('showPageDetails');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;

                if ($(".categories-button-active").hasClass("open")) {
                    $(".categories-button-active").removeClass("open");
                    $(".categories-dropdown-active-large").removeClass("open");
                }

                $('html, body').animate({
                    scrollTop: $("#showPageDetails").offset().top - 200
                }, 500);


                var tempDivZoomContainer = document.querySelectorAll(".zoomContainer");
                for (var i = 0; i < tempDivZoomContainer.length; i++) {
                    tempDivZoomContainer[i].style.height = "0px";
                    tempDivZoomContainer[i].style.width = "0px";
                }

                var tempDivZoomWindow = document.querySelectorAll(".zoomWindow");
                for (var i = 0; i < tempDivZoomWindow.length; i++) {
                    tempDivZoomWindow[i].style.height = "0px";
                    tempDivZoomWindow[i].style.width = "0px";
                }


                var dataList10Paging = $('.table-10').DataTable({
                    responsive: true,
                    columnDefs: [
                        {
                            orderable: false,
                            targets: 0,
                        }
                    ],
                    oLanguage: {
                        sLengthMenu: "_MENU_",
                        sSearch: ""
                    },
                    // aLengthMenu: [[1, 4, 10, 15, 20], [1, 4, 10, 15, 20]],
                    searching: false,
                    order: [[0, "asc"]],
                    bInfo: false,
                    lengthChange: false,
                    ordering: false,
                    info: false,
                    pageLength: 10,
                    paging:false,
                    iDisplayLength: 10
                });


            }   
        }
    }
      

    var electionName = document.getElementsByName('electionName')[0].value;
    var nodeName = document.getElementsByName('nodeName')[0].value;
    var nodeCd = document.getElementsByName('nodeCd')[0].value;
    var documentStatus = document.getElementsByName('documentStatus')[0].value;
    var licenseStatus = document.getElementsByName('licenseStatus')[0].value;
    var transactionStatus = document.getElementsByName('transactionStatus')[0].value;
    
    if(licenseStatus=='Verified'){
         $("#setApproveAndGenerateLicenseId").show();
    }else{
        $("#setApproveAndGenerateLicenseId").hide();
    }

    var queryString = "?electionName="+electionName+"&pageNo="+pageNo+"&nodeName="+nodeName+"&nodeCd="+nodeCd+"&documentStatus="+documentStatus+"&licenseStatus="+licenseStatus+"&transactionStatus="+transactionStatus;
    ajaxRequest.open("POST", "setShopLicenseDetailFilter.php" + queryString, true);
    ajaxRequest.send(null);

}



function setShopLicenseDetailView(pageNo, viewType){
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
            if (ajaxRequest.readyState == 4) {
                setShopLicenseDetailFilter(pageNo);
            }
        }
    }

    var queryString = "?viewType="+viewType;
    ajaxRequest.open("POST", "setShopLicenseDetailView.php" + queryString, true);
    ajaxRequest.send(null);

}

function setNodeAndWardList(nodeName){
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
            var ajaxDisplay = document.getElementById('setNodeAndWardDetailId');
            ajaxDisplay.innerHTML = ajaxRequest.responseText;
        }
    }

    var electionName = document.getElementsByName('electionName')[0].value;
    
    if (electionName === '') {
        alert("Please Select Corporation!");
    } else {
        var queryString = "?electionName="+electionName+"&nodeName="+nodeName;
        ajaxRequest.open("POST", "setNodeAndWardInData.php" + queryString, true);
        ajaxRequest.send(null);
    }

}

function setNodeAndWardId(nodeId){

    $("#node_id").select2().val([nodeId]).trigger("change");

}

function setHideApproveAndGenerateLicenseProcess(licenseStatus){

    if(licenseStatus=='Verified'){
         $("#setApproveAndGenerateLicenseId").show();
    }else{
        $("#setApproveAndGenerateLicenseId").hide();
    }
}


function setSearchShopTracking(pageNo){
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
            if (ajaxRequest.readyState == 4) {
                var ajaxDisplay = document.getElementById('showPageDetails');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;

                document.getElementsByName('shopUID')[0].text = "";

                if ($(".categories-button-active").hasClass("open")) {
                    $(".categories-button-active").removeClass("open");
                    $(".categories-dropdown-active-large").removeClass("open");
                }

                $('html, body').animate({
                    scrollTop: $("#showPageDetails").offset().top - 200
                }, 500);


                var tempDivZoomContainer = document.querySelectorAll(".zoomContainer");
                for (var i = 0; i < tempDivZoomContainer.length; i++) {
                    tempDivZoomContainer[i].style.height = "0px";
                    tempDivZoomContainer[i].style.width = "0px";
                }

                var tempDivZoomWindow = document.querySelectorAll(".zoomWindow");
                for (var i = 0; i < tempDivZoomWindow.length; i++) {
                    tempDivZoomWindow[i].style.height = "0px";
                    tempDivZoomWindow[i].style.width = "0px";
                }
            }   
        }
    }
      
    var electionName = document.getElementsByName('electionName')[0].value;
    var nodeCd = document.getElementsByName('nodeCd')[0].value;
    var businessCatCd = document.getElementsByName('businessCatCd')[0].value;
    var shopName = document.getElementsByName('shopUID')[0].value;

    if(shopName === ''){
        alert('Enter Shop Name or Shop UID');
    }else{
        var queryString = "?electionName="+electionName+"&pageNo="+pageNo+"&nodeCd="+nodeCd+"&businessCatCd="+businessCatCd+"&shopName="+shopName;
        ajaxRequest.open("POST", "setShopTrackingDetailFilter.php" + queryString, true);
        ajaxRequest.send(null);
    }
    
}


function setSearchShopTrackingById(pageNo, shopId){
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
            if (ajaxRequest.readyState == 4) {
                var ajaxDisplay = document.getElementById('showPageDetails');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;

                if ($(".categories-button-active").hasClass("open")) {
                    $(".categories-button-active").removeClass("open");
                    $(".categories-dropdown-active-large").removeClass("open");
                }

                $('html, body').animate({
                    scrollTop: $("#showPageDetails").offset().top - 200
                }, 500);


                var tempDivZoomContainer = document.querySelectorAll(".zoomContainer");
                for (var i = 0; i < tempDivZoomContainer.length; i++) {
                    tempDivZoomContainer[i].style.height = "0px";
                    tempDivZoomContainer[i].style.width = "0px";
                }

                var tempDivZoomWindow = document.querySelectorAll(".zoomWindow");
                for (var i = 0; i < tempDivZoomWindow.length; i++) {
                    tempDivZoomWindow[i].style.height = "0px";
                    tempDivZoomWindow[i].style.width = "0px";
                }
            }   
        }
    }
      
    var electionName = document.getElementsByName('electionName')[0].value;
    var nodeCd = document.getElementsByName('nodeCd')[0].value;
    var businessCatCd = document.getElementsByName('businessCatCd')[0].value;
    var shopName = document.getElementsByName('shopUID')[0].value;
   
    var queryString = "?electionName="+electionName+"&pageNo="+pageNo+"&nodeCd="+nodeCd+"&businessCatCd="+businessCatCd+"&shopName="+shopName+"&shopId="+shopId;
    ajaxRequest.open("POST", "setShopTrackingDetailFilter.php" + queryString, true);
    ajaxRequest.send(null);
    
}


function setShopLicenseDefaultersFilter(pageNo){
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
            if (ajaxRequest.readyState == 4) {
               var ajaxDisplay = document.getElementById('showPageDetails');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;

                if ($(".categories-button-active").hasClass("open")) {
                    $(".categories-button-active").removeClass("open");
                    $(".categories-dropdown-active-large").removeClass("open");
                }

                $('html, body').animate({
                    scrollTop: $("#showPageDetails").offset().top - 200
                }, 500);


                var tempDivZoomContainer = document.querySelectorAll(".zoomContainer");
                for (var i = 0; i < tempDivZoomContainer.length; i++) {
                    tempDivZoomContainer[i].style.height = "0px";
                    tempDivZoomContainer[i].style.width = "0px";
                }

                var tempDivZoomWindow = document.querySelectorAll(".zoomWindow");
                for (var i = 0; i < tempDivZoomWindow.length; i++) {
                    tempDivZoomWindow[i].style.height = "0px";
                    tempDivZoomWindow[i].style.width = "0px";
                }


                var dataList10Paging = $('.table-10').DataTable({
                    responsive: true,
                    columnDefs: [
                        {
                            orderable: false,
                            targets: 0,
                        }
                    ],
                    oLanguage: {
                        sLengthMenu: "_MENU_",
                        sSearch: ""
                    },
                    // aLengthMenu: [[1, 4, 10, 15, 20], [1, 4, 10, 15, 20]],
                    searching: false,
                    order: [[0, "asc"]],
                    bInfo: false,
                    lengthChange: false,
                    ordering: false,
                    info: false,
                    pageLength: 10,
                    paging:false,
                    iDisplayLength: 10
                });

            }
        }
    }
      
    var electionName = document.getElementsByName('electionName')[0].value;
    var nodeName = document.getElementsByName('nodeName')[0].value;
    var nodeCd = document.getElementsByName('nodeCd')[0].value;
    var businessCatCd = document.getElementsByName('businessCatCd')[0].value;
    
    var queryString = "?electionName="+electionName+"&pageNo="+pageNo+"&nodeCd="+nodeCd+"&nodeName="+nodeName+"&businessCatCd="+businessCatCd;
    ajaxRequest.open("POST", "setShopLicenseDefaultersFilter.php" + queryString, true);
    ajaxRequest.send(null);
}



//Tracking functions

function setNodeCdinSession(NodeCd) {
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

    if(NodeCd == ''){
        alert("Please select Ward");
    }else{
        var queryString = "?NodeCd="+NodeCd;
        ajaxRequest.open("POST", "setNodeCdInSessionTracking.php" + queryString, true);
        ajaxRequest.send(null);
    }
}

function setBusinessCatinSession(BusinessCatCd) {
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

    if(BusinessCatCd == ''){
        alert("Please select Business Category");
    }else{
        var queryString = "?BusinessCatCd="+BusinessCatCd;
        ajaxRequest.open("POST", "setBussinesssCatinSessionTracking.php" + queryString, true);
        ajaxRequest.send(null);

    }

}

function setShopNameinSession(ShopCd) {
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

    if(ShopCd == ''){
            alert("Please select Shop");
    }else{
        var queryString = "?ShopCd="+ShopCd;
        ajaxRequest.open("POST", "setShopCdInSessionTracking.php" + queryString, true);
        ajaxRequest.send(null);

    }

}

function setSHopCdinSession(ShopCd) {
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


    var queryString = "?ShopCd="+ShopCd;
    ajaxRequest.open("POST", "setShopCdInSessionTracking.php" + queryString, true);
    ajaxRequest.send(null);

}