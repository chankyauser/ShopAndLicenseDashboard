
<!-- Node Wise Shop Summary-->
<section id="node-wise-shop">
<div class="row">
                <div class="col-xl-6 col-md-6 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                        <h4 class="card-title">
                        <?php if(isset($_SESSION['Form_Language']) && $_SESSION['Form_Language'] == 'English')
                                    {  
                                        echo "Node Wise Shop Survey Summary";
                                    }
                                    else if(isset($_SESSION['Form_Language']) && $_SESSION['Form_Language'] == 'Marathi')
                                    { 
                                        echo "नोडनुसार दुकान सर्वेक्षण विवरण";
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
                                                <th>Shop Count</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php



                                                $srNo = 1;
                                                $ShopTotal = 0;
                                                $wardPck = "";
                                                foreach ($dataNodeWiseSurveyShop as $key => $value) {
                                                    $ShopTotal = $ShopTotal + $value["ShopCount"];
                                                ?> 
                                               
                                                    <tr>
                                                        <td><?php echo $srNo++; ?></td>
                                                        <td><?php echo $value["NodeName"]; ?></td>
                                                        <td><?php echo $value["ShopCount"]; ?></td>
                                                        <td>
                                                             <a  target="_blank" href="<?php echo 'index.php?p=shop-survey-grid&filter_date=All&filter_type=NodeWiseShop&nodeName='.$value["NodeName"].'' ; ?>"><i class="feather icon-grid" style="font-size: 1.5rem;color:#852B44;"></i></a>
                                                            <a  target="_blank" href="<?php echo 'index.php?p=shop-survey-list&filter_date=All&filter_type=NodeWiseShop&nodeName='.$value["NodeName"].'' ; ?>"><i class="feather icon-list" style="font-size: 1.5rem;color:#852B44;"></i></a>
                                                            <a  target="_blank" href="<?php echo 'index.php?p=shop-survey-map&filter_date=All&filter_type=NodeWiseShop&nodeName='.$value["NodeName"].'' ; ?>"><i class="feather icon-map-pin" style="font-size: 1.5rem;color:#852B44;"></i></a> 
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2">Total</th>
                                                <th><?php echo $ShopTotal; ?></th>
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
                                        echo "Node Wise Shop Graph";
                                    }
                                    else if(isset($_SESSION['Form_Language']) && $_SESSION['Form_Language'] == 'Marathi')
                                    { 
                                        echo "नोडनुसार दुकान आलेख";
                                    }  
                                    ?>
                                    
                                    </h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div id="nodeWisePieChart" style="height: 520px;width: 100%;"></div>
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
                                        echo "Ward Wise Shop Survey Summary";
                                    }
                                    else if(isset($_SESSION['Form_Language']) && $_SESSION['Form_Language'] == 'Marathi')
                                    { 
                                        echo "प्रभागनिहाय दुकान सर्वेक्षण विवरण";
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
                                                <th>Shop Count</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php



                                                $srNo = 1;
                                                $ShopTotal = 0;
                                                $wardPck = "";
                                                foreach ($dataWardWiseSurveyShop as $key => $value) {
                                                    $ShopTotal = $ShopTotal + $value["ShopCount"];
                                                ?> 
                                               
                                                    <tr>
                                                        <td><?php echo $srNo++; ?></td>
                                                        <td><?php echo $value["Ward_No"]; ?></td>
                                                        <td><?php echo $value["ShopCount"]; ?></td>
                                                        <td>
                                                             <a  target="_blank" href="<?php echo 'index.php?p=shop-survey-grid&filter_date=All&filter_type=WardWiseShop&WardNo='.$value["Ward_No"].'' ; ?>"><i class="feather icon-grid" style="font-size: 1.5rem;color:#852B44;"></i></a>
                                                            <a  target="_blank" href="<?php echo 'index.php?p=shop-survey-list&filter_date=All&filter_type=WardWiseShop&WardNo='.$value["Ward_No"].'' ; ?>"><i class="feather icon-list" style="font-size: 1.5rem;color:#852B44;"></i></a>
                                                            <a  target="_blank" href="<?php echo 'index.php?p=shop-survey-map&filter_date=All&filter_type=WardWiseShop&WardNo='.$value["Ward_No"].'' ; ?>"><i class="feather icon-map-pin" style="font-size: 1.5rem;color:#852B44;"></i></a> 
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2">Total</th>
                                                <th><?php echo $ShopTotal; ?></th>
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
                                        echo "Ward Wise Shop Graph";
                                    }
                                    else if(isset($_SESSION['Form_Language']) && $_SESSION['Form_Language'] == 'Marathi')
                                    { 
                                        echo "प्रभागनिहाय दुकान आलेख";
                                    }  
                                    ?>
                                    
                                    </h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div id="wardWisePieChart" style="height: 520px;width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
<section>