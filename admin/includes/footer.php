    
              </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <p class="clearfix blue-grey lighten-2 mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; <?php echo date('Y'); ?><a class="text-bold-800 grey darken-2" href="http://ornettech.com" target="_blank">Ornet Technologies Pvt. Ltd.,</a>All rights Reserved</span><span class="float-md-right d-none d-md-block"><i class="feather icon-heart pink"></i> &nbsp;&nbsp;<?php echo $_SESSION['SAL_ElectionName']; ?></span>
            <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="feather icon-arrow-up"></i></button>
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

    <script src="app-assets/js/scripts/modal/components-modal.js"></script>

    <script src="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css"></script>

    <!-- Data List View -->
    <!-- <script src="app-assets/js/scripts/ui/data-list-view2.js"></script> -->
    <!-- End Data List View -->


    <!-- END: Page JS-->

    <script>
       $('.zero-configuration').DataTable();
    </script>

<script type="text/javascript">
$(document).ready(function () {
  document.getElementById("spinnerImage").style.marginRight="0px;";
  document.getElementById("spinnerImage").style.marginLeft="0px;";
  document.getElementById("spinnerImage").style.marginTop="0px;";
  document.getElementById("spinnerImage").style.display="none;";
  document.getElementById("spinnerLoader1").style.display="block";
  document.getElementById("spinnerImage").style.display="none";
  document.getElementById("bodyId").style.display="block";
 });
 </script>

<script type="text/javascript">
    $(document).ready(function () {
      
      var frDate = document.getElementsByName('fromDate')[0].value;
      var tDate = document.getElementsByName('toDate')[0].value;

      $('#executiveDataCountId').DataTable( {
                    dom: 'Bfrtip',
                      buttons: [
                      {
                          extend: 'csv',
                          title: 'Executive Wise Count ( '+frDate+'  -   '+tDate+' )'
                      }, 
                      'excel'
                      ],
                    searching: true,
                    order: [[2, "desc"]],
                    bInfo: false,
                    lengthChange: false,
                    ordering: true,
                    info: false,
                    paging: false,
                    pageLength: 10,
                    scrollY: '300px',
                    scrollCollapse: true
                } );

                $('#wardDataCountId').DataTable( {
                    dom: 'Bfrtip',
                      buttons: [
                      {
                          extend: 'csv',
                          title: 'Ward Wise Count ( '+frDate+'  -   '+tDate+' )'
                      }, 
                      'excel'
                      ],
                    searching: true,
                    order: [[2, "desc"]],
                    bInfo: false,
                    lengthChange: false,
                    ordering: true,
                    info: false,
                    paging: false,
                    pageLength: 10,
                    scrollY: '300px',
                    scrollCollapse: true
                } );
              } );
    </script>

<script type="text/javascript">
    $(document).ready(function () {

      var frDate = document.getElementsByName('fromDate')[0].value;
      var tDate = document.getElementsByName('toDate')[0].value;

      $('#executiveListingId').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'csv',
                            title: 'Executive Listing ( '+frDate+'  -   '+tDate+' )'
                        }, 
                        'excel'
                    ],
                    searching: true,
                    order: [[1, "desc"]],
                    bInfo: false,
                    lengthChange: true,
                    ordering: true,
                    info: false,
                    paging: false,
                    pageLength: 10,
                    scrollY: '300px',
                    scrollCollapse: true
                } );
              } );
    </script>

<script type="text/javascript">
    $(document).ready(function () {

      var frDate = document.getElementsByName('fromDate')[0].value;
      var tDate = document.getElementsByName('toDate')[0].value;

      $('#executiveSurveyId').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'csv',
                            title: 'Executive Survey ( '+frDate+'  -   '+tDate+' )'
                        }, 
                        'excel'
                    ],
                    searching: true,
                    order: [[1, "desc"]],
                    bInfo: false,
                    lengthChange: true,
                    ordering: true,
                    info: false,
                    paging: false,
                    pageLength: 10,
                    scrollY: '300px',
                    scrollCollapse: true
                } );
              } );
    </script>

