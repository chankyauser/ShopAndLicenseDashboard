    </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <p class="clearfix blue-grey lighten-2 mb-0"><span
                class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; <?php echo date('Y'); ?><a
                    class="text-bold-800 grey darken-2" href="http://ornettech.com" target="_blank">Ornet Technologies
                    Pvt. Ltd.,</a>All rights Reserved</span><span class="float-md-right d-none d-md-block"><i
                    class="feather icon-heart pink"></i> &nbsp;&nbsp;<?php echo $_SESSION['SAL_ElectionName']; ?></span>
            <button class="btn btn-primary btn-icon scroll-top" type="button"><i
                    class="feather icon-arrow-up"></i></button>
        </p>
    </footer>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="app-assets/vendors/js/charts/apexcharts.min.js"></script>
    <script src="app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <script src="app-assets/js/scripts/charts/chart-apex.js"></script>
    <?php
       // if(isset($_GET['p']) && $_GET['p'] == 'home-dashboard' ){ ?>
    <script src="app-assets/vendors/js/charts/apexcharts.min.js"></script>
    <?php //}?>
    <script src="app-assets/vendors/js/extensions/tether.min.js"></script>
    <script src="app-assets/vendors/js/extensions/shepherd.min.js"></script>

    <script src="app-assets/vendors/js/pickers/pickadate/picker.js"></script>
    <script src="app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
    <script src="app-assets/vendors/js/pickers/pickadate/picker.time.js"></script>
    <script src="app-assets/vendors/js/pickers/pickadate/legacy.js"></script>

    <script src="app-assets/vendors/js/forms/select/select2.full.min.js"></script>

    <script src="app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>

    <script src="app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>

    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgjNW0WA93qphgZW-joXVR6VC3IiYFjfo"></script>
    <script src="app-assets/vendors/js/charts/gmaps.min.js"></script> -->
    <?php
        if(isset($_GET['p']) && ($_GET['p'] == 'pocket-wise-survey-detail' ||  $_GET['p'] == 'executive-wise-survey-detail')){ ?>
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgjNW0WA93qphgZW-joXVR6VC3IiYFjfo&callback=initMap&v=weekly" async></script> -->
    <?php 
                if(sizeof($pocketShopsSurveyMapAndListDetail)>0){
            ?>
    <!-- <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC0s06YL85Wn8zd527iZ90NB1goqW4Hxc4&callback=initMap"  ></script> -->
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC0s06YL85Wn8zd527iZ90NB1goqW4Hxc4&callback=initMap">
    </script>
    <?php
                }
            ?>

    <script type="text/javascript">
// Google Maps
function initMap() {

    <?php  
                    $centerLat = 19.01050332388753;
                    $centerLng = 73.02787038981887;
                   // foreach ($pocketShopsSurveyMapAndListDetail as $key => $value){
                   //      if(!empty($value["Latitude"] && $value["Latitude"] != '0')){
                           $centerLat  = $pocketShopsSurveyMapAndListDetail[0]["Latitude"];
                           $centerLng  = $pocketShopsSurveyMapAndListDetail[0]["Longitude"];
                    //     }
                    // }
                 ?>
    const image = "https://nmmccovidcare.com/assets/images/map-icon-pin.png";
    const map = new google.maps.Map(document.getElementById("mapPocketShops"), {
        center: {
            lat: <?php echo $centerLat; ?>,
            lng: <?php echo $centerLng; ?>
        },
        zoom: 16,
    });
    <?php
                    foreach ($pocketShopsSurveyMapAndListDetail as $key => $value){
 // icon: 'app-assets/images/logo/favicon.ico'
                        if($value['Latitude'] != '0'){
                            echo "var marker".$value['Shop_Cd']." = new google.maps.Marker({
                                        position: new google.maps.LatLng(".$value['Latitude'].", ".$value['Longitude']."),
                                       
                                        
                                      });
                             var infowindow".$value['Shop_Cd']." = new google.maps.InfoWindow({
                                        content: '<h5 class=\'text-center\'>Shop Survey Details</h5><br><table class=\'table-bordered\'><tr><td>Shop Name :</td><th>".$value['ShopName']."</th></tr><tr><td>Shop Keeper Name  :</td><th>".$value['ShopKeeperName']."</th></tr><tr><td>Shop Keeper Mobile :</td><th>".$value['ShopKeeperMobile']."</th></tr><tr><td>Shop Created :</td><th>".$value['PLCreatedDate']."</th></tr><tr><td>Nature of Business :</td><th>".$value['Nature_of_Business']."</th></tr></table>',
                                        suppressMapPan:true
                                    });

                                    marker".$value['Shop_Cd'].".setMap(map);
                                    marker".$value['Shop_Cd'].".addListener('click', function(event) {
                                        infowindow".$value['Shop_Cd'].".setPosition(event.latLng); 
                                        infowindow".$value['Shop_Cd'].".setOptions({pixelOffset: new google.maps.Size(0,-30)});
                                        infowindow".$value['Shop_Cd'].".open(map);
                                    });

                              ";
                        }
                    }
                    
                ?>

}
    </script>

    <?php }else if(isset($_GET['p']) && $_GET['p'] == 'pocket-wise-survey-summary' ){ ?>
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgjNW0WA93qphgZW-joXVR6VC3IiYFjfo&callback=initMap&v=weekly" async></script> -->
    <?php 
                if(sizeof($dataPocketMapAndListSummary)>0){
            ?>
    <!-- <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC0s06YL85Wn8zd527iZ90NB1goqW4Hxc4&callback=initMap"  ></script> -->
    <script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC0s06YL85Wn8zd527iZ90NB1goqW4Hxc4&callback=initMap">
    </script>
    <?php
                }
            ?>


    <script>
function initMap() {

    <?php  
                    $centerLat = 19.01050332388753;
                    $centerLng = 73.02787038981887;
                   // foreach ($dataPocketMapAndListSummary as $key => $value){
                        if(!empty($dataPocketMapAndListSummary[0]["Latitude"] && $dataPocketMapAndListSummary[0]["Latitude"] != '0')){
                           $centerLat  = $dataPocketMapAndListSummary[0]["Latitude"];
                           $centerLng  = $dataPocketMapAndListSummary[0]["Longitude"];
                        // }
                    }
                 ?>
    const image = "https://nmmccovidcare.com/assets/images/map-icon-pin.png";
    const map = new google.maps.Map(document.getElementById("mapPockets"), {
        center: {
            lat: <?php echo $centerLat; ?>,
            lng: <?php echo $centerLng; ?>
        },
        zoom: 10,
    });
    <?php
                    foreach ($dataPocketMapAndListSummary as $key => $value){

                         if($value['Latitude'] != '0'){
                            echo "var marker".$value['Pocket_Cd']." = new google.maps.Marker({
                                        position: new google.maps.LatLng(".$value['Latitude'].", ".$value['Longitude']."),
                                       
                                        
                                      });
                             var infowindow".$value['Pocket_Cd']." = new google.maps.InfoWindow({
                                        content: '<h5 class=\'text-center\'>Pockets Details</h5><br><table class=\'table-bordered\'><tr><td>Zone Office :</td><th>".$value['NodeName']."</th><td>Ward No</td><th>".$value['Ward_No']."</th><td>Zone Area</td><th>".$value['NodeArea']."</th></tr><tr><td>Pocket Name  :</td><th>".$value['PocketName']."</th><td>Executive Name  : </td><th>".$value['PLExecutivName']."</th><td> Pocket Created  : </td><th>".$value['PLCreatedDatePM']."</th></tr><tr><td>Shop Count :</td><th>".$value['ShopCount']."</th><td>Survey Completed: </td><th>".$value['ShopDone']."</th><td>Survey Pending : </td><th>".$value['ShopPending']."</th></tr></table>',
                                        suppressMapPan:true
                                    });

                                    marker".$value['Pocket_Cd'].".setMap(map);
                                    marker".$value['Pocket_Cd'].".addListener('click', function(event) {
                                        infowindow".$value['Pocket_Cd'].".setPosition(event.latLng); 
                                        infowindow".$value['Pocket_Cd'].".setOptions({pixelOffset: new google.maps.Size(0,-30)});
                                        infowindow".$value['Pocket_Cd'].".open(map);
                                    });

                              ";
                        }
                    }
                    
                ?>

}
// End Google MAps
    </script>


    <?php }?>


    <!-- Data List View -->
    <script src="app-assets/vendors/js/extensions/dropzone.min.js"></script>
    <!-- <script src="app-assets/vendors/js/tables/datatable/datatables.min.js"></script> -->
    <!-- <script src="app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script> -->
    <!-- <script src="app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script> -->
    <!-- <script src="app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script> -->
    <script src="app-assets/vendors/js/tables/datatable/dataTables.select.min.js"></script>
    <script src="app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js"></script>

    <!-- End Data List View -->

    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="app-assets/js/core/app-menu.js"></script>
    <script src="app-assets/js/core/app.js"></script>
    <script src="app-assets/js/scripts/components.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <!-- <script src="app-assets/js/scripts/pages/dashboard-analytics.js"></script> -->
    <script src="app-assets/js/scripts/forms/select/form-select2.js"></script>
    <script src="app-assets/js/scripts/datatables/datatable.js"></script>

    <script src="app-assets/js/scripts/pages/app-todo.js"></script>

    <!-- <script src="app-assets/js/scripts/charts/gmaps/maps.js"></script> -->

    <!-- BEGIN: Page JS-->

    <!-- END: Page JS-->

    <script src="app-assets/js/scripts/pages/app-user.js"></script>
    <script src="app-assets/js/scripts/navs/navs.js"></script>

    <script src="app-assets/js/scripts/pickers/dateTime/pick-a-datetime.js"></script>

    <script src="app-assets/js/scripts/forms/validation/form-validation.js"></script>

    <!-- Data List View -->
    <!-- <script src="app-assets/js/scripts/ui/data-list-view2.js"></script> -->
    <!-- End Data List View -->


    <!-- END: Page JS-->

    <script>
