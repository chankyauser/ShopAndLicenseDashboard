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

function setPocketIdInSession(pocketCd) {
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

    // if (electionName === '') {
    //     alert("Please Select Corporation!");
    // } else
     if (pocketCd === '') {
        alert("Please Select Pocket!");
    } else {
        
        var queryString = "?pocketCd=" + pocketCd;
        ajaxRequest.open("POST", "setPocketIdInSession.php" + queryString, true);
        ajaxRequest.send(null);

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


function setCallingDateInSession() {
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
    var callingDate = document.getElementsByName('callingDate')[0].value;
    // if (electionName === '') {
    //     alert("Please Select Corporation!");
    // } else
     if (callingDate === '') {
        alert("Please Select Calling Date!");
    } else {
        // var queryString = "?callingDate=" + callingDate+"&electionName="+electionName;
        var queryString = "?callingDate=" + callingDate;
        ajaxRequest.open("POST", "setCallingDateInSession.php" + queryString, true);
        ajaxRequest.send(null);

    }

}

function setAssignDateInSession() {
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
    var assign_date = document.getElementsByName('assign_date')[0].value;
    // if (electionName === '') {
    //     alert("Please Select Corporation!");
    // } else
     if (assign_date === '') {
        alert("Please Select Assign Date!");
    } else {
        // var queryString = "?assignDate=" + assign_date+"&electionName="+electionName;
        var queryString = "?assignDate=" + assign_date;
        ajaxRequest.open("POST", "setAssignDateInSession.php" + queryString, true);
        ajaxRequest.send(null);

    }

}

function setExecutiveNameInSession() {
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
    var executiveCd = document.getElementsByName('executiveCd')[0].value;
    // if (electionName === '') {
    //     alert("Please Select Corporation!");
    // } else
     if (executiveCd === '') {
        alert("Please Select Executive Name!");
    } else {
        // var queryString = "?executiveCd=" + executiveCd+"&electionName="+electionName;
        var queryString = "?executiveCd=" + executiveCd;
        ajaxRequest.open("POST", "setExecutiveNameInSession.php" + queryString, true);
        ajaxRequest.send(null);

    }

}


function setCallingTypeInSession() {
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
    var calling_Type = document.getElementsByName('calling_Type')[0].value;
    // if (electionName === '') {
    //     alert("Please Select Corporation!");
    // } else
     if (calling_Type === '') {
        alert("Please Select Assign Type!");
    } else {
        // var queryString = "?callingType=" + calling_Type+"&electionName="+electionName;
        var queryString = "?callingType=" + calling_Type;
        ajaxRequest.open("POST", "setCallingTypeInSession.php" + queryString, true);
        ajaxRequest.send(null);

    }

}

function setCallingCategoryInSession() {
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
        // var splits = partyCd.split(",");
        // var partyCd = splits[0];
        // var party = splits[1];

    // var electionName = document.getElementsByName('electionName')[0].value;
    var callingCategory = document.getElementsByName('calling_Category')[0].value;
    // if (electionName === '') {
    //     alert("Please Select Corporation!");
    // } else
     if (callingCategory === '') {
        alert("Please Select Zone!");
    } else {
        // var queryString = "?callingCategoryCd=" + callingCategory+"&electionName="+electionName;
        var queryString = "?callingCategoryCd=" + callingCategory;
        ajaxRequest.open("POST", "setCallingCategoryInSession.php" + queryString, true);
        ajaxRequest.send(null);

    }

}


function setCallingFilterTypeInSession(ccfilterType) {
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
    // var electionName = document.getElementsByName('electionName')[0].value;

    // if (electionName === '') {
    //     alert("Please Select Corporation!");
    // } else
     if (ccfilterType === '') {
        alert("Please Filter Type!");
    } else {
        var queryString = "?ccfilterType=" + ccfilterType;
        ajaxRequest.open("POST", "setCallingFilterTypeInSession.php" + queryString, true);
        ajaxRequest.send(null);

    }

}


function setCCExecutiveInSession(ccExecutive) {
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
    // var electionName = document.getElementsByName('electionName')[0].value;

    // if (electionName === '') {
    //     alert("Please Select Corporation!");
    // } else
     if (ccExecutive === '') {
        alert("Please ExecutiveName!");
    } else {
        var queryString = "?ccExecutive=" + ccExecutive;
        ajaxRequest.open("POST", "setCCExecutiveInSession.php" + queryString, true);
        ajaxRequest.send(null);

    }

}



function setNodeNameInSessionWORefresh() {
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
        // var splits = partyCd.split(",");
        // var partyCd = splits[0];
        // var party = splits[1];

    // var electionName = document.getElementsByName('electionName')[0].value;
    var nodeName = document.getElementsByName('node_Name')[0].value;
    if (nodeName === '') {
        alert("Please Select Zone!");
    } else {
        // var queryString = "?nodeName=" + nodeName+"&electionName="+electionName;
        var queryString = "?nodeName=" + nodeName;
        ajaxRequest.open("POST", "setNodeNameInSession.php" + queryString, true);
        ajaxRequest.send(null);

    }

}

// Pocket Assign Function Starts From Here

function setPocketAssignNodeNameInSession(nodeName) {
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
        ajaxRequest.open("POST", "setPocketAssignNodeNameInSession.php" + queryString, true);
        ajaxRequest.send(null);

        // console.log(nodeName);

    }

}

function setNodeCdAndWardNoInSession() {
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
                // console.log(ajaxRequest.responseText);
            }
        }
      

    // var electionName = document.getElementsByName('electionName')[0].value;
    var nodeCd = document.getElementsByName('node_Cd')[0].value;
      // var splits = partyCd.split(",");
      //   var partyCd = splits[0];
      //   var party = splits[1];
    // if (electionName === '') {
    //     alert("Please Select Corporation!");
    // } else 
    if (nodeCd === '') {
        alert("Please Select Ward!");
    } else {
        // var queryString = "?nodeCd=" + nodeCd+"&electionName="+electionName;
        var queryString = "?nodeCd=" + nodeCd;
        ajaxRequest.open("POST", "setNodeCdAndWardNoInSession.php" + queryString, true);
        ajaxRequest.send(null);

    }

}


function setNodeCdAndWardNoInSessionWORefresh() {
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
                // var ajaxDisplay = document.getElementById('pocketWiseSurveyDetailId');
                // ajaxDisplay.innerHTML = ajaxRequest.responseText;
                // location.reload(true);
            }
        }
        // var splits = partyCd.split(",");
        // var partyCd = splits[0];
        // var party = splits[1];

    // var electionName = document.getElementsByName('electionName')[0].value;
    var nodeCd = document.getElementsByName('node_Cd')[0].value;
    if (nodeCd === '') {
        alert("Please Select Ward!");
    } else {
        // var queryString = "?nodeCd=" + nodeCd+"&electionName="+electionName;
        var queryString = "?nodeCd=" + nodeCd;
        ajaxRequest.open("POST", "setNodeCdAndWardNoInSession.php" + queryString, true);
        ajaxRequest.send(null);

    }

}


function setPocketNameByNodeCdAndNameWithDateRange() {
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
  
    // var electionName = document.getElementsByName('electionName')[0].value;
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
    var node_Name = document.getElementsByName('node_Name')[0].value;
    var nodeCd = document.getElementsByName('node_Cd')[0].value;
    if (nodeCd === '') {
        alert("Please Select Ward!");
    } else {
        // var queryString = "?nodeCd=" + nodeCd+"&electionName="+electionName;
        var queryString = "?nodeCd=" + nodeCd+"&node_Name="+node_Name+"&fromDate="+fromDate+"&toDate="+toDate;
        ajaxRequest.open("POST", "setPocketNameByNodeCdWithDateRange.php" + queryString, true);
        ajaxRequest.send(null);
    }

}

function setPocketNameByNodeCdWithDateRange() {
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
                var ajaxDisplay = document.getElementById('pocketSurveyListId');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
            }
        }
  
    // var electionName = document.getElementsByName('electionName')[0].value;
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
    var node_Name = document.getElementsByName('node_Name')[0].value;
    var nodeCd = document.getElementsByName('node_Cd')[0].value;
    if (nodeCd === '') {
        alert("Please Select Ward!");
    } else {
        // var queryString = "?nodeCd=" + nodeCd+"&electionName="+electionName;
        var queryString = "?nodeCd=" + nodeCd+"&node_Name="+node_Name+"&fromDate="+fromDate+"&toDate="+toDate;
        ajaxRequest.open("POST", "setPocketNameByNodeCdWithDateRange.php" + queryString, true);
        ajaxRequest.send(null);
    }

}


