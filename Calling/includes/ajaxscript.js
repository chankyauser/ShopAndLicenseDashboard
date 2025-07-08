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
            }
        }
        // var splits = partyCd.split(",");
        // var partyCd = splits[0];
        // var party = splits[1];

    // var electionName = document.getElementsByName('electionName')[0].value;
    var nodeCd = document.getElementsByName('node_Cd')[0].value;
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
    var nodeCd = document.getElementsByName('node_Cd')[0].value;
    if (nodeCd === '') {
        alert("Please Select Ward!");
    } else {
        // var queryString = "?nodeCd=" + nodeCd+"&electionName="+electionName;
        var queryString = "?nodeCd=" + nodeCd+"&fromDate="+fromDate+"&toDate="+toDate;
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
            }
        }
  
    // var electionName = document.getElementsByName('electionName')[0].value;
    var fromDate = document.getElementsByName('fromDate')[0].value;
    var toDate = document.getElementsByName('toDate')[0].value;
    var nodeCd = document.getElementsByName('node_Cd')[0].value;
    if (nodeCd === '') {
        alert("Please Select Ward!");
    } else {
        // var queryString = "?nodeCd=" + nodeCd+"&electionName="+electionName;
        var queryString = "?nodeCd=" + nodeCd+"&fromDate="+fromDate+"&toDate="+toDate;
        ajaxRequest.open("POST", "setExecutiveNameByNodeCdWithDateRange.php" + queryString, true);
        ajaxRequest.send(null);
    }

}




