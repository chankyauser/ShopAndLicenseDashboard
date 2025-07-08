    
            
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
       $('.zero-configuration').DataTable({"ordering": false,"info":false});
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

    <!-- Zoom Hover Effect -->

  <!--   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	 -->
	
    
   
    
</body>
<!-- END: Body-->

</html>