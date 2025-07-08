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
            if(pageName=='shop-license'){
                setShopLicenseDetailFilter(1);
            }else if(pageName=='survey-shops'){
                setShopSurveyDetailFilter(1);
            }else if(pageName=='license-defaulters'){
                setShopLicenseDefaultersFilter(1);
            }
        }
    }

    var electionName = document.getElementsByName('electionName')[0].value;
    var pageName = document.getElementsByName('pageName')[0].value;
    
    if (electionName === '') {
        alert("Please Select Corporation!");
    } else {
        $("#node_id").select2().val(['All']).trigger("change");

        var queryString = "?electionName="+electionName+"&nodeName="+nodeName;
        ajaxRequest.open("POST", "setNodeAndWardInData.php" + queryString, true);
        ajaxRequest.send(null);
    }

}

function setNodeAndWardId(nodeId){

    $("#node_id").select2().val([nodeId]).trigger("change");

    var pageName = document.getElementsByName('pageName')[0].value;
    if(pageName=='shop-license'){
        setShopLicenseDetailFilter(1);
    }else if(pageName=='survey-shops'){
        setShopSurveyDetailFilter(1);
    }else if(pageName=='license-defaulters'){
        setShopLicenseDefaultersFilter(1);
    }
}

function setHideApproveAndGenerateLicenseProcess(licenseStatus){

    if(licenseStatus=='Verified'){
         $("#setApproveAndGenerateLicenseId").show();
    }else{
        $("#setApproveAndGenerateLicenseId").hide();
    }
}



function setNodeNameInSession(nodeName){
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
            location.reload(); 
        }
    }

    var electionName = document.getElementsByName('electionName')[0].value;
    
    if (electionName === '') {
        alert("Please Select Corporation!");
    } else {
        var queryString = "?electionName="+electionName+"&nodeName="+nodeName;
        ajaxRequest.open("POST", "setNodeNameInSession.php" + queryString, true);
        ajaxRequest.send(null);
    }

}

function setNodeCdAndWardNoInSession(nodeCd){
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
            location.reload(); 
        }
    }

    var electionName = document.getElementsByName('electionName')[0].value;
    
    if (electionName === '') {
        alert("Please Select Corporation!");
    } else {
        var queryString = "?electionName="+electionName+"&nodeCd="+nodeCd;
        ajaxRequest.open("POST", "setNodeCdAndWardNoInSession.php" + queryString, true);
        ajaxRequest.send(null);
    }

}


