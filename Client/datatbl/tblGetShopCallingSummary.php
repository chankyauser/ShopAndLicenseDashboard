
<!-- Node Wise Shop Summary-->
<section id="category-wise-shop">
<div class="row">
                <div class="col-xl-6 col-md-6 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                        <h4 class="card-title">
                        <?php if(isset($_SESSION['Form_Language']) && $_SESSION['Form_Language'] == 'English')
                                    {  
                                        echo "Category Wise Shop Calling Summary";
                                    }
                                    else if(isset($_SESSION['Form_Language']) && $_SESSION['Form_Language'] == 'Marathi')
                                    { 
                                        echo "श्रेणीनुसार दुकान कॉलिंग विवरण";
                                    }  
                                    ?>
                                    
                                    </h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table zero-configuration table-hover-animation table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Sr No</th>
                                                <th>Node Name</th>
                                                <th>Count</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php



                                                $srNo = 1;
                                                $ShopCallingTotal = 0;
                                                $wardPck = "";
                                                foreach ($dataCategoryWiseCallingShop as $key => $value) {
                                                    $ShopCallingTotal = $ShopCallingTotal + $value["ShopCallingCount"];
                                                ?> 
                                               
                                                    <tr>
                                                        <td><?php echo $srNo++; ?></td>
                                                        <td><?php echo $value["Calling_Category"]; ?></td>
                                                        <td><?php echo $value["ShopCallingCount"]; ?></td>
                                                        <td>
                                                             <a  target="_blank" href="<?php echo 'index.php?p=shop-calling-grid&filter_date=All&filter_type=CategoryWiseShop&callingCategory='.$value["Calling_Category"].'' ; ?>"><i class="feather icon-grid" style="font-size: 1.5rem;color:#852B44;"></i></a>
                                                            <a  target="_blank" href="<?php echo 'index.php?p=shop-calling-list&filter_date=All&filter_type=CategoryWiseShop&callingCategory='.$value["Calling_Category"].'' ; ?>"><i class="feather icon-list" style="font-size: 1.5rem;color:#852B44;"></i></a>
                                                            <a  target="_blank" href="<?php echo 'index.php?p=shop-calling-map&filter_date=All&filter_type=CategoryWiseShop&callingCategory='.$value["Calling_Category"].'' ; ?>"><i class="feather icon-map-pin" style="font-size: 1.5rem;color:#852B44;"></i></a> 
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2">Total</th>
                                                <th><?php echo $ShopCallingTotal; ?></th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-md-6 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                        <h4 class="card-title">
                        <?php if(isset($_SESSION['Form_Language']) && $_SESSION['Form_Language'] == 'English')
                                    {  
                                        echo "Category Wise Shop Calling Graph";
                                    }
                                    else if(isset($_SESSION['Form_Language']) && $_SESSION['Form_Language'] == 'Marathi')
                                    { 
                                        echo "श्रेणीनुसार दुकान कॉलिंग आलेख";
                                    }  
                                    ?>
                                    
                                    </h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div id="categoryWisePieChart" style="height: 520px;width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

<section>

<!-- Node Wise Shop Summary-->
<section id="node-wise-shop">
<div class="row">
                <div class="col-xl-6 col-md-6 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                        <h4 class="card-title">
                        <?php if(isset($_SESSION['Form_Language']) && $_SESSION['Form_Language'] == 'English')
                                    {  
                                        echo "Node Wise Shop Calling Summary";
                                    }
                                    else if(isset($_SESSION['Form_Language']) && $_SESSION['Form_Language'] == 'Marathi')
                                    { 
                                        echo "नोडनुसार दुकान कॉलिंग सर्वेक्षण विवरण";
                                    }  
                                    ?>
                                    
                                    </h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table zero-configuration table-hover-animation table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Sr No</th>
                                                <th>Node Name</th>
                                                <th>Count</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php



                                                $srNo = 1;
                                                $ShopCallingTotal = 0;
                                                $wardPck = "";
                                                foreach ($dataNodeWiseCallingShop as $key => $value) {
                                                    $ShopCallingTotal = $ShopCallingTotal + $value["ShopCallingCount"];
                                                ?> 
                                               
                                                    <tr>
                                                        <td><?php echo $srNo++; ?></td>
                                                        <td><?php echo $value["NodeName"]; ?></td>
                                                        <td><?php echo $value["ShopCallingCount"]; ?></td>
                                                        <td>
                                                             <a  target="_blank" href="<?php echo 'index.php?p=shop-calling-grid&filter_date=All&filter_type=NodeWiseShop&nodeName='.$value["NodeName"].'' ; ?>"><i class="feather icon-grid" style="font-size: 1.5rem;color:#852B44;"></i></a>
                                                            <a  target="_blank" href="<?php echo 'index.php?p=shop-calling-list&filter_date=All&filter_type=NodeWiseShop&nodeName='.$value["NodeName"].'' ; ?>"><i class="feather icon-list" style="font-size: 1.5rem;color:#852B44;"></i></a>
                                                            <a  target="_blank" href="<?php echo 'index.php?p=shop-calling-map&filter_date=All&filter_type=NodeWiseShop&nodeName='.$value["NodeName"].'' ; ?>"><i class="feather icon-map-pin" style="font-size: 1.5rem;color:#852B44;"></i></a> 
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2">Total</th>
                                                <th><?php echo $ShopCallingTotal; ?></th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-md-6 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                        <h4 class="card-title">
                        <?php if(isset($_SESSION['Form_Language']) && $_SESSION['Form_Language'] == 'English')
                                    {  
                                        echo "Node Wise Shop Calling Graph";
                                    }
                                    else if(isset($_SESSION['Form_Language']) && $_SESSION['Form_Language'] == 'Marathi')
                                    { 
                                        echo "नोडनुसार दुकान कॉलिंग आलेख";
                                    }  
                                    ?>
                                    
                                    </h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div id="nodeWiseCallingPieChart" style="height: 520px;width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

<section>


<section id="ward-wise-shop">
<!-- Ward Wise Shop Summary-->
        <div class="row">
                <div class="col-xl-6 col-md-6 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                        <h4 class="card-title">
                        <?php if(isset($_SESSION['Form_Language']) && $_SESSION['Form_Language'] == 'English')
                                    {  
                                        echo "Ward Wise Shop Calling Summary";
                                    }
                                    else if(isset($_SESSION['Form_Language']) && $_SESSION['Form_Language'] == 'Marathi')
                                    { 
                                        echo "प्रभागनिहाय दुकान कॉलिंग सर्वेक्षण विवरण";
                                    }  
                                    ?>
                                    
                                    </h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table zero-configuration table-hover-animation table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Sr No</th>
                                                <th>Ward Name</th>
                                                <th>Count</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php



                                                $srNo = 1;
                                                $ShopCallingTotal = 0;
                                                $wardPck = "";
                                                foreach ($dataWardWiseCallingShop as $key => $value) {
                                                    $ShopCallingTotal = $ShopCallingTotal + $value["ShopCallingCount"];
                                                ?> 
                                               
                                                    <tr>
                                                        <td><?php echo $srNo++; ?></td>
                                                        <td><?php echo $value["Ward_No"]; ?></td>
                                                        <td><?php echo $value["ShopCallingCount"]; ?></td>
                                                        <td>
                                                             <a  target="_blank" href="<?php echo 'index.php?p=shop-calling-grid&filter_date=All&filter_type=WardWiseShop&WardNo='.$value["Ward_No"].'' ; ?>"><i class="feather icon-grid" style="font-size: 1.5rem;color:#852B44;"></i></a>
                                                            <a  target="_blank" href="<?php echo 'index.php?p=shop-calling-list&filter_date=All&filter_type=WardWiseShop&WardNo='.$value["Ward_No"].'' ; ?>"><i class="feather icon-list" style="font-size: 1.5rem;color:#852B44;"></i></a>
                                                            <a  target="_blank" href="<?php echo 'index.php?p=shop-calling-map&filter_date=All&filter_type=WardWiseShop&WardNo='.$value["Ward_No"].'' ; ?>"><i class="feather icon-map-pin" style="font-size: 1.5rem;color:#852B44;"></i></a> 
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2">Total</th>
                                                <th><?php echo $ShopCallingTotal; ?></th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-md-6 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                        <h4 class="card-title">
                        <?php if(isset($_SESSION['Form_Language']) && $_SESSION['Form_Language'] == 'English')
                                    {  
                                        echo "Ward Wise Shop Calling Graph";
                                    }
                                    else if(isset($_SESSION['Form_Language']) && $_SESSION['Form_Language'] == 'Marathi')
                                    { 
                                        echo "प्रभागनिहाय दुकान कॉलिंग आलेख";
                                    }  
                                    ?>
                                    
                                    </h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div id="wardWiseCallingPieChart" style="height: 520px;width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
<section>