function setExecutiveNameByNodeCdWithDateRange() {
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
                var ajaxDisplay = document.getElementById('executiveSurveyListId');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
                $('#executiveWiseSurveyDetailId').hide();
            }
        }
  
    // var electionName = document.getElementsByName('electionName')[0].value;
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
    var nodeCd = document.getElementsByName('node_Cd')[0].value;
    var node_Name = document.getElementsByName('node_Name')[0].value;
    if (nodeCd === '') {
        alert("Please Select Ward!");
    } else {
        // var queryString = "?nodeCd=" + nodeCd+"&electionName="+electionName;
        var queryString = "?nodeCd=" + nodeCd+"&node_Name=" + node_Name+"&fromDate="+fromDate+"&toDate="+toDate;
        ajaxRequest.open("POST", "setExecutiveNameByNodeCdWithDateRange.php" + queryString, true);
        ajaxRequest.send(null);
    }

}



function UpdateLoginMasterData() {
   
    var user_name = document.getElementsByName('user_name')[0].value;
    var userType = document.getElementsByName('user_Type')[0].value;
    var designation = document.getElementsByName('user_designation')[0].value;
   
 
        $.ajax({
            type: "POST",
            url: 'action/getLoginMasterData.php',
            data: {
                user_name: user_name,
                userType: userType,
                designation: designation
            
            },
            beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('#submitLoginBtnId').attr("disabled", true);
                //$('#submitmsg').show();
                $('html').addClass("ajaxLoading");
            },
            success: function(dataResult) 
            {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    
                        //console.log(dataResult.userinformation.IsVerified);
                    $("#submitmsgsuccess").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgsuccess").append("");
                            window.location.href = 'home.php?p=login-master';
                        }).delay(3000).fadeOut("fast");

                } else if (dataResult.error == true ) {
                    $("#submitmsgfailed").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgfailed").append("");
                        }).delay(3000).fadeOut("fast");

                }
               
                // return data;
            },
            complete: function() {
                    $('#submitLoginBtnId').attr("disabled", false);
                    //$('#submitmsg').hide();
                    $('html').removeClass("ajaxLoading");
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
}


function NodeMaster() {

    var nodeCd = document.getElementsByName('node_Cd')[0].value;
    var nodeName = document.getElementsByName('node_Name')[0].value;
    var nodeNameMar = document.getElementsByName('nodeNameMar')[0].value;
    var assembly_no = document.getElementsByName('assembly_no')[0].value;
    var wardNo = document.getElementsByName('wardNo')[0].value;
    var address = document.getElementsByName('address')[0].value;
    var area = document.getElementsByName('area')[0].value;
    var remark = document.getElementsByName('remark')[0].value;
    var IsActive = document.getElementsByName('IsActive')[0].value;
   
    if(nodeName===''){
        alert('Enter Node Name');
    }else if(wardNo===''){
        alert('Enter Ward No');
    }else if(area===''){
        alert('Enter Area');
    }else{
        $.ajax({
            type: "POST",
            url: 'action/ActionNodeMaster.php',
            data: {
                nodeCd : nodeCd,
                node_Name: nodeName,
                nodeNameMar: nodeNameMar,
                assembly_no: assembly_no,
                wardNo: wardNo,
                address: address,
                area: area,
                remark: remark,
                IsActive: IsActive
            
            },
            beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('#submitNodeBtnId').attr("disabled", true);
                //$('#submitmsg').show();
                $('html').addClass("ajaxLoading");
            },
            success: function(dataResult) 
            {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    
                        //console.log(dataResult.userinformation.IsVerified);
                    $("#submitmsgsuccess").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgsuccess").append("");
                            window.location.href = 'home.php?p=node-master';
                        }).delay(3000).fadeOut("fast");

                } else if (dataResult.error == true ) {
                    $("#submitmsgfailed").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgfailed").append("");
                        }).delay(3000).fadeOut("fast");

                }
               
                // return data;
            },
            complete: function() {
                    $('#submitNodeBtnId').attr("disabled", false);
                    //$('#submitmsg').hide();
                    $('html').removeClass("ajaxLoading");
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
   }
        
}

function BusinessCategoryMaster() {

    var businessCat_Cd = document.getElementsByName('BusinessCat_Cd')[0].value;
    var businessCategoryName = document.getElementsByName('businessCategoryName')[0].value;
    var businessCategoryNameMar = document.getElementsByName('businessCategoryNameMar')[0].value;
    var taxPercentage = document.getElementsByName('taxPercentage')[0].value;
    var remark = document.getElementsByName('remark')[0].value;
    var IsActive = document.getElementsByName('IsActive')[0].value;
    if(businessCategoryName===''){
        alert('Enter Business Category Name');
    }else{
 
        $.ajax({
            type: "POST",
            url: 'action/ActionBusinessCategoryMaster.php',
            data: {

                BusinessCat_Cd : businessCat_Cd,
                businessCategoryName: businessCategoryName,
                businessCategoryNameMar: businessCategoryNameMar,
                taxPercentage: taxPercentage,
                remark: remark,
                IsActive: IsActive
            
            },
            beforeSend: function() {
                $('#submitBtnId').attr("disabled", true);
                //$('#submitmsg').show();
                $('html').addClass("ajaxLoading");
            },
            success: function(dataResult) 
            {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    $("#submitmsgsuccess").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgsuccess").append("");
                            window.location.href = 'home.php?p=business-category-master';
                        }).delay(3000).fadeOut("fast");

                } else if (dataResult.error == true ) {
                    $("#submitmsgfailed").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgfailed").append("");
                        }).delay(3000).fadeOut("fast");

                }
               
                // return data;
            },
            complete: function() {
                    $('#submitBtnId').attr("disabled", false);
                    //$('#submitmsg').hide();
                    $('html').removeClass("ajaxLoading");
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
    }
}

function DropDownMaster() {

    var DropDown_Cd = document.getElementsByName('DropDown_Cd')[0].value;
    var DTitle = document.getElementsByName('DTitle')[0].value;
    var DValue = document.getElementsByName('DValue')[0].value;
    var SerialNo = document.getElementsByName('SerialNo')[0].value;
    var remark = document.getElementsByName('remark')[0].value;
    var IsActive = document.getElementsByName('IsActive')[0].value;
   
    if(DTitle===''){
        alert('Enter DropDown Type Title');
    }else if(DValue===''){
        alert('Enter DropDown Value');
    }else if(SerialNo===''){
        alert('Enter Serial No');
    }else{
        $.ajax({
            type: "POST",
            url: 'action/ActionDropDownMaster.php',
            data: {
                DropDown_Cd : DropDown_Cd,
                DTitle: DTitle,
                DValue: DValue,
                SerialNo: SerialNo,
                remark: remark,
                IsActive: IsActive
            
            },
            beforeSend: function() {
                $('#submitBtnId').attr("disabled", true);
                //$('#submitmsg').show();
                $('html').addClass("ajaxLoading");
            },
            success: function(dataResult) 
            {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    $("#submitmsgsuccess").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgsuccess").append("");
                            window.location.href = 'home.php?p=drop-down-master';
                        }).delay(3000).fadeOut("fast");

                } else if (dataResult.error == true ) {
                    $("#submitmsgfailed").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgfailed").append("");
                        }).delay(3000).fadeOut("fast");

                }
               
                // return data;
            },
            complete: function() {
                    $('#submitBtnId').attr("disabled", false);
                    //$('#submitmsg').hide();
                    $('html').removeClass("ajaxLoading");
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
    }
}