function setDisplayParwanaAmount(parwanaDetId){
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
            var ajaxDisplay = document.getElementById('parwanaAmountId');
            ajaxDisplay.innerHTML = ajaxRequest.responseText;
        }
    }

    var electionName = document.getElementsByName('electionName')[0].value;
    
    if (electionName === '') {
        alert("Please Select Corporation!");
    } else {
        var queryString = "?electionName="+electionName+"&parwanaDetId="+parwanaDetId;
        ajaxRequest.open("POST", "setDisplayParwanaAmountData.php" + queryString, true);
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

function loginAuthentication() {
    var appName = document.getElementsByName('appName')[0].value;
    var developmentMode = document.getElementsByName('developmentMode')[0].value;
    var loginType = document.getElementsByName('loginType')[0].value;
    var loginMode = document.getElementsByName('loginMode')[0].value;
    var mobileNumber = document.getElementsByName('mobile')[0].value;
    var password = document.getElementsByName('password')[0].value;
    var latitude = document.getElementsByName('latitude')[0].value;
    var longitude = document.getElementsByName('longitude')[0].value;
    var mobileModel = document.getElementsByName('mobileModel')[0].value;
    var mobileVersion = document.getElementsByName('mobileVersion')[0].value;
    var deviceId = document.getElementsByName('deviceId')[0].value;
    var appVersion = document.getElementsByName('appVersion')[0].value;
    var firebaseId = document.getElementsByName('firebaseId')[0].value;
    var IPAddress = document.getElementsByName('IPAddress')[0].value;
    var appSignatureKey = document.getElementsByName('appSignatureKey')[0].value;
   
    if(mobileNumber === '' && mobileNumber.length < 10){
        alert('Enter Mobile Number properly!');
    }else if(password === ''){
        // alert(loginType);
        alert('Enter Password!');
    }else{
        $.ajax({
            type: "POST",
            url: 'action/login.php',
            data: {
                appName: appName,
                developmentMode: developmentMode,
                loginType: loginType,
                loginMode: loginMode,
                mobileNumber: mobileNumber,
                password: password,
                latitude: latitude,
                longitude: longitude,
                mobileModel: mobileModel,
                mobileVersion: mobileVersion,
                deviceId: deviceId,
                appVersion: appVersion,
                firebaseId: firebaseId,
                IPAddress: IPAddress,
                appSignatureKey: appSignatureKey
            },
            beforeSend: function() { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('#submitLoginBtnId').attr("disabled", true);
                $('#submitmsg').show();
                $('html').addClass("ajaxLoading");
            },
            success: function(dataResult) {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    
                        // console.log(dataResult.userinformation.IsVerified);
                    $("#submitmsgsuccess").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgsuccess").append("");
                            window.location.href = 'signin.php?mobile='+dataResult.userinformation.Mobile_No+'&userName='+dataResult.userinformation.UserName+'&appName='+dataResult.userinformation.AppName+'&userCd='+dataResult.userinformation.User_Cd+'&fullName='+dataResult.userinformation.ExecutiveName+'&user_type='+dataResult.userinformation.User_Type+'&electionName='+dataResult.userinformation.DefaultElectionName+'&developmentMode='+developmentMode;
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
                    $('#submitmsg').hide();
                    $('html').removeClass("ajaxLoading");
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
    }
        
    
}

function searchShopHeaderView(pageNo, viewType){
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
                searchShopHeaderFilter(pageNo);
            }
        }
    }

    var queryString = "?viewType="+viewType;
    ajaxRequest.open("POST", "setSearchShopHeaderView.php" + queryString, true);
    ajaxRequest.send(null);

}

function searchShopHeaderFilter(pageNo){
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
    var shopName = document.getElementsByName('shopName')[0].value;

    if(shopName === ''){
        alert('Enter Shop Name or Shop UID');
    }else{
        var queryString = "?electionName="+electionName+"&pageNo="+pageNo+"&nodeCd="+nodeCd+"&businessCatCd="+businessCatCd+"&shopName="+shopName;
        ajaxRequest.open("POST", "setSearchShopHeaderFilter.php" + queryString, true);
        ajaxRequest.send(null);
    }
    
}

function setShopBusinessCategoriesWardFilter(pageNo){
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
    var shopName = document.getElementsByName('shopName')[0].value;
  
    var queryString = "?electionName="+electionName+"&pageNo="+pageNo+"&nodeCd="+nodeCd+"&businessCatCd="+businessCatCd+"&shopName="+shopName;
    ajaxRequest.open("POST", "setShopBusinessCategoriesFilter.php" + queryString, true);
    ajaxRequest.send(null);

}

function setShopBusinessCategoriesView(pageNo, viewType, businessCatCd){
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
                setShopBusinessCategoriesFilter(pageNo, businessCatCd);
            }
        }
    }

    var queryString = "?viewType="+viewType;
    ajaxRequest.open("POST", "setShopBusinessCategoriesView.php" + queryString, true);
    ajaxRequest.send(null);

}

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

                // $("#business_cat_id.select-active.select2-hidden-accessible option").each(function() { this.selected = (this.value == businessCatCd) });

               
            }   
        }
    }

     $("#business_cat_id").select2().val([businessCatCd]).trigger("change");
    var electionName = document.getElementsByName('electionName')[0].value;
    var nodeCd = document.getElementsByName('nodeCd')[0].value;
    var shopName = document.getElementsByName('shopName')[0].value;
    if(businessCatCd === ''){
        alert('Select Shop Category');
    }else{
        var queryString = "?electionName="+electionName+"&pageNo="+pageNo+"&nodeCd="+nodeCd+"&businessCatCd="+businessCatCd+"&shopName="+shopName;
        ajaxRequest.open("POST", "setShopBusinessCategoriesFilter.php" + queryString, true);
        ajaxRequest.send(null);
    }
    
}