<script type="text/javascript">
    $(document).ready(function () {

      var frDate = document.getElementsByName('fromDate')[0].value;
      var tDate = document.getElementsByName('toDate')[0].value;

      $('#wardListingId').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                      {
                            extend: 'csv',
                            title: 'Ward Listing ( '+frDate+'  -   '+tDate+' )'
                        }, 
                        'excel'
                    ],
                    searching: true,
                    order: [[1, "desc"]],
                    bInfo: false,
                    lengthChange: true,
                    ordering: true,
                    info: false,
                    paging: false,
                    pageLength: 10,
                    scrollY: '300px',
                    scrollCollapse: true
                } );
              } );
    </script>

<script type="text/javascript">
   $(document).ready(function () {

    var frDate = document.getElementsByName('fromDate')[0].value;
    var tDate = document.getElementsByName('toDate')[0].value;

      $('#wardSurveyId').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                      {
                            extend: 'csv',
                            title: 'Ward Survey ( '+frDate+'  -   '+tDate+' )'
                        }, 
                        'excel'
                    ],
                    searching: true,
                    order: [[1, "desc"]],
                    bInfo: false,
                    lengthChange: true,
                    ordering: true,
                    info: false,
                    paging: false,
                    pageLength: 10,
                    scrollY: '300px',
                    scrollCollapse: true
                } );
              } );
    </script>

<script type="text/javascript">
    $(document).ready(function () {

      $('#allExecutiveShopListId').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                      {
                            extend: 'csv',
                            title: 'All Executive Listing '
                        }, 
                        'excel'
                    ],
                    searching: true,
                    order: [[1, "desc"]],
                    bInfo: false,
                    lengthChange: true,
                    ordering: true,
                    info: false,
                    paging: false,
                    pageLength: 10,
                    scrollY: '300px',
                    scrollCollapse: true
                } );
              } );
    </script>

<script type="text/javascript">
    $(document).ready(function () {

      $('#allExecutiveShopSurveyId').DataTable( {
                    dom: 'Bfrtip',
                    buttons: [
                      {
                            extend: 'csv',
                            title: 'All Executive Survey'
                        }, 
                        'excel'
                    ],
                    searching: true,
                    order: [[1, "desc"]],
                    bInfo: false,
                    lengthChange: true,
                    ordering: true,
                    info: false,
                    paging: false,
                    pageLength: 10,
                    scrollY: '300px',
                    scrollCollapse: true
                } );
              } );
    </script>

    <script type="text/javascript">
       
    </script>

    <script type="text/javascript">
            
            $(document).ready(function() {
                "use strict"
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
                    searching: true,
                    order: [[0, "asc"]],
                    bInfo: false,
                    lengthChange: true,
                    ordering: false,
                    info: false,
                    pageLength: 5,
                    iDisplayLength: 5
                });

                var dataListView = $('.table-5').DataTable({
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
                    searching: false,
                    order: [[0, "asc"]],
                    bInfo: false,
                    lengthChange: false,
                    ordering: true,
                    info: false,
                    pageLength: 5,
                    iDisplayLength: 5
                });

             

              var table = $('#assignShopList').DataTable({
                        dom: "<'row'<'col-sm-3'l><'col-sm-3'f><'col-sm-6'p>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                    "ordering": false,
                    pageLength: 200,
                    lengthMenu: [
                          [10, 25, 50, 100, 200, 500, -1],
                          [10, 25, 50, 100, 200, 500, 'All'],
                      ],
                    });
            });
            
    </script>

    <script type="text/javascript">
    $(document).ready(function () {

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
        yaxis: [
          {
            title: {
              text: "Shops in Thousand"
            },
          }
        ],
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
            'Health', 'Farma','Chemical','Banking (BFS)', 'FMCG', 'Retail', 'Telecom', 
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

        var chartShopSurveyStatusAll = new ApexCharts(document.querySelector("#chartShopSurveyStatusAll"), optionsShopSurveyStatusAll);
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
        yaxis: [
          {
            title: {
              text: "Revenue in Crores"
            },
          }
        ],
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
            'Health', 'Farma','Chemical','Banking (BFS)', 'FMCG', 'Retail', 'Telecom', 
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

        var chartRevenueWithAreaAll = new ApexCharts(document.querySelector("#chartRevenueWithAreaAll"), optionsRevenueWithAreaAll);
        chartRevenueWithAreaAll.render();

        });
    </script>
    
   
    
</body>
<!-- END: Body-->

</html>