function ShopAreaMaster() {

    var ShopArea_Cd = document.getElementsByName('ShopArea_Cd')[0].value;
    var shopAreaName = document.getElementsByName('shopAreaName')[0].value;
    var shopAreaNameMar = document.getElementsByName('shopAreaNameMar')[0].value;
    var taxPercentage = document.getElementsByName('taxPercentage')[0].value;
    var remark = document.getElementsByName('remark')[0].value;
    var IsActive = document.getElementsByName('IsActive')[0].value;
    
    if(shopAreaName===''){
        alert('Enter Shop Area Name');
    }else{
 
        $.ajax({
            type: "POST",
            url: 'action/ActionShopAreaMaster.php',
            data: {

                ShopArea_Cd : ShopArea_Cd,
                shopAreaName: shopAreaName,
                shopAreaNameMar: shopAreaNameMar,
                taxPercentage: taxPercentage,
                remark: remark,
                IsActive: IsActive
            
            },
            beforeSend: function() { 
                $('#submitBtnId').attr("disabled", true);
                //$('#submitmsg').show();
                $('html').addClass("ajaxLoading");
            },
            success: function(dataResult) 
            {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    $("#submitmsgsuccess").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgsuccess").append("");
                            window.location.href = 'home.php?p=shop-area-master';
                        }).delay(3000).fadeOut("fast");

                } else if (dataResult.error == true ) {
                    $("#submitmsgfailed").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgfailed").append("");
                        }).delay(3000).fadeOut("fast");

                }
               
                // return data;
            },
            complete: function() {
                    $('#submitBtnId').attr("disabled", false);
                    //$('#submitmsg').hide();
                    $('html').removeClass("ajaxLoading");
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
    }
}

function CallingCategoryMaster() {

    var calling_Category_Cd = document.getElementsByName('Calling_Category_Cd')[0].value;
    var callingCategory = document.getElementsByName('callingCategory')[0].value;
    var callingType = document.getElementsByName('callingType')[0].value;
    var srNo = document.getElementsByName('srNo')[0].value;
    var callingTypeSrNo = document.getElementsByName('callingTypeSrNo')[0].value;
    var qcType = document.getElementsByName('qcType')[0].value;
    var remark = document.getElementsByName('remark')[0].value;
    var IsActive = document.getElementsByName('IsActive')[0].value;
   
    if(callingCategory===''){
        alert('Enter Calling Category');
    }else if(srNo===''){
        alert('Enter Category Sr No');
    }else if(callingType===''){
        alert('Enter Calling Type');
    }else if(callingTypeSrNo===''){
        alert('Enter Calling Type Sr No');
    }else{
 
        $.ajax({
            type: "POST",
            url: 'action/ActionCallingCategoryMaster.php',
            data: {

                calling_Category_Cd : calling_Category_Cd,
                callingCategory: callingCategory,
                callingType: callingType,
                srNo: srNo,
                callingTypeSrNo: callingTypeSrNo,
                qcType: qcType,
                remark: remark,
                IsActive: IsActive
            
            },
            beforeSend: function() { 
                $('#submitBtnId').attr("disabled", true);
                //$('#submitmsg').show();
                $('html').addClass("ajaxLoading");
            },
            success: function(dataResult) 
            {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    $("#submitmsgsuccess").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgsuccess").append("");
                            window.location.href = 'home.php?p=calling-category-master';
                        }).delay(3000).fadeOut("fast");

                } else if (dataResult.error == true ) {
                    $("#submitmsgfailed").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgfailed").append("");
                        }).delay(3000).fadeOut("fast");

                }
               
                // return data;
            },
            complete: function() {
                    $('#submitBtnId').attr("disabled", false);
                    //$('#submitmsg').hide();
                    $('html').removeClass("ajaxLoading");
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
    }
}

function ShopDocumentMaster() {

    var Document_Cd = document.getElementsByName('Document_Cd')[0].value;
    var documentName = document.getElementsByName('documentName')[0].value;
    var documentNameMar = document.getElementsByName('documentNameMar')[0].value;
    var documentType = document.getElementsByName('documentType')[0].value;
    var isCompulsory = document.getElementsByName('isCompulsory')[0].value;
    var IsActive = document.getElementsByName('IsActive')[0].value;
    
    if(documentName===''){
        alert('Enter Document Name');
    }else if(documentType===''){
        alert('Select Document Type');
    }else{
 
        $.ajax({
            type: "POST",
            url: 'action/ActionShopDocumentMaster.php',
            data: {

                Document_Cd : Document_Cd,
                documentName: documentName,
                documentNameMar: documentNameMar,
                documentType: documentType,
                isCompulsory: isCompulsory,
                IsActive: IsActive
            
            },
            beforeSend: function() {
                $('#submitBtnId').attr("disabled", true);
                //$('#submitmsg').show();
                $('html').addClass("ajaxLoading");
            },
            success: function(dataResult) 
            {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    $("#submitmsgsuccess").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgsuccess").append("");
                            window.location.href = 'home.php?p=shop-document-master';
                        }).delay(3000).fadeOut("fast");

                } else if (dataResult.error == true ) {
                    $("#submitmsgfailed").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgfailed").append("");
                        }).delay(3000).fadeOut("fast");

                }
               
                // return data;
            },
            complete: function() {
                    $('#submitBtnId').attr("disabled", false);
                    //$('#submitmsg').hide();
                    $('html').removeClass("ajaxLoading");
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
    }
}

function BoardTaxMaster() {

    var BTM_Cd = document.getElementsByName('BTM_Cd')[0].value;
    var BtmType = document.getElementsByName('Btm_Type')[0].value;
    var boardHeight = document.getElementsByName('boardHeight')[0].value;
    var boardWidth = document.getElementsByName('boardWidth')[0].value;
    var boardAreaWiseTax = document.getElementsByName('boardAreaWiseTax')[0].value;
    var IsActive = document.getElementsByName('IsActive')[0].value;
   
    if(BtmType===''){
        alert('Enter Board Type');
    }else if(boardHeight===''){
        alert('Enter Board Height');
    }else if(boardWidth===''){
        alert('Enter Board Width');
    }else if(boardAreaWiseTax===''){
        alert('Enter Board Area Wise Tax');
    }else{
        $.ajax({
            type: "POST",
            url: 'action/ActionBoardTaxMaster.php',
            data: {

                BTM_Cd : BTM_Cd,
                BtmType: BtmType,
                boardHeight: boardHeight,
                boardWidth: boardWidth,
                boardAreaWiseTax: boardAreaWiseTax,
                IsActive: IsActive
            
            },
            beforeSend: function() {
                $('#submitBtnId').attr("disabled", true);
                //$('#submitmsg').show();
                $('html').addClass("ajaxLoading");
            },
            success: function(dataResult) 
            {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    $("#submitmsgsuccess").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgsuccess").append("");
                            window.location.href = 'home.php?p=board-tax-master';
                        }).delay(3000).fadeOut("fast");
                } else if (dataResult.error == true ) {
                    $("#submitmsgfailed").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgfailed").append("");
                        }).delay(3000).fadeOut("fast");
                }
               
                // return data;
            },
            complete: function() {
                    $('#submitBtnId').attr("disabled", false);
                    //$('#submitmsg').hide();
                    $('html').removeClass("ajaxLoading");
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
    }
}

function FAQMaster() {

    var FAQ_Cd = document.getElementsByName('FAQ_Cd')[0].value;
    var question = document.getElementsByName('question')[0].value;
    var answer = document.getElementsByName('answer')[0].value;
    var usertype = document.getElementsByName('usertype')[0].value;
    var remark = document.getElementsByName('remark')[0].value;
    var IsActive = document.getElementsByName('IsActive')[0].value;
    
    if(question===''){
        alert('Enter Question?');
    }else if(usertype===''){
        alert('Select User Type');
    }else if(answer===''){
        alert('Enter Answer');
    }else{
        $.ajax({
            type: "POST",
            url: 'action/ActionFAQMaster.php',
            data: {
                FAQ_Cd: FAQ_Cd,
                question: question,
                answer: answer,
                usertype: usertype,
                remark: remark,
                IsActive: IsActive
            },
            beforeSend: function() { 
                $('#submitBtnId').attr("disabled", true);
                //$('#submitmsg').show();
                $('html').addClass("ajaxLoading");
            },
            success: function(dataResult) 
            {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    $("#submitmsgsuccess").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgsuccess").append("");
                            window.location.href = 'home.php?p=faq-master';
                        }).delay(3000).fadeOut("fast");

                } else if (dataResult.error == true ) {
                    $("#submitmsgfailed").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgfailed").append("");
                        }).delay(3000).fadeOut("fast");

                }
               
                // return data;
            },
            complete: function() {
                    $('#submitBtnId').attr("disabled", false);
                    //$('#submitmsg').hide();
                    $('html').removeClass("ajaxLoading");
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
    }
}