function setShopParwanaDetail(pageNo, businessCatCd, parwanaCd){
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
                setShopBusinessCategoriesFilter(pageNo, businessCatCd);
            }
        }
    }

    var queryString = "?parwanaCd="+parwanaCd;
    ajaxRequest.open("POST", "setShopParwanaDetail.php" + queryString, true);
    ajaxRequest.send(null);
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



function setShowImageUrlModal(imageFileUrl,docType){
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
                var ajaxDisplay = document.getElementById('showImageUrl');
                ajaxDisplay.innerHTML = ajaxRequest.responseText;

                if ($(".categories-button-active").hasClass("open")) {
                    $(".categories-button-active").removeClass("open");
                    $(".categories-dropdown-active-large").removeClass("open");
                }
                $("#showModalImageUrl").modal("show");
            }   
        }
    }
      
    var electionName = document.getElementsByName('electionName')[0].value;

    if(imageFileUrl === ''){
        alert('Select Image File');
    }else{
        var queryString = "?electionName="+electionName+"&imageFileUrl="+imageFileUrl+"&docType="+docType;
        ajaxRequest.open("POST", "setShowImageUrlModal.php" + queryString, true);
        ajaxRequest.send(null);
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
                $("#modalCloseId").show();
                $("#modalHeaderId").hide();
                $("#modalFooterId").hide();
            }   
        }
    }
      
    var electionName = document.getElementsByName('electionName')[0].value;

    if(shopId === ''){
        alert('Select Shop');
    }else{
        var queryString = "?electionName="+electionName+"&shopId="+shopId;
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

function setApproveShopLicenseList(pageNo, viewType){
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

    var electionName = document.getElementsByName('electionName')[0].value;
    var nodeName = document.getElementsByName('nodeName')[0].value;
    var nodeCd = document.getElementsByName('nodeCd')[0].value;
    var documentStatus = document.getElementsByName('documentStatus')[0].value;
    var licenseStatus = document.getElementsByName('licenseStatus')[0].value;
  
    var queryString = "?electionName="+electionName+"&pageNo="+pageNo+"&nodeName="+nodeName+"&nodeCd="+nodeCd+"&documentStatus="+documentStatus+"&licenseStatus="+licenseStatus+"&viewType="+viewType;;
    ajaxRequest.open("POST", "setApproveAndGenerateShopLicense.php" + queryString, true);
    ajaxRequest.send(null);

}

function setShopDimension(){
    var ShopDimensionLength = document.getElementsByName('shopDimensionLength')[0].value;
    var ShopDimensionWidth = document.getElementsByName('shopDimensionWidth')[0].value;
    if( ShopDimensionLength != '' &&  ShopDimensionWidth != '' ){
        var ShopDimension = parseFloat (parseFloat(ShopDimensionLength) * parseFloat(ShopDimensionWidth) );
        document.getElementsByName('shopDimension')[0].value = parseFloat(ShopDimension);
    }else{
        alert('Please enter Shop Dimension length and width both for Shop Area Calculation!');
    }
    
}

function setVerifyAndApproveShopDetail(){
    var electionName = document.getElementsByName('electionName')[0].value;
    var pageName = document.getElementsByName('pageName')[0].value;
    var pageNo = document.getElementsByName('pageNo')[0].value;
    var viewType = document.getElementsByName('viewType')[0].value;
    var wardOfficerUserId = document.getElementsByName('wardOfficerUserId')[0].value;
    var shopId = document.getElementsByName('shopId')[0].value;
    var shopName = document.getElementsByName('shopName')[0].value;
    var shopNameMar = document.getElementsByName('shopNameMar')[0].value;
    var businessCateogry = document.getElementsByName('businessCateogry')[0].value;
    var shopAreaName = document.getElementsByName('shopAreaName')[0].value;
    var shopCateogry = document.getElementsByName('shopCateogry')[0].value;
    var shopKeeperName = document.getElementsByName('shopKeeperName')[0].value;
    var shopKeeperMobile = document.getElementsByName('shopKeeperMobile')[0].value;
    var parwanaDetail = document.getElementsByName('parwanaDetail')[0].value;
    var ConsumerNo = document.getElementsByName('ConsumerNo')[0].value;
    var GSTNo = document.getElementsByName('GSTNo')[0].value;
    var ShopContactNo1 = document.getElementsByName('ShopContactNo1')[0].value;
    var ShopContactNo2 = document.getElementsByName('ShopContactNo2')[0].value;
    var Address1 = document.getElementsByName('Address1')[0].value;
    var Address2 = document.getElementsByName('Address2')[0].value;
    var ShopOwnStatus = document.getElementsByName('ShopOwnStatus')[0].value;
    var PeriodInYrs = document.getElementsByName('PeriodInYrs')[0].value;
    var PeriodInMonths = document.getElementsByName('PeriodInMonths')[0].value;
    var shopDimensionLength = document.getElementsByName('shopDimensionLength')[0].value;
    var shopDimensionWidth = document.getElementsByName('shopDimensionWidth')[0].value;
    var shopDimension = document.getElementsByName('shopDimension')[0].value;
    var ownerName = document.getElementsByName('ownerName')[0].value;
    var ownerMobile = document.getElementsByName('ownerMobile')[0].value;
    var OwnerContactNo3 = document.getElementsByName('OwnerContactNo3')[0].value;
    var ownerEmail = document.getElementsByName('ownerEmail')[0].value;
    var ownerAddress = document.getElementsByName('ownerAddress')[0].value;
    var maleEmp = document.getElementsByName('maleEmp')[0].value;
    var femaleEmp = document.getElementsByName('femaleEmp')[0].value;
    var otherEmp = document.getElementsByName('otherEmp')[0].value;
    var shopApprovalRemark = document.getElementsByName('shopApprovalRemark')[0].value;
    var qcType = document.getElementsByName('qcType')[0].value;
    var qcFlag = document.getElementsByName('qcFlag')[0].value;
   
    if(shopName === ''){
        alert('Enter Shop Name in English!');
    }else if(shopNameMar === ''){
        alert('Enter Shop Name in Marathi!');
    }else if(businessCateogry === ''){
        alert('Please Select Business Category!');
    }else if(shopAreaName === ''){
        alert('Please Select Shop Area Category!');
    }else if(shopCateogry === ''){
        alert('Please Select Shop Category!');
    }else if(shopKeeperName === ''){
        alert('Enter Shop Keeper Full Name!');
    }else if(shopKeeperMobile === '' && shopKeeperMobile.length < 10){
        alert('Enter Shop Keeper Mobile Number properly!');
    }else if(parwanaDetail === ''){
        alert('Please Select Shop Parwana Detail!');
    }else if(Address1 === ''){
        alert('Enter Shop Address 1!');
    }else if(parwanaDetail === ''){
        alert('Please Select Parwana Detail!');
    }else if(shopDimension != '' && (shopDimensionLength === '' && shopDimensionWidth != '' ) || (shopDimensionLength != '' && shopDimensionWidth === '' ) ) {
        alert('Please enter the Shop Dimension properly!');
    }else{
        $.ajax({
            type: "POST",
            url: 'action/saveVerifyAndApproveShopDetail.php',
            data: {
                electionName: electionName,
                pageName: pageName,
                pageNo: pageNo,
                viewType: viewType,
                wardOfficerUserId: wardOfficerUserId,
                shopId: shopId,
                shopName: shopName,
                shopNameMar: shopNameMar,
                businessCateogry: businessCateogry,
                shopAreaName: shopAreaName,
                shopCateogry: shopCateogry,
                shopKeeperName: shopKeeperName,
                shopKeeperMobile: shopKeeperMobile,
                parwanaDetail: parwanaDetail,
                ConsumerNo: ConsumerNo,
                GSTNo: GSTNo,
                ShopContactNo1: ShopContactNo1,
                ShopContactNo2: ShopContactNo2,
                Address1: Address1,
                Address2: Address2,
                ShopOwnStatus: ShopOwnStatus,
                PeriodInYrs: PeriodInYrs,
                PeriodInMonths: PeriodInMonths,
                shopDimension: shopDimension,
                ownerName: ownerName,
                ownerMobile: ownerMobile,
                OwnerContactNo3: OwnerContactNo3,
                ownerEmail: ownerEmail,
                ownerAddress: ownerAddress,
                maleEmp: maleEmp,
                femaleEmp: femaleEmp,
                otherEmp: otherEmp,
                shopApprovalRemark: shopApprovalRemark,
                qcType: qcType,
                qcFlag: qcFlag
            },
            beforeSend: function() { 
                $('#verifyShopDetailId').attr("disabled", true);
                $('#submitloading').show();
            },
            success: function(dataResult) {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    $("#submitmsgsuccessSHApprovalReject").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgsuccessSHApprovalReject").append("");

                            $("#quickViewShopDetailModal").modal("hide");

                            if(pageName=='survey-shops'){
                                setShopSurveyDetailView(pageNo,viewType);
                            }else if(pageName=='shop-license'){
                                setShopLicenseDetailView(pageNo,viewType);
                            }else{
                                searchShopHeaderFilter(pageNo);
                            }

                        }).delay(3000).fadeOut("fast");
                } else if (dataResult.error == true ) {
                    $("#submitmsgfailedSHApprovalReject").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgfailedSHApprovalReject").append("");
                        }).delay(3000).fadeOut("fast");
                }
                // return data;
            },
            complete: function() {
                    $('#verifyShopDetailId').attr("disabled", false);
                    $('#submitloading').hide();
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
    }
}