$('.zero-configuration').DataTable();
    </script>

    <script type="text/javascript">
$(document).ready(function() {
    "use strict"
    var dataListView = $('#data-list-view1').DataTable({
        responsive: true,
        columnDefs: [{
            orderable: true,
            targets: 0,
        }],
        oLanguage: {
            sLengthMenu: "_MENU_",
            sSearch: ""
        },
        // aLengthMenu: [[1, 4, 10, 15, 20], [1, 4, 10, 15, 20]],

        order: [
            [0, "asc"]
        ],
        bInfo: true,
        pageLength: 10
    });
});
    </script>

    <script type="text/javascript">
$(document).ready(function() {

    var optionsShopSurveyStatusAll = {
        series: [{
            name: 'Verified',
            color: '#546E7A',
            data: [0.4, 5, 4.1, 6.7, 2.2, 4.3, 5.0, 2.0, 2.1, 1.0, 1.3, 2.3, 2.7, 3.4]
        }, {
            name: 'Pending',
            color: '#E91E63',
            data: [1.3, 2.3, 2.0, 0.8, 1.3, 2.7, 2.3, 5.0, 4.3, 2.3, 3.4, 3.5, 3.2, 1.2]
        }, {
            name: 'In-Review',
            color: '#00CFE8',
            data: [1.1, 1.7, 1.6, 1.1, 1.3, 1.4, 1.1, 2.1, 2.2, 1.2, 2.1, 1.9, 2.3, 1.9]
        }, {
            name: 'Rejected',
            color: '#EA5455',
            data: [1.1, 1.7, 1.5, 1.5, 2.1, 1.4, 1.1, 1.2, 0.2, 3.2, 2.1, 0.9, 2.3, 1.9]
        }],
        chart: {
            type: 'bar',
            height: 350,
            stacked: true,
            toolbar: {
                show: true
            },
            zoom: {
                enabled: true
            }
        },
        title: {
            text: 'Nature of Business Shop Survey Status Summary',
            align: 'center'
        },
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom',
                    offsetX: -10,
                    offsetY: 0
                }
            }
        }],
        yaxis: [{
            title: {
                text: "Shops in Thousand"
            },
        }],
        plotOptions: {
            bar: {
                horizontal: false,
                borderRadius: 30
            },
        },
        xaxis: {
            // type: 'datetime',
            // categories: ['01/01/2011 GMT', '01/02/2011 GMT', '01/03/2011 GMT', '01/04/2011 GMT',
            //   '01/05/2011 GMT', '01/06/2011 GMT'
            // ],
            type: 'text',
            categories: ['Agricultural', 'Automobile', 'Infrastructure', 'Energy',
                'Health', 'Farma', 'Chemical', 'Banking (BFS)', 'FMCG', 'Retail', 'Telecom',
                'Textile', 'Transport', 'Hospitality'
            ],
        },
        legend: {
            position: 'right',
            offsetY: 60
        },
        fill: {
            opacity: 2
        }
    };

    var chartShopSurveyStatusAll = new ApexCharts(document.querySelector("#chartShopSurveyStatusAll"),
        optionsShopSurveyStatusAll);
    chartShopSurveyStatusAll.render();



    var optionsRevenueWithAreaAll = {
        series: [{
            name: 'Industrial',
            data: [4, 5, 1, 7, 2, 3, 5, 2, 2, 1, 1, 3, 7, 4]
        }, {
            name: 'Commercial',
            data: [1, 2, 2, 8, 1, 2, 2, 5, 3, 2, 4, 5, 3, 2]
        }, {
            name: 'Residential',
            data: [1, 1, 5, 1, 2, 4, 1, 2, 1, 2, 1, 4, 6, 9]
        }],
        chart: {
            type: 'bar',
            height: 350,
            stacked: true,
            toolbar: {
                show: true
            },
            zoom: {
                enabled: true
            }
        },
        title: {
            text: 'Nature of Business Revenue Summary',
            align: 'center'
        },
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom',
                    offsetX: -10,
                    offsetY: 0
                }
            }
        }],
        yaxis: [{
            title: {
                text: "Revenue in Crores"
            },
        }],
        plotOptions: {
            bar: {
                horizontal: false,
                borderRadius: 30
            },
        },
        xaxis: {
            // type: 'datetime',
            // categories: ['01/01/2011 GMT', '01/02/2011 GMT', '01/03/2011 GMT', '01/04/2011 GMT',
            //   '01/05/2011 GMT', '01/06/2011 GMT'
            // ],
            type: 'text',
            categories: ['Agricultural', 'Automobile', 'Infrastructure', 'Energy',
                'Health', 'Farma', 'Chemical', 'Banking (BFS)', 'FMCG', 'Retail', 'Telecom',
                'Textile', 'Transport', 'Hospitality'
            ],
        },
        legend: {
            position: 'right',
            offsetY: 60
        },
        fill: {
            opacity: 2
        }
    };

    var chartRevenueWithAreaAll = new ApexCharts(document.querySelector("#chartRevenueWithAreaAll"),
        optionsRevenueWithAreaAll);
    chartRevenueWithAreaAll.render();

});
    </script>

    <!-- Zoom Hover Effect -->

    <!--   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	 -->
    <script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-36251023-1']);