function StatusMaster() {

    var Status_Cd = document.getElementsByName('Status_Cd')[0].value;
    var ApplicationStatus = document.getElementsByName('ApplicationStatus')[0].value;
    var Remark = document.getElementsByName('Remark')[0].value;
    var IsActive = document.getElementsByName('IsActive')[0].value;
   
        $.ajax({
            type: "POST",
            url: 'action/ActionStatusMaster.php',
            data: {
                Status_Cd: Status_Cd,
                ApplicationStatus: ApplicationStatus,
                Remark: Remark,
                IsActive: IsActive
            },
            beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('#submitBtnId').attr("disabled", true);
                //$('#submitmsg').show();
                $('html').addClass("ajaxLoading");
            },
            success: function(dataResult) 
            {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    
                        //console.log(dataResult.userinformation.IsVerified);
                    $("#submitmsgsuccess").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgsuccess").append("");
                            window.location.href = 'home.php?p=status-master';
                        }).delay(3000).fadeOut("fast");

                } else if (dataResult.error == true ) {
                    $("#submitmsgfailed").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgfailed").append("");
                        }).delay(3000).fadeOut("fast");

                }
               
                // return data;
            },
            complete: function() {
                    $('#submitBtnId').attr("disabled", false);
                    //$('#submitmsg').hide();
                    $('html').removeClass("ajaxLoading");
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
}

function TaxMaster() {

    var Tax_Cd = document.getElementsByName('Tax_Cd')[0].value;
    var TaxName = document.getElementsByName('TaxName')[0].value;
    var PercentageOfTax = document.getElementsByName('PercentageOfTax')[0].value;
    var Remark = document.getElementsByName('Remark')[0].value;
    var IsActive = document.getElementsByName('IsActive')[0].value;
   
        $.ajax({
            type: "POST",
            url: 'action/ActionTaxMaster.php',
            data: {
                Tax_Cd: Tax_Cd,
                TaxName: TaxName,
                PercentageOfTax: PercentageOfTax,
                Remark: Remark,
                IsActive: IsActive
            },
            beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('#submitBtnId').attr("disabled", true);
                //$('#submitmsg').show();
                $('html').addClass("ajaxLoading");
            },
            success: function(dataResult) 
            {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    
                        //console.log(dataResult.userinformation.IsVerified);
                    $("#submitmsgsuccess").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgsuccess").append("");
                            window.location.href = 'home.php?p=tax-master';
                        }).delay(3000).fadeOut("fast");

                } else if (dataResult.error == true ) {
                    $("#submitmsgfailed").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgfailed").append("");
                        }).delay(3000).fadeOut("fast");

                }
               
                // return data;
            },
            complete: function() {
                    $('#submitBtnId').attr("disabled", false);
                    //$('#submitmsg').hide();
                    $('html').removeClass("ajaxLoading");
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
}

function getLicenseDefaulterList(){
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
                    window.location.href='home.php?p=shop-license-defaulters-detail';
    
                }
            }
        }
      
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
    
        var queryString = "?fromDate="+fromDate+"&toDate="+toDate;
        ajaxRequest.open("POST", "setLicenseDefaulterList.php" + queryString, true);
        ajaxRequest.send(null);
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
    var node_Name = document.getElementsByName('node_Name')[0].value;
    // if (electionName === '') {
    //     alert("Please Select Corporation!");
    // }else 
    if (nodeCd === '') {
        alert("Please Select Ward Name!");
    } else {
        // var queryString = "?nodeCd=" + nodeCd+"&electionName="+electionName+"&fromDate="+fromDate+"&toDate="+toDate;
        var queryString = "?nodeCd=" + nodeCd+"&node_Name=" + node_Name+"&fromDate="+fromDate+"&toDate="+toDate;
        ajaxRequest.open("POST", "setPocketWiseSurveySummary.php" + queryString, true);
        ajaxRequest.send(null);

    }
}


function setShopListingDetailPaginationPageNo(pageNo){
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
                var ajaxDisplay = document.getElementById('tblPocketsShopList');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
                $('.zero-configuration').DataTable();
                $('html, body').animate({
                    scrollTop: $("#tblPocketsShopList").offset().top - 200
                }, 500);

            }
        }
   
    var electionName = document.getElementsByName('electionName')[0].value;
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
    var node_Name = document.getElementsByName('node_Name')[0].value;
    var nodeCd = document.getElementsByName('node_Cd')[0].value;
    var pocketCd = document.getElementsByName('pocket_Name')[0].value;
    var executiveCd = document.getElementsByName('executive_Name')[0].value;
     if (electionName === '') {
         alert("Please Select Corporation!");
    } else if (pocketCd === '') {
        alert("Please Select Pocket!");
    } else {
        var queryString = "?pocketCd=" + pocketCd+"&executiveCd=" + executiveCd+"&electionName="+electionName+"&node_Name=" + node_Name+"&nodeCd=" + nodeCd+"&fromDate="+fromDate+"&toDate="+toDate+"&pageNo="+pageNo;
        ajaxRequest.open("POST", "setShopListingDetailPaginationPageNo.php" + queryString, true);
        ajaxRequest.send(null);
    }
}


function getPocketWiseShopsListing(){
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
                var ajaxDisplay = document.getElementById('tblPocketsShopList');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
                $('.zero-configuration').DataTable();
                $('html, body').animate({
                    scrollTop: $("#tblPocketsShopList").offset().top - 200
                }, 500);

                $('.pickadate').pickadate({
                    format: 'yyyy-mm-dd'
                });
                
            }
        }
   
    var electionName = document.getElementsByName('electionName')[0].value;
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
    var node_Name = document.getElementsByName('node_Name')[0].value;
    var nodeCd = document.getElementsByName('node_Cd')[0].value;
    var pocketCd = document.getElementsByName('pocket_Name')[0].value;
    var executiveCd = document.getElementsByName('executive_Name')[0].value;
     if (electionName === '') {
         alert("Please Select Corporation!");
    } else if (pocketCd === '') {
        alert("Please Select Pocket!");
    } else {
        var queryString = "?pocketCd=" + pocketCd+"&executiveCd=" + executiveCd+"&electionName="+electionName+"&node_Name=" + node_Name+"&nodeCd=" + nodeCd+"&fromDate="+fromDate+"&toDate="+toDate;
        ajaxRequest.open("POST", "setPocketWiseShopsListing.php" + queryString, true);
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
                window.location.href='home.php?p=pocket-wise-survey-detail';
            }
        }
   
    var electionName = document.getElementsByName('electionName')[0].value;
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
    var node_Name = document.getElementsByName('node_Name')[0].value;
    var nodeCd = document.getElementsByName('node_Cd')[0].value;
    var pocketCd = document.getElementsByName('pocket_Name')[0].value;
    var executiveCd = document.getElementsByName('executive_Name')[0].value;
    if (electionName === '') {
        alert("Please Select Corporation!");
    } else if (pocketCd === '') {
        alert("Please Select Pocket!");
    } else {
        var queryString = "?pocketCd=" + pocketCd+"&executiveCd=" + executiveCd+"&electionName="+electionName+"&node_Name=" + node_Name+"&nodeCd=" + nodeCd+"&fromDate="+fromDate+"&toDate="+toDate;
        ajaxRequest.open("POST", "setPocketWiseSurveyDetail.php" + queryString, true);
        ajaxRequest.send(null);
    }
}



function getExecutiveWiseSurveyDetail(executiveCd){
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
                // window.location.href='home.php?p=executive-wise-survey-detail';
                $('#executiveWiseSurveyDetailId').show();
                var dataListView = $('#data-list-view1').DataTable({
                    responsive: true,
                    columnDefs: [
                    {
                        orderable: true,
                        targets: 0,
                    }
                    ],
                    oLanguage: {
                    sLengthMenu: "_MENU_",
                    sSearch: ""
                    },
                    // aLengthMenu: [[1, 4, 10, 15, 20], [1, 4, 10, 15, 20]],
                        
                    order: [[0, "asc"]],
                    bInfo: true,
                    pageLength: 10
                });
            }
        }
   
    // var electionName = document.getElementsByName('electionName')[0].value;
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
   
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



function setShopQCSummaryData() {
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
    var electionName = document.getElementsByName('electionName')[0].value;
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
    var node_Name = document.getElementsByName('node_Name')[0].value;
    var nodeCd = document.getElementsByName('node_Cd')[0].value;
    var pocketCd = document.getElementsByName('pocket_Name')[0].value;
    var executiveCd = document.getElementsByName('executiveCd')[0].value;

    if (fromDate === '') {
        alert("Please Select From Date!");
    } else if (toDate === '') {
        alert("Please Select To Date!");
    } else {
        var queryString = "?fromDate="+fromDate+"&toDate="+toDate+"&executiveCd="+executiveCd+"&electionName="+electionName+"&node_Name=" + node_Name+"&nodeCd=" + nodeCd+"&pocketCd=" + pocketCd;
        ajaxRequest.open("POST", "setShopQCSummaryFilterData.php" + queryString, true);
        ajaxRequest.send(null);
    }

}