function submitCallAssignFormData() {
    var node_Cd = document.getElementsByName('node_Cd')[0].value;
    var calling_Category_Cd = document.getElementsByName('calling_Category')[0].value;
    var calling_asign_date = document.getElementsByName('calling_asign_date')[0].value;
    var ccExecutive_Cd = document.getElementsByName('ccExecutive_Cd')[0].value;
    var ccTempExecutive_Cd = document.getElementsByName('ccTempExecutive_Cd')[0].value;
    var shopsAssignCount = document.getElementsByName('shopsAssignCount')[0].value;
    var multiplePockets = document.getElementsByName('multiplePockets')[0].value;
    var actionType = document.getElementsByName('actionType')[0].value;
    
    if(node_Cd === ''){
        alert('Select Ward');
    }else if(calling_Category_Cd === ''){
        alert('Select Category');
    }else if(calling_asign_date === ''){
        alert('Enter Calling Assign Date');
    }else if(ccExecutive_Cd === ''){
        alert('Select ExecutiveName');
    }else if(shopsAssignCount === ''){
        alert('Enter Shop Assign Count');
    }else if(multiplePockets === ''){
        alert('Select atleast One Pocket');
    }else{

        $.ajax({
            type: "POST",
            url: 'action/saveCallAssignFormData.php',
            data: {
                node_Cd: node_Cd,
                calling_Category_Cd: calling_Category_Cd,
                calling_asign_date: calling_asign_date,
                ccExecutive_Cd: ccExecutive_Cd,
                ccTempExecutive_Cd: ccTempExecutive_Cd,
                shopsAssignCount: shopsAssignCount,
                multiplePockets: multiplePockets,
                actionType: actionType
            },
            beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('#submitCallAssignBtnId').attr("disabled", true);
                $('html').addClass("ajaxLoading");
                $("#submitmsgsuccess").html("Please wait..").show();
            },
            success: function(dataResult) {
                var dataResult = JSON.parse(dataResult);
                if (dataResult.statusCode == 200 || dataResult.statusCode == 204 || dataResult.statusCode == 206 ) {
                   
                    $("#submitmsgsuccess").html(dataResult.msg)
                        .hide().fadeIn(800, function() {
                            $("submitmsgsuccess").append("");
                            window.location.href = 'home.php?p=call-assign';
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
                    $('#submitCallAssignBtnId').attr("disabled", false);
                    $('html').removeClass("ajaxLoading");
                    $("#submitmsgsuccess").html("").hide();
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
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

function BusinessCategoryMaster() {

    var businessCat_Cd = document.getElementsByName('BusinessCat_Cd')[0].value;
    var businessCategoryName = document.getElementsByName('businessCategoryName')[0].value;
    var businessCategoryNameMar = document.getElementsByName('businessCategoryNameMar')[0].value;
    var taxPercentage = document.getElementsByName('taxPercentage')[0].value;
    var remark = document.getElementsByName('remark')[0].value;
    var IsActive = document.getElementsByName('IsActive')[0].value;
   
 
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

function DropDownMaster() {

    var DropDown_Cd = document.getElementsByName('DropDown_Cd')[0].value;
    var DTitle = document.getElementsByName('DTitle')[0].value;
    var DValue = document.getElementsByName('DValue')[0].value;
    var SerialNo = document.getElementsByName('SerialNo')[0].value;
    var remark = document.getElementsByName('remark')[0].value;
    var IsActive = document.getElementsByName('IsActive')[0].value;
   
 
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

function ShopAreaMaster() {

    var ShopArea_Cd = document.getElementsByName('ShopArea_Cd')[0].value;
    var shopAreaName = document.getElementsByName('shopAreaName')[0].value;
    var shopAreaNameMar = document.getElementsByName('shopAreaNameMar')[0].value;
    var taxPercentage = document.getElementsByName('taxPercentage')[0].value;
    var remark = document.getElementsByName('remark')[0].value;
    var IsActive = document.getElementsByName('IsActive')[0].value;
   
 
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

function CallingCategoryMaster() {

    var calling_Category_Cd = document.getElementsByName('Calling_Category_Cd')[0].value;
    var callingCategory = document.getElementsByName('callingCategory')[0].value;
    var srNo = document.getElementsByName('srNo')[0].value;
    var remark = document.getElementsByName('remark')[0].value;
    var IsActive = document.getElementsByName('IsActive')[0].value;
   
 
        $.ajax({
            type: "POST",
            url: 'action/ActionCallingCategoryMaster.php',
            data: {

                calling_Category_Cd : calling_Category_Cd,
                callingCategory: callingCategory,
                srNo: srNo,
                remark: remark,
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

function ShopDocumentMaster() {

    var Document_Cd = document.getElementsByName('Document_Cd')[0].value;
    var documentName = document.getElementsByName('documentName')[0].value;
    var documentNameMar = document.getElementsByName('documentNameMar')[0].value;
    var documentType = document.getElementsByName('documentType')[0].value;
    var isCompulsory = document.getElementsByName('isCompulsory')[0].value;
    var IsActive = document.getElementsByName('IsActive')[0].value;
   
 
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

function BoardTaxMaster() {

    var BTM_Cd = document.getElementsByName('BTM_Cd')[0].value;
    var BtmType = document.getElementsByName('Btm_Type')[0].value;
    var boardHeight = document.getElementsByName('boardHeight')[0].value;
    var boardWidth = document.getElementsByName('boardWidth')[0].value;
    var boardAreaWiseTax = document.getElementsByName('boardAreaWiseTax')[0].value;
    var IsActive = document.getElementsByName('IsActive')[0].value;
   
 
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

function FAQMaster() {

    var FAQ_Cd = document.getElementsByName('FAQ_Cd')[0].value;
    var question = document.getElementsByName('question')[0].value;
    var answer = document.getElementsByName('answer')[0].value;
    var usertype = document.getElementsByName('usertype')[0].value;
    var remark = document.getElementsByName('remark')[0].value;
    var IsActive = document.getElementsByName('IsActive')[0].value;
   
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

function saveShopCallingRemarkForm(shopid,scheduleid){
    var executiveId = document.getElementsByName('Executive_Id')[0].value;
    var stStageName = document.getElementsByName('stStageName'+scheduleid)[0].value;
    var remark1 = document.getElementsByName('remark_1_'+scheduleid)[0].value;
    var remark2 = document.getElementsByName('remark_2_'+scheduleid)[0].value;
    var remark3 = document.getElementsByName('remark_3_'+scheduleid)[0].value;
   if(stStageName=== ''){
        alert('Select Application Status');
   }else if(remark1 === ''){
        alert('Enter at least Remark 1');
   }else{
        $.ajax({
            type: "POST",
            url: 'action/saveShopCallingRemarkData.php',
            data: {
                shopid: shopid,
                scheduleid: scheduleid,
                executiveId: executiveId,
                stStageName: stStageName,
                remark1: remark1,
                remark2: remark2,
                remark3: remark3
            },
            beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('#btnshcallingRemId'+scheduleid).attr("disabled", true);
                //$('#submitmsg').show();
                $('html').addClass("ajaxLoading");
            },
            success: function(dataResult) 
            {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                        //console.log(dataResult.userinformation.IsVerified);
                    $("#submitmsgsuccessCR"+scheduleid).html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgsuccessCR"+scheduleid).append("");
                        }).delay(3000).fadeOut("fast");

                } else if (dataResult.error == true ) {
                    $("#submitmsgfailedCR"+scheduleid).html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgfailedCR"+scheduleid).append("");
                        }).delay(3000).fadeOut("fast");

                }
               
                // return data;
            },
            complete: function() {
                    $('#btnshcallingRemId'+scheduleid).attr("disabled", false);
                    $('html').removeClass("ajaxLoading");
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
   }
    
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
                window.location.href='home.php?p=pocket-wise-survey-detail';

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

function setCallAssignedListFilterData() {
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
   
    var callingDateFilter = document.getElementsByName('callingDateFilter')[0].value;
    var callingStatusFilter = document.getElementsByName('callingStatusFilter')[0].value;
    var callingResponseFilter = document.getElementsByName('CallResponse')[0].value;
     if (callingResponseFilter === '') {
        alert("Please Select Calling Response!");
    } else {
        var queryString = "?callingResponseFilter=" + callingResponseFilter+"&callingStatusFilter="+callingStatusFilter+"&callingDateFilter="+callingDateFilter;
        ajaxRequest.open("POST", "setCallAssignedListFilterData.php" + queryString, true);
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