_gaq.push(['_setDomainName', 'jqueryscript.net']);
_gaq.push(['_trackPageview']);

(function() {
    var ga = document.createElement('script');
    ga.type = 'text/javascript';
    ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') +
    '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(ga, s);
})();
    </script>
    <script>
try {
    fetch(new Request("https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js", {
        method: 'HEAD',
        mode: 'no-cors'
    })).then(function(response) {
        return true;
    }).catch(function(e) {
        var carbonScript = document.createElement("script");
        carbonScript.src = "//cdn.carbonads.com/carbon.js?serve=CK7DKKQU&placement=wwwjqueryscriptnet";
        carbonScript.id = "_carbonads_js";
        document.getElementById("carbon-block").appendChild(carbonScript);
    });
} catch (error) {
    console.log(error);
}
    </script>

    <script>
document.addEventListener('contextmenu', event => event.preventDefault());
document.addEventListener('copy', event => event.preventDefault());
document.addEventListener('paste', event => event.preventDefault());

// // Disable right click
document.addEventListener('contextmenu', function(e) {
    e.preventDefault();
});

// Disable F12 and Ctrl+Shift+I
document.addEventListener('keydown', function(e) {
    if (e.keyCode == 123 || (e.ctrlKey && e.shiftKey && e.keyCode == 73)) {
        e.preventDefault();
    }
});

document.addEventListener('keydown', function(e) {
    // keyCode 44 is for the Print Screen key
    if (e.keyCode == 44) {
        e.preventDefault();
        alert('Print Screen is disabled');
    }
});

document.addEventListener('keydown', function(e) {
    // Disable F12 (Open DevTools)
    if (e.key === "F12") {
        e.preventDefault();
    }

    // Disable Ctrl+Shift+I (Open DevTools in some browsers)
    if (e.ctrlKey && e.shiftKey && e.key === "I") {
        e.preventDefault();
    }

    // Disable Ctrl+Shift+C (Element inspector)
    if (e.ctrlKey && e.shiftKey && e.key === "C") {
        e.preventDefault();
    }

    // Disable Ctrl+U (View Page Source)
    if (e.ctrlKey && e.key === "u") {
        e.preventDefault();
    }
});
    </script>



    </body>
    <!-- END: Body-->

    </html>