function setShopQCLogDetailData(pageNo) {
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
                var ajaxDisplay = document.getElementById('qclogDetailId');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
                $('.zero-configuration').DataTable();
                $('.pickadate').pickadate({
                    format: 'yyyy-mm-dd'
                });
                $('html, body').animate({
                    scrollTop: $("#qclogDetailId").offset().top - 200
                }, 500);
            }
        }
    var electionName = document.getElementsByName('electionName')[0].value;
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
    var node_Name = document.getElementsByName('node_Name')[0].value;
    var nodeCd = document.getElementsByName('node_Cd')[0].value;
    var pocketCd = document.getElementsByName('pocket_Name')[0].value;
    var executiveCd = document.getElementsByName('executiveCd')[0].value;

    if (fromDate === '') {
        alert("Please Select From Date!");
    } else if (toDate === '') {
        alert("Please Select To Date!");
    } else {
        var queryString = "?fromDate="+fromDate+"&toDate="+toDate+"&executiveCd="+executiveCd+"&electionName="+electionName+"&node_Name=" + node_Name+"&nodeCd=" + nodeCd+"&pocketCd=" + pocketCd+"&pageNo="+pageNo;
        ajaxRequest.open("POST", "setShopQCLogFilterData.php" + queryString, true);
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
  document.getElementsByName("shopsAssignCount")[0].value = "" + total.toFixed(0);
  document.getElementsByName("pocketsCount")[0].value = "" + selected.toFixed(0);
}

function setAllShopAssignTrackings(ele){
     var checkboxes = document.getElementsByName("assignShopTrackings");
        if (ele.checked) {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = true;
                }
                 console.log(i)
            }
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                console.log(i)
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = false;
                }
            }
        }
    setSelectMultipleAssignShopTrackings();
}

function setSelectMultipleAssignShopTrackings() {
  var input = document.getElementsByName("assignShopTrackings");
  
  var selected = 0;
  var total = 0;
  var chkStCd = "";

  for (var i = 0; i < input.length; i++) {
    if (input[i].checked) {
        var splits = input[i].value.split(",");
        var stCd = splits[0];
        var stStatus = splits[1];
         chkStCd += stCd+",";  
         
        total += parseFloat(stStatus);
        selected ++;
      }
    
  }
  chkStCd = chkStCd.substring(0, chkStCd.length - 1);
  document.getElementsByName("multipleShopTrackings")[0].value = "" + chkStCd;
  document.getElementsByName("shopsCount")[0].value = "" + selected.toFixed(0);
  document.getElementsByName("shopsAssignCount")[0].value = "" + selected.toFixed(0);

}


function setSelectMultipleAssignShopSchedules() {
  var input = document.getElementsByName("assignShopSchedules");
  
  var selected = 0;
  var total = 0;
  var chkSdCd = "";

  for (var i = 0; i < input.length; i++) {
    if (input[i].checked) {
        var splits = input[i].value.split(",");
        var sdCd = splits[0];
        var sdShops = splits[1];
         chkSdCd += sdCd+",";  
         
        total += parseFloat(sdShops);
        selected ++;
      }
    
  }
  chkSdCd = chkSdCd.substring(0, chkSdCd.length - 1);
  document.getElementsByName("multipleShopSchedules")[0].value = "" + chkSdCd;
  document.getElementsByName("shopsCount")[0].value = "" + selected.toFixed(0);
  document.getElementsByName("shopsAssignCount")[0].value = "" + selected.toFixed(0);

}