function setRejectShopDetail(){
    var electionName = document.getElementsByName('electionName')[0].value;
    var pageName = document.getElementsByName('pageName')[0].value;
    var pageNo = document.getElementsByName('pageNo')[0].value;
    var viewType = document.getElementsByName('viewType')[0].value;
    var wardOfficerUserId = document.getElementsByName('wardOfficerUserId')[0].value;
    var shopId = document.getElementsByName('shopId')[0].value;

    var shopApprovalRemark = document.getElementsByName('shopApprovalRemark')[0].value;
    var qcType = document.getElementsByName('qcType')[0].value;
    var qcFlag = document.getElementsByName('qcFlag')[0].value;

    if(shopApprovalRemark === ''){
        alert('Enter License Rejection Remark!');
    }else{
        var result = confirm("Are you sure you Want to Reject Shop License Verification?");
        if (result) {
            $.ajax({
                type: "POST",
                url: 'action/saveRejectShopDetail.php',
                data: {
                    electionName: electionName,
                    pageName: pageName,
                    pageNo: pageNo,
                    viewType: viewType,
                    wardOfficerUserId: wardOfficerUserId,
                    shopId: shopId,
                    shopApprovalRemark: shopApprovalRemark,
                    qcType: qcType,
                    qcFlag: qcFlag
                },
                beforeSend: function() { 
                    $('#verifyShopDetailId').attr("disabled", true);
                    $('#submitloading').show();
                },
                success: function(dataResult) {
                    // console.log(dataResult);
                    var dataResult = JSON.parse(dataResult);
                    if (dataResult.error == false  ) {
                        $("#submitmsgsuccessSHApprovalReject").html(dataResult.message)
                            .hide().fadeIn(800, function() {
                                $("submitmsgsuccessSHApprovalReject").append("");

                                $("#quickViewShopDetailModal").modal("hide");

                                if(pageName=='survey-shops'){
                                    setShopSurveyDetailView(pageNo,viewType);
                                }else if(pageName=='shop-license'){
                                    setShopLicenseDetailView(pageNo,viewType);
                                }

                            }).delay(3000).fadeOut("fast");
                    } else if (dataResult.error == true ) {
                        $("#submitmsgfailedSHApprovalReject").html(dataResult.message)
                            .hide().fadeIn(800, function() {
                                $("submitmsgfailedSHApprovalReject").append("");
                            }).delay(3000).fadeOut("fast");
                    }
                    // return data;
                },
                complete: function() {
                        $('#verifyShopDetailId').attr("disabled", false);
                        $('#submitloading').hide();
                    }
                    // error: function () {
                    //    alert('Error occured');
                    // }
            });
        }   
    } 
}


