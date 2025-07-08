<!-- Dashboard Analytics Start -->
<section id="dashboard-analytics">
<?php
   $db=new DbOperation();
   $userName=$_SESSION['SAL_UserName'];
   $appName=$_SESSION['SAL_AppName'];
   $electionName=$_SESSION['SAL_ElectionName'];
   $developmentMode=$_SESSION['SAL_DevelopmentMode'];
   $currentDate = date('Y-m-d');
   $fromDate = $currentDate." ".$_SESSION['StartTime'];
   $toDate =$currentDate." ".$_SESSION['EndTime'];

?>

     <!-- // Basic multiple Column Form section start -->
     <section id="multiple-column-form">
                    <div class="row match-height">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">User Master</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                    <form class="form-horizontal" novalidate>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <div class="controls"> 
                                            <input type="text" name="firstName" value=""  class="form-control" data-validation-required-message="This field is required" placeholder="First Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Middle Name</label>
                                        <div class="controls"> 
                                            <input type="text" name="middleName" value=""  class="form-control" data-validation-required-message="This field is required" placeholder="Middle Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <div class="controls"> 
                                            <input type="text" name="lastName" value=""  class="form-control" data-validation-required-message="This field is required" placeholder="Last Name">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Designation</label>
                                        <div class="controls"> 
                                            <input type="text" name="designation" value=""  class="form-control" data-validation-required-message="This field is required" placeholder="Designation">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Mobile 1</label>
                                        <div class="controls"> 
                                            <input type="number" name="mobile1" value=""  class="form-control" data-validation-required-message="This field is required" placeholder="Mobile1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Mobile 2</label>
                                        <div class="controls"> 
                                            <input type="number" name="mobile2" value=""  class="form-control" data-validation-required-message="This field is required" placeholder="Mobile2">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>EmailID</label>
                                        <div class="controls"> 
                                            <input type="email" name="email" value=""  class="form-control" data-validation-required-message="This field is required" placeholder="Emaill">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Photo</label>
                                        <div class="controls"> 
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="inputGroupFile01">
                                                        <label class="custom-file-label" data-validation-required-message="This field is required" for="inputGroupFile01">Choose file</label>
                                                    </div>
                                              
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Address1</label>
                                        <div class="controls"> 
                                            <input type="text" name="address1" value=""  class="form-control" data-validation-required-message="This field is required" placeholder="Address1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Address2</label>
                                        <div class="controls"> 
                                            <input type="text" name="address2" value=""  class="form-control" data-validation-required-message="This field is required" placeholder="Address2">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Remark</label>
                                        <div class="controls"> 
                                            <input type="text" name="remark" value=""  class="form-control" data-validation-required-message="This field is required" placeholder="Remark">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>IsActive</label>
                                        <div class="controls"> 
                                        <select class="select2 form-control" name="userIsActive" >
                                            <option value="">--Select--</option>   
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                    
                                <div class="col-xs-12 col-md-12 text-left">
                                                        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                                        <button type="reset" class="btn btn-outline-warning mr-1 mb-1">Reset</button>
                                                    </div>

    
                              
                                
                            </div>
                           
                            
                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic Floating Label Form section end -->