function submitTransferOrEditAssignedShopsData(){
    var electionName = document.getElementsByName('electionName')[0].value;
    var assignDate = document.getElementsByName('assign_date')[0].value;
    var callingType = document.getElementsByName('calling_Type')[0].value;
    var executiveCd = document.getElementsByName('executiveCd')[0].value;
    var multipleShopTrackings = document.getElementsByName('multipleShopTrackings')[0].value;
    var tempExecutiveCd = document.getElementsByName('tempExecutive_Cd')[0].value;
    var action = document.getElementsByName('action')[0].value;
   
    if (electionName === '') {
        alert("Select Corporation!!");
    } else if (assignDate === '') {
        alert("Select Assign Date!!");
    } else if (executiveCd === '') {
        alert("Select Executive!!");
    } else if (multipleShopTrackings === '') {
        alert("Select at least 1 Shop!!");
    } else  {
        $.ajax({
            type: "POST",
            url: 'action/saveTransferOrEditAssignedShopsData.php',
            data: {
                electionName: electionName,
                assignDate: assignDate,
                callingType: callingType,
                executiveCd: executiveCd,
                tempExecutiveCd: tempExecutiveCd,
                multipleShopTrackings: multipleShopTrackings,
                action: action
            },
            beforeSend: function() { 
                $('#submitTransferAssignShopsBtnId').attr("disabled", true);
                $('html').addClass("ajaxLoading");
            },
            success: function(dataResult) {
                console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.statusCode == 200 || dataResult.statusCode == 204 || dataResult.statusCode == 206 ) {
                   
                    $("#submitmsgsuccess").html(dataResult.msg)
                        .hide().fadeIn(800, function() {
                            $("submitmsgsuccess").append("");
                            window.location.href = 'home.php?p=shops-assign';
                        }).delay(3000).fadeOut("fast");

                } else if (dataResult.statusCode == 404 || dataResult.statusCode == 203) {
                    $("#submitmsgfailed").html(dataResult.msg)
                        .hide().fadeIn(800, function() {
                            $("submitmsgfailed").append("");
                            window.location.href = 'home.php?p=shops-assign';
                        }).delay(3000).fadeOut("fast");

                }
               
                // return data;
            },
            complete: function() {
                    $('#submitTransferAssignShopsBtnId').attr("disabled", false);
                    $('html').removeClass("ajaxLoading");
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
    }
}


function submitLoginMasterFormData() {
    var electionName = document.getElementsByName('electionName')[0].value;
    var loginCd = document.getElementsByName('loginCd')[0].value;
    var userCd = document.getElementsByName('userName')[0].value;
    var designation = document.getElementsByName('designation')[0].value;
    var expDate = document.getElementsByName('expDate')[0].value;
    var deActivateFlag = document.getElementsByName('deActivateFlag')[0].value;
    var remark = document.getElementsByName('remark')[0].value;
    var action = document.getElementsByName('action')[0].value;
   
    if (electionName === '') {
        alert("Select Corporation!!");
    } else if (userCd === '') {
        alert("Select User!!");
    } else if (designation === '') {
        alert("Select Designation!!");
    } else if (expDate === '') {
        alert("Select License Expiry Date!!");
    } else  {
        $.ajax({
            type: "POST",
            url: 'action/saveLoginMasterFormData.php',
            data: {
                electionName: electionName,
                loginCd: loginCd,
                userCd: userCd,
                designation: designation,
                expDate: expDate,
                deActivateFlag: deActivateFlag,
                remark: remark,
                action: action
            },
            beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('#submitLoginMasterBtnId').attr("disabled", true);
                $('html').addClass("ajaxLoading");
            },
            success: function(dataResult) {
                console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.statusCode == 200 || dataResult.statusCode == 204 || dataResult.statusCode == 206 ) {
                   
                    $("#submitmsgsuccess").html(dataResult.msg)
                        .hide().fadeIn(800, function() {
                            $("submitmsgsuccess").append("");
                            window.location.href = 'home.php?p=login-master';
                        }).delay(3000).fadeOut("fast");

                } else if (dataResult.statusCode == 404 || dataResult.statusCode == 203) {
                    $("#submitmsgfailed").html(dataResult.msg)
                        .hide().fadeIn(800, function() {
                            $("submitmsgfailed").append("");
                            window.location.href = 'home.php?p=login-master';
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
                            window.location.href = 'home.php?p=category-master';
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

        var arrayWard = Ward_No.split(',');
        var NodeCd = arrayWard[0];
        var WardNo = arrayWard[1];
        var queryString = "?Node_Cd="+NodeCd+"&Ward_No="+WardNo;
        ajaxRequest.open("POST", "setWardInSession.php" + queryString, true);
        ajaxRequest.send(null);

        // console.log(Ward_No);
    }

}


function setAssignShopsToExecutiveByPockets(){
    var electionName = document.getElementsByName('electionName')[0].value;
    var node_Name = document.getElementsByName('node_Name')[0].value;
    var node_Cd = document.getElementsByName('node_Cd')[0].value;
    var shopAssignFilterType = document.getElementsByName('shopAssignFilterType')[0].value;
    var calling_Type = document.getElementsByName('calling_Type')[0].value;
    var executiveCd = document.getElementsByName('executiveCd')[0].value;
    var shopsAssignCount = document.getElementsByName('shopsAssignCount')[0].value;
    var multiplePockets = document.getElementsByName('multiplePockets')[0].value;
    var assignDate = document.getElementsByName('assign_date')[0].value;
   
    if (electionName === '') {
        alert("Select Corporation!!");
    } else if (shopAssignFilterType === '') {
        alert("Select Filter Type!!");
    } else if (calling_Type === '') {
        alert("Select Assign Type!!");
    } else if (assignDate === '') {
        alert("Enter Assign Date !!");
    } else if (multiplePockets === '') {
        alert("Select Pocket!!");
    } else if (shopsAssignCount === '') {
        alert("Enter Shops Counts!!");
    } else {
        $.ajax({
            type: "POST",
            url: 'action/setAssignShopsToExecutiveData.php',
            data: {
                electionName: electionName,
                node_Name: node_Name,
                node_Cd: node_Cd,
                shopAssignFilterType: shopAssignFilterType,
                calling_Type: calling_Type,
                assignDate: assignDate,
                multiplePockets: multiplePockets,
                shopsAssignCount: shopsAssignCount,
                executiveCd:executiveCd
            },
           
            beforeSend: function() { 
                $('#submitShopsAssignBtnId').attr("disabled", true);
                $('#idAssignShopsLoading').show();
            },
            success: function(dataResult) {           
                var dataResult = JSON.parse(dataResult);
                // console.log(dataResult);

                if (dataResult.statusCode == 200 ) {
                        $("#idAssignShopsMsgSuccess").html("<h5> "+dataResult.msg+" </h5>")
                        .hide().fadeIn(800, function() {
                            window.location.href = 'home.php?p=shops-assign';
                        }).delay(3000).fadeOut("fast");
                } else if (dataResult.statusCode == 204 ) {
                    $("#idAssignShopsMsgFailure").html("<h5> "+dataResult.msg+" </h5>")
                        .hide().fadeIn(800, function() {
                            window.location.href = 'home.php?p=shops-assign';
                        }).delay(3000).fadeOut("fast");
                }
               
                // return data;
            },
            complete: function() {
                   $('#submitShopsAssignBtnId').attr("disabled", false);
                   $('#idAssignShopsLoading').hide();
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
    }
}


function submitAssignShopsToExecutiveByPocketsAndSchedules(){
    var electionName = document.getElementsByName('electionName')[0].value;
    var shopAssignFilterType = document.getElementsByName('shopAssignFilterType')[0].value;
    var calling_Type = document.getElementsByName('calling_Type')[0].value;
    var executiveCd = document.getElementsByName('executiveCd')[0].value;
    var shopsAssignCount = document.getElementsByName('shopsAssignCount')[0].value;
    var multiplePockets = document.getElementsByName('multiplePockets')[0].value;
    var multipleShopSchedules = document.getElementsByName('multipleShopSchedules')[0].value;
    var assignDate = document.getElementsByName('assign_date')[0].value;
   
    if (electionName === '') {
        alert("Select Corporation!!");
    } else if (shopAssignFilterType === '') {
        alert("Select Filter Type!!");
    } else if (calling_Type === '') {
        alert("Select Assign Type!!");
    } else if (assignDate === '') {
        alert("Enter Assign Date !!");
    } else if (multiplePockets === '') {
        alert("Select Pocket!!");
    } else if (multipleShopSchedules === '') {
        alert("Select Shop!!");
    } else if (shopsAssignCount === '') {
        alert("Enter Shops Counts!!");
    } else {
        $.ajax({
            type: "POST",
            url: 'action/setAssignShopsToExecutiveData.php',
            data: {
                electionName: electionName,
                shopAssignFilterType: shopAssignFilterType,
                calling_Type: calling_Type,
                assignDate: assignDate,
                multiplePockets: multiplePockets,
                multipleShopSchedules: multipleShopSchedules,
                shopsAssignCount: shopsAssignCount,
                executiveCd:executiveCd
            },
           
            beforeSend: function() { 
                $('#submitAssignShopsSchedulesBtnId').attr("disabled", true);
            },
            success: function(dataResult) {           
                var dataResult = JSON.parse(dataResult);
                console.log(dataResult);

                if (dataResult.statusCode == 200 ) {
                        $("#submitmsgsuccess").html("<h5> "+dataResult.msg+" </h5>")
                        .hide().fadeIn(800, function() {
                            window.location.href = 'home.php?p=shops-assign';
                        }).delay(3000).fadeOut("fast");
                } else if (dataResult.statusCode == 204 ) {
                    $("#submitmsgfailed").html("<h5> "+dataResult.msg+" </h5>")
                        .hide().fadeIn(800, function() {
                            window.location.href = 'home.php?p=shops-assign';
                        }).delay(3000).fadeOut("fast");
                }
               
                // return data;
            },
            complete: function() {
                    $('#submitAssignShopsSchedulesBtnId').attr("disabled", false);
                   
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
    }
}

function setAssignPocketToExecutive(userId,executiveCd){
    var electionName = document.getElementsByName('electionName')[0].value;
    var pocketName = document.getElementsByName('pocketName')[0].value;
    var assignDate = document.getElementsByName('assignDate')[0].value;
   
    if (electionName === '') {
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
                electionName: electionName,
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

function openClosePocket(usrId,exeCd,exeName,pcktCd,pcktName,pcktAssgnCd) {
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
            var ajaxDisplay = document.getElementById('openClosePocket');
            ajaxDisplay.innerHTML = ajaxRequest.responseText;
                $('html, body').animate({
                   scrollTop: $("#openClosePocket").offset().top - 100
               }, 500);
        }
    }


    var queryString = "?usrId="+usrId+"&exeCd="+exeCd+"&exeName="+exeName+"&pcktCd="+pcktCd+"&pcktName="+pcktName+"&pcktAssgnCd="+pcktAssgnCd;
    ajaxRequest.open("POST", "openClosePocket.php" + queryString, true);
    ajaxRequest.send(null);

}

        
        
function setOpenClosePocketStatus(){
    var electionName = document.getElementsByName('electionName')[0].value;
    var usrId = document.getElementsByName('usrId')[0].value;
    var exeCd = document.getElementsByName('exeCd')[0].value;
    var pcktCd = document.getElementsByName('pcktCd')[0].value;
    var pcktAssgnCd = document.getElementsByName('pcktAssgnCd')[0].value;
    var PocketOpenCloseRemark = document.getElementsByName('PocketOpenCloseRemark')[0].value;
    var PocketOpenCloseStatus = document.getElementsByName('PocketOpenCloseStatus')[0].value;
   
    if (electionName === '') {
        alert("Select Corporation!!");
    } else if (usrId === '') {
        alert("Select User!!");
    } else if (exeCd === '') {
        alert("Select Executive !!");
    } else if (PocketOpenCloseRemark === '') {
        alert("Enter Remark !!");
    }
    else if (PocketOpenCloseStatus === '') {
        alert("Select Status !!");
    } else {
        $.ajax({
            type: "POST",
            url: 'action/saveOpenClosePocketStatus.php',
            data: {
                electionName: electionName,
                usrId: usrId,
                exeCd: exeCd,
                pcktCd: pcktCd,
                pcktAssgnCd: pcktAssgnCd,
                PocketOpenCloseRemark:PocketOpenCloseRemark,
                PocketOpenCloseStatus:PocketOpenCloseStatus
            },
            beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('#btnOpenClosePcktStatusId').attr("disabled", true);
            },
            success: function(dataResult) {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.statusCode == 200 ) {
                    $("#idAssignPocketMsgSuccess").html("<h5> "+dataResult.msg+" </h5>")
                        .hide().fadeIn(800, function() {
                            window.location.href = 'home.php';
                        }).delay(3000).fadeOut("fast");
                } else if (dataResult.statusCode == 204 ) {
                    $("#idAssignPocketMsgFailure").html("<h5> "+dataResult.msg+" </h5>")
                        .hide().fadeIn(800, function() {
                            window.location.href = 'home.php';
                        }).delay(3000).fadeOut("fast");
                }
               
                // return data;
            },
            complete: function() {
                    $('#btnOpenClosePcktStatusId').attr("disabled", false);
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
    var electionName = document.getElementsByName('electionName')[0].value;
    var usrId = document.getElementsByName('usrId')[0].value;
    var exeCd = document.getElementsByName('exeCd')[0].value;
    var pcktCd = document.getElementsByName('pcktCd')[0].value;
    var pcktAssgnCd = document.getElementsByName('pcktAssgnCd')[0].value;
    var srPocketRemoveRemark = document.getElementsByName('srPocketRemoveRemark')[0].value;
   
    if (electionName === '') {
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
                electionName: electionName,
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

function ShowDiv(){
    

    var shopNameNo = document.getElementsByName('shopNameNo')[0].value;
    if(shopNameNo == ''){
        alert('Please Enter Shop Name / Shop No');

        
    }
    else{
        document.getElementById("trackingdetails").style.display = "";

        document.getElementById('post_shopDet').innerHTML= "Shop Name / No :    "+shopNameNo;
       
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




// Calling Summary Function Start's

function getCallingSummaryList(){
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
                    var ajaxDisplay = document.getElementById('callingSummaryId');
                    ajaxDisplay.innerHTML = ajaxRequest.responseText;
                    window.location.href='home.php?p=calling-summary';
    
                }
            }
        }
      
        var fromDate = document.getElementsByName('fromDate')[0].value;
        var toDate = document.getElementsByName('toDate')[0].value;
        var NodeName = document.getElementsByName('node_Name')[0].value;
        var node_Cd = document.getElementsByName('node_Cd')[0].value;
    
    
        var queryString = "?fromDate="+fromDate+"&toDate="+toDate+"&NodeName="+NodeName
        +"&node_Cd="+node_Cd;
        console.log(queryString);
        ajaxRequest.open("POST", "setCallingSummaryListInSession.php" + queryString, true);
        ajaxRequest.send(null);
}

// Calling Summary Function End's   getCallingDetailList


// Calling Details Function Start's

function getCallingDetailList(){
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
                    var ajaxDisplay = document.getElementById('callingDetailId');
                    ajaxDisplay.innerHTML = ajaxRequest.responseText;
                    window.location.href='home.php?p=calling-detail';
    
                }
            }
        }
      
        var callingDate = document.getElementsByName('callingDate')[0].value;
        var executive_Name = document.getElementsByName('executive_Name')[0].value;
        
        var queryString = "?callingDate="+callingDate+"&executive_Name="+executive_Name;
        console.log(queryString);
        ajaxRequest.open("POST", "setCallingDetailsInSession.php" + queryString, true);
        ajaxRequest.send(null);
}

// Calling Details Function End's   



function setSurveyDetailPaginationPageNo(pageNo) {
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
                var ajaxDisplay = document.getElementById('surveyDetailListData');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
                $('.zero-configuration').DataTable();
                $('html, body').animate({
                    scrollTop: $("#surveyDetailListData").offset().top
                }, 500);
            }
        }
    var electionName = document.getElementsByName('electionName')[0].value;
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
    var node_Name = document.getElementsByName('node_Name')[0].value;
    var nodeCd = document.getElementsByName('node_Cd')[0].value;
    var pocketCd = document.getElementsByName('pocket_Name')[0].value;
    var executiveCd = document.getElementsByName('executive_Name')[0].value;
    if (electionName === '') {
        alert("Please Select Corporation!");
    } else if (pocketCd === '') {
        alert("Please Select Pocket!");
    } else {
        var queryString = "?pageNo="+pageNo+"&pocketCd=" + pocketCd+"&executiveCd=" + executiveCd+"&electionName="+electionName+"&node_Name=" + node_Name+"&nodeCd=" + nodeCd+"&fromDate="+fromDate+"&toDate="+toDate;
        ajaxRequest.open("POST", "setSurveyDetailPaginationPageNo.php" + queryString, true);
        ajaxRequest.send(null);

    }

}


function getShopSearchSurveyDetail() {
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
                var ajaxDisplay = document.getElementById('surveyDetailListData');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
                $('.zero-configuration').DataTable();
                $('html, body').animate({
                    scrollTop: $("#surveyDetailListData").offset().top - 200
                }, 500);

                // Basic Select2 select
                    $(".select2").select2({
                    // the following code is used to disable x-scrollbar when click in select input and
                    // take 100% width in responsive also
                    dropdownAutoWidth: true,
                    width: '100%'
                  });

                // initMap();
                //  $(document).ready(function(){
                //     $('#searchResult').on('click','initMap')
                // });

                 // window.location.href='home.php?p=pocket-wise-survey-detail';
            }
        }
    var electionName = document.getElementsByName('electionName')[0].value;
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
    var node_Name = document.getElementsByName('node_Name')[0].value;
    var nodeCd = document.getElementsByName('node_Cd')[0].value;
    var pocketCd = document.getElementsByName('pocket_Name')[0].value;
    var executiveCd = document.getElementsByName('executive_Name')[0].value;
    var shopName = document.getElementsByName('shopName')[0].value;
    var shopStatus = document.getElementsByName('shopStatus')[0].value;
    var surveyStatus = document.getElementsByName('surveyStatus')[0].value;
    if (electionName === '') {
        alert("Please Select Corporation!");
    } else if (pocketCd === '') {
        alert("Please Select Pocket!");
    } else {
        var queryString = "?shopName="+shopName+"&shopStatus=" + shopStatus+"&surveyStatus=" + surveyStatus+"&pocketCd=" + pocketCd+"&executiveCd=" + executiveCd+"&electionName="+electionName+"&node_Name=" + node_Name+"&nodeCd=" + nodeCd+"&fromDate="+fromDate+"&toDate="+toDate;
        ajaxRequest.open("POST", "setShopSearchSurveyDetail.php" + queryString, true);
        ajaxRequest.send(null);

    }

}




function setShowApplicationTrackingModal(shopid, srNo){
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
    
   
    var queryString = "?shopid="+shopid+"&srNo="+srNo;
    ajaxRequest.open("POST", "setShowApplicationTrackingByShopModal.php" + queryString, true);
    ajaxRequest.send(null);

}




function saveShopScheduleFormData(shop_id){
    var schedulecallid = document.getElementsByName(shop_id+'_SCHScheduleCall_Id')[0].value;
    var shopid = document.getElementsByName(shop_id+'_SCHShop_Id')[0].value;
    var executiveId = document.getElementsByName(shop_id+'_Executive_Id')[0].value;
    var scheduleDate = document.getElementsByName(shop_id+'_SCHScheduleDate')[0].value;
    var scheduleCategory = document.getElementsByName(shop_id+'_SCHScheduleCategory')[0].value;
    var callReason = document.getElementsByName(shop_id+'_SCHCallReason')[0].value;
    var remark = document.getElementsByName(shop_id+'_SCHRemark')[0].value;

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
                $('#'+shop_id+'_btnShopScheduleId').attr("disabled", true);
            },
            success: function(dataResult) 
            {
                console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    $("#"+shop_id+"_submitmsgsuccessSCH").show();
                    $("#"+shop_id+"_submitmsgsuccessSCH").html(dataResult.message);

                } else if (dataResult.error == true ) {
                    $("#"+shop_id+"_submitmsgfailedSCH").show();
                    $("#"+shop_id+"_submitmsgfailedSCH").html(dataResult.message);

                }
               
                // return data;
            },
            complete: function() {
                    $('#'+shop_id+'_btnShopScheduleId').attr("disabled", false);
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
   }
    
}


function setFirstAndLastEntryData(){
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
                var ajaxDisplay = document.getElementById('showFirstAndLastEntryDetail');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
                $('.zero-configuration').DataTable();
                
                $('html, body').animate({
                    scrollTop: $("#showFirstAndLastEntryDetail").offset().top - 200
                }, 500);
            }
        }
    
    var surveyDate = document.getElementsByName('surveyDate')[0].value;
    var filterType = document.getElementsByName('filterType')[0].value;
   
    var queryString = "?surveyDate="+surveyDate+"&filterType="+filterType;
    ajaxRequest.open("POST", "setFirstAndLastEntryFilterData.php" + queryString, true);
    ajaxRequest.send(null);

}

function setShopExecutiveQCSummaryData(){

    var QCfromDate = document.getElementsByName('QCfromDate')[0].value;
    var QCtoDate = document.getElementsByName('QCtoDate')[0].value;
    var executiveCd = document.getElementsByName('executiveCd')[0].value;

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
                var ajaxDisplay = document.getElementById('showExecutiveQCSummary');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;

                // $('#QCSummaryTableId').append('<caption style="caption-side: bottom">A fictional company\'s staff table.</caption>');

                $('#QCSummaryTableId').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'csv',
                            title: 'Executive QC Summary ( ' +QCfromDate+ '  -   ' +QCtoDate+ ' )'
                        },
                        {
                            extend: 'excel',
                            title: 'Executive QC Summary ( ' +QCfromDate+ '  -   ' +QCtoDate+ ' )'
                        },
                        'pdf', 'print'
                    ]
                } );

            }
        }

    var queryString = "?QCfromDate="+QCfromDate+"&QCtoDate="+QCtoDate+"&executiveCd="+executiveCd;
    ajaxRequest.open("POST", "setShowQCExecutiveSummaryModal.php" + queryString, true);
    ajaxRequest.send(null);

}