function setPayShopLicenseFeeDetail(){
    var electionName = document.getElementsByName('electionName')[0].value;
    var pageName = document.getElementsByName('pageName')[0].value;
    var pageNo = document.getElementsByName('pageNo')[0].value;
    var viewType = document.getElementsByName('viewType')[0].value;
    var wardOfficerUserId = document.getElementsByName('wardOfficerUserId')[0].value;
    var shopId = document.getElementsByName('shopId')[0].value;
    var billingId = document.getElementsByName('billingId')[0].value;
    var licenseType = document.getElementsByName('licenseType')[0].value;
    var locationMode = document.querySelector('input[name="locationMode"]:checked').value;
    var paymentMode = document.querySelector('input[name="paymentMode"]:checked').value;
    var paymentAmount = document.getElementsByName('paymentAmount')[0].value;

    var paymentRemark = document.getElementsByName('paymentRemark')[0].value;
    var qcType = document.getElementsByName('qcType')[0].value;
    var qcFlag = document.getElementsByName('qcFlag')[0].value;
    
        $.ajax({
            type: "POST",
            url: 'action/savePayShopLicenseFeeDetail.php',
            data: {
                electionName: electionName,
                pageName: pageName,
                pageNo: pageNo,
                viewType: viewType,
                wardOfficerUserId: wardOfficerUserId,
                shopId: shopId,
                billingId: billingId,
                licenseType: licenseType,
                locationMode: locationMode,
                paymentMode: paymentMode,
                paymentAmount: paymentAmount,
                paymentRemark: paymentRemark,
                qcType: qcType,
                qcFlag: qcFlag
            },
            beforeSend: function() { 
                // $('#payShopLicenseFeeBtnId').attr("disabled", true);
                $('#submitloading').show();
            },
            success: function(dataResult) {
                // console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if (dataResult.error == false  ) {
                    $("#submitmsgsuccessSHBillPay").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgsuccessSHBillPay").append("");

                            $("#payShopLicenseFeeModal").modal("hide");

                            if(pageName=='survey-shops'){
                                setShopSurveyDetailView(pageNo,viewType);
                            }else if(pageName=='shop-license'){
                                setShopLicenseDetailView(pageNo,viewType);
                            }

                        }).delay(3000).fadeOut("fast");
                } else if (dataResult.error == true ) {
                    $("#submitmsgfailedSHBillPay").html(dataResult.message)
                        .hide().fadeIn(800, function() {
                            $("submitmsgfailedSHBillPay").append("");
                        }).delay(3000).fadeOut("fast");
                }
                return data;
            },
            complete: function() {
                    // $('#payShopLicenseFeeBtnId').attr("disabled", false);
                    $('#submitloading').hide();
                }
                // error: function () {
                //    alert('Error occured');
                // }
        });
    
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

function validateOwnerEmail(emailField){
        // var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        // if (reg.test(emailField.value) == false) 
        // {
        //     alert('Invalid Email Address');
        //     return false;
        // }

        // return true;

        var email = document.getElementById('ownerEmail');
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if (!filter.test(email.value)) {
            alert('Please provide a valid email address');
            email.focus;
            return false;
        }

}

function validateOwnerMobile(mobileField){
        var ownerMobile = document.getElementById('ownerMobile');
        var ownerMobileVal = ownerMobile.value;
        var filter = /^[6-9][0-9]{0,10}$/;

        if (!filter.test(ownerMobile.value)) {
            alert('Please provide a valid Mobile Number');
            ownerMobile.focus;
            return false;
        }else{
            if(ownerMobileVal.length < 10){
                alert('Please provide a valid 10 digit Mobile Number');
                ownerMobile.focus;
                return false;
            }
        }

}

function getLoaderUntilRefresh(pageName)
{
    // console.log(pageName);
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