//Listing & Survey Filter Page

function setShopListingSurveyFilterDetailPaginationPageNo(pageNo){
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
                var ajaxDisplay = document.getElementById('tblGetShopListWithFilterAppliedId');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
                //$('.zero-configuration').DataTable();

                var frDate = document.getElementsByName('fromDate')[0].value;
                var tDate = document.getElementsByName('toDate')[0].value;

                $('#ListingSurveyTableId').DataTable( {
                    
                    searching: true,
                    //order: [[2, "desc"]],
                    bInfo: false,
                    lengthChange: false,
                    ordering: true,
                    info: false,
                    paging: false,
                    pageLength: 10,
                    scrollY: '300px',
                    scrollCollapse: true
                } );
                
                $('html, body').animate({
                    scrollTop: $("#tblGetShopListWithFilterAppliedId").offset().top - 200
                }, 500);

            }
        }
   
    var electionName = document.getElementsByName('electionName')[0].value;
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
    var node_Name = document.getElementsByName('node_Name')[0].value;
    var nodeCd = document.getElementsByName('node_Cd')[0].value;
    var pocketCd = document.getElementsByName('pocket_Name')[0].value;
    var executiveCd = document.getElementsByName('executive_Name')[0].value;
     if (electionName === '') {
         alert("Please Select Corporation!");
    } else if (pocketCd === '') {
        alert("Please Select Pocket!");
    } else {

        console.log(fromDate);
        var queryString = "?pocketCd=" + pocketCd+"&executiveCd=" + executiveCd+"&electionName="+electionName+"&node_Name=" + node_Name+"&nodeCd=" + nodeCd+"&fromDate="+fromDate+"&toDate="+toDate+"&pageNo="+pageNo;
        ajaxRequest.open("POST", "setShopListingSurveyFilterDetailPaginationPageNo.php" + queryString, true);
        ajaxRequest.send(null);
    }
}

//Assign Ward Officer
function AssignWardOfficer() {

    var userName = document.getElementsByName('userName')[0].value;
    var multipleWards = document.getElementsByName('multipleWards')[0].value;
   
    if(userName===''){
        alert('Select User (Ward Officer)!');
    }else if(multipleWards===''){
        alert('Select Wards to Assign!');
    }else{
        $.ajax({
            type: "POST",
            url: 'action/ActionAssignWardOfficer.php',
            data: {
                userName : userName,
                multipleWards: multipleWards
            
            },
            beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('#submitOfficeCdId').attr("disabled", true);
                //$('#submitmsg').show();
                $('html').addClass("ajaxLoading");
            },
            success: function(dataResult) 
            {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    
                        //console.log(dataResult.userinformation.IsVerified);
                    $("#submitmsgsuccess").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgsuccess").append("");
                            window.location.href = 'home.php?p=assign-ward-officer';
                        }).delay(3000).fadeOut("fast");

                } else if (dataResult.error == true ) {
                    $("#submitmsgfailed").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgfailed").append("");
                        }).delay(3000).fadeOut("fast");

                }
               
                // return data;
            },
            complete: function() {
                    $('#submitOfficeCdId').attr("disabled", false);
                    //$('#submitmsg').hide();
                    $('html').removeClass("ajaxLoading");
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
   }
        
} 

function setSelectMultipleWards() {
    var input = document.getElementsByName("assignWards");
    
    
     
    var selected = 0;
    var total = 0;
    var chkNodeCd = "";
    //var chkNotAssigned = "";
    for (var i = 0; i < input.length; i++) {
      if (input[i].checked) {
          //var splits = input[i].value.split(",");
          var pocketCd = input[i].value;
          //var pocketCd = splits[0];
          //var notAssigned = splits[1];
          chkNodeCd += pocketCd+",";  
           // console.log(chkPocketCd);
          //total += parseFloat(notAssigned);
          //selected ++;
        }
      
    }
    chkNodeCd = chkNodeCd.substring(0, chkNodeCd.length - 1);
    document.getElementsByName("multipleWards")[0].value = "" + chkNodeCd;
    //document.getElementsByName("shopsCount")[0].value = "" + total.toFixed(0);
    //document.getElementsByName("shopsAssignCount")[0].value = "" + total.toFixed(0);
    //document.getElementsByName("pocketsCount")[0].value = "" + selected.toFixed(0);
  }

  //Shop Listing & Survey Filter

  function setShopListingSurveyDetailFilter(Condition,ConditionName){
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
                var ajaxDisplay = document.getElementById('tblGetShopListWithFilterAppliedId');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;
                
                var frDate = document.getElementsByName('fromDate')[0].value;
                var tDate = document.getElementsByName('toDate')[0].value;

                $('#ListingSurveyTableId').DataTable( {
                    
                    searching: true,
                    //order: [[2, "desc"]],
                    bInfo: false,
                    lengthChange: false,
                    ordering: true,
                    info: false,
                    paging: false,
                    pageLength: 10,
                    scrollY: '300px',
                    scrollCollapse: true
                } );
                
                $('html, body').animate({
                    scrollTop: $("#tblGetShopListWithFilterAppliedId").offset().top - 200
                }, 500);

            }
        }

        console.log(Condition);
        console.log(ConditionName);

     if (Condition === '') {
         alert("Please Select Condition!");
    } else if (ConditionName === '') {
        alert("Please Select ConditionName!");
    } else {
        var queryString = "?Condition=" + Condition+"&ConditionName=" + ConditionName;
        ajaxRequest.open("POST", "setShopListingSurveyFilterInSession.php" + queryString, true);
        ajaxRequest.send(null);
    }
}

function getLoaderUntilRefresh(pageName)
{
    console.log(pageName);
    document.getElementById("spinnerImage").style.marginRight="auto";
    document.getElementById("spinnerImage").style.marginLeft="auto";
    document.getElementById("spinnerImage").style.marginTop="220px";
    document.getElementById("spinnerImage").style.display="block";
    document.getElementById("spindiv").style.marginLeft="150px;";
    document.getElementById("spinnerLoader1").style.display="block";
    document.getElementById("spinnerImage").style.display="block";
    document.getElementById("bodyId").style.display="none";
    document.getElementById("spinnerLoader1").slideUp("slow").load(pageName).slideDown("slow");
}


function setShopAssignFilterType(shaFilterType) {
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
    
    if (shaFilterType === '') {
        alert("Please Select Filter Type!");
    } else {
        var queryString = "?shaFilterType="+shaFilterType;
        ajaxRequest.open("POST", "setShopAssignFilterTypeInSession.php" + queryString, true);
        ajaxRequest.send(null);

    }

}


function setProcessScheduleShops(shaFilterType){
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
                // console.log(ajaxRequest.responseText);
                $('#idAssignShopsLoading').hide();
                $('#submitProcessScheduleShopsBtnId').attr("disabled", false);
                location.reload(true);
            }
        }
    
    var calling_Type = document.getElementsByName('calling_Type')[0].value;
    var assign_date = document.getElementsByName('assign_date')[0].value;
        // console.log(assign_date);
    $('#idAssignShopsLoading').show();
    $('#submitProcessScheduleShopsBtnId').attr("disabled", true);
    if (shaFilterType === '') {
        alert("Please Select Filter Type!");
    } else {
        var queryString = "?shaFilterType="+shaFilterType+"&calling_Type="+calling_Type+"&assign_date="+assign_date;
        ajaxRequest.open("POST", "setProcessScheduleShopsData.php" + queryString, true);
        ajaxRequest.send(null);

    }

}