<html>
<head>
<style>
.receipt-content .logo a:hover {
  text-decoration: none;
  color: #7793C4; 
}

.receipt-content .invoice-wrapper {
  background: #FFF;
  border: 1px solid #CDD3E2;
  box-shadow: 0px 0px 1px #CCC;
  padding: 40px 40px 60px;
  margin-top: 40px;
  border-radius: 4px; 
}

.receipt-content .invoice-wrapper .payment-details span {
  color: #A9B0BB;
  display: block; 
}
.receipt-content .invoice-wrapper .payment-details a {
  display: inline-block;
  margin-top: 5px; 
}

.receipt-content .invoice-wrapper .line-items .print a {
  display: inline-block;
  border: 1px solid #9CB5D6;
  padding: 13px 13px;
  border-radius: 5px;
  color: #708DC0;
  font-size: 13px;
  -webkit-transition: all 0.2s linear;
  -moz-transition: all 0.2s linear;
  -ms-transition: all 0.2s linear;
  -o-transition: all 0.2s linear;
  transition: all 0.2s linear; 
}

.receipt-content .invoice-wrapper .line-items .print a:hover {
  text-decoration: none;
  border-color: #333;
  color: #333; 
}

.receipt-content {
  background: #ECEEF4; 
}
@media (min-width: 1200px) {
  .receipt-content .container {width: 900px; } 
}

.receipt-content .logo {
  text-align: center;
  margin-top: 50px; 
}

.receipt-content .logo a {
  font-family: Myriad Pro, Lato, Helvetica Neue, Arial;
  font-size: 36px;
  letter-spacing: .1px;
  color: #555;
  font-weight: 300;
  -webkit-transition: all 0.2s linear;
  -moz-transition: all 0.2s linear;
  -ms-transition: all 0.2s linear;
  -o-transition: all 0.2s linear;
  transition: all 0.2s linear; 
}

.receipt-content .invoice-wrapper .intro {
  line-height: 25px;
  color: #444; 
}

.receipt-content .invoice-wrapper .payment-info {
  margin-top: 25px;
  padding-top: 15px; 
}

.receipt-content .invoice-wrapper .payment-info span {
  color: #A9B0BB; 
}

.receipt-content .invoice-wrapper .payment-info strong {
  display: block;
  color: #444;
  margin-top: 3px; 
}

@media (max-width: 767px) {
  .receipt-content .invoice-wrapper .payment-info .text-right {
  text-align: left;
  margin-top: 20px; } 
}
.receipt-content .invoice-wrapper .payment-details {
  border-top: 2px solid #EBECEE;
  margin-top: 30px;
  padding-top: 20px;
  line-height: 22px; 
}


@media (max-width: 767px) {
  .receipt-content .invoice-wrapper .payment-details .text-right {
  text-align: left;
  margin-top: 20px; } 
}
.receipt-content .invoice-wrapper .line-items {
  margin-top: 40px; 
}
.receipt-content .invoice-wrapper .line-items .headers {
  color: #A9B0BB;
  font-size: 13px;
  letter-spacing: .3px;
  border-bottom: 2px solid #EBECEE;
  padding-bottom: 4px; 
}
.receipt-content .invoice-wrapper .line-items .items {
  margin-top: 8px;
  border-bottom: 2px solid #EBECEE;
  padding-bottom: 8px; 
}
.receipt-content .invoice-wrapper .line-items .items .item {
  padding: 10px 0;
  color: #696969;
  font-size: 15px; 
}
@media (max-width: 767px) {
  .receipt-content .invoice-wrapper .line-items .items .item {
  font-size: 13px; } 
}
.receipt-content .invoice-wrapper .line-items .items .item .amount {
  letter-spacing: 0.1px;
  color: #84868A;
  font-size: 16px;
 }
@media (max-width: 767px) {
  .receipt-content .invoice-wrapper .line-items .items .item .amount {
  font-size: 13px; } 
}

.receipt-content .invoice-wrapper .line-items .total {
  margin-top: 30px; 
}

.receipt-content .invoice-wrapper .line-items .total .extra-notes {
  float: left;
  width: 40%;
  text-align: left;
  font-size: 13px;
  color: #7A7A7A;
  line-height: 20px; 
}

@media (max-width: 767px) {
  .receipt-content .invoice-wrapper .line-items .total .extra-notes {
  width: 100%;
  margin-bottom: 30px;
  float: none; } 
}

.receipt-content .invoice-wrapper .line-items .total .extra-notes strong {
  display: block;
  margin-bottom: 5px;
  color: #454545; 
}

.receipt-content .invoice-wrapper .line-items .total .field {
  margin-bottom: 7px;
  font-size: 14px;
  color: #555; 
}

.receipt-content .invoice-wrapper .line-items .total .field.grand-total {
  margin-top: 10px;
  font-size: 16px;
  font-weight: 500; 
}

.receipt-content .invoice-wrapper .line-items .total .field.grand-total span {
  color: #20A720;
  font-size: 16px; 
}

.receipt-content .invoice-wrapper .line-items .total .field span {
  display: inline-block;
  margin-left: 20px;
  min-width: 85px;
  color: #84868A;
  font-size: 15px; 
}

.receipt-content .invoice-wrapper .line-items .print {
  margin-top: 50px;
  text-align: center; 
}



.receipt-content .invoice-wrapper .line-items .print a i {
  margin-right: 3px;
  font-size: 14px; 
}

.receipt-content .footer {
  margin-top: 20px;
  margin-bottom: 30px;
  text-align: center;
  font-size: 12px;
  color: #969CAD; 
}                    
</style>
</head>
<body>
<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content collapse show">
                    <div class="card-body">

                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                               <div class="row">

                                    <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Shop Name / Shop No</label>
                                             <div class="controls"> 
                                                <input type="input" id="shopNameNoForReceipt" name="shopNameNoForReceipt" value="" class="form-control" placeholder="Shop Name / Shop No" required>
                                             </div>
                                          </div>
                                    </div>

                                    <div class="col-md-6 text-right">
                                          <div class="form-group">
                                             <br>
                                             <div class="controls"> 
                                                   <button type="button" class="btn btn-primary mr-1 mb-1" onclick="ShowDiv_Receipt()">Check Receipt</button>
                                             </div>
                                          </div>
                                    </div>

                              </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- style="display:none;" -->
<section id="Receipt_Format" style="display:none;" > 

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-content collapse show">
                <div class="card-body">


    
<div class="receipt-content">
    <div class="container bootstrap snippets bootdey">
		<div class="row">
			<div class="col-md-12">
				<div class="invoice-wrapper">
					<div class="intro">
						<h5 id="shopName/No"></h5>
                        Shop Mobile No : 9167946585
						<br>
						This is the receipt for a payment of Rs. <strong>7,859.00</strong>
					</div>

					<div class="payment-info">
						<div class="row">
							<div class="col-sm-6">
								<span>Payment No.</span>
								<strong>125485622</strong>
							</div>
							<div class="col-sm-6 text-right">
								<span>Payment Date</span>
								<strong>May 12, 2022 - 12:20 pm</strong>
							</div>
						</div>
					</div>

                
					<div class="line-items">
						<div class="headers clearfix">
						</div>
						<div class="items" style="margin-left:20px;">
							<div class="row item">
                                <tr>
                                    <div class="col-xs-4 desc">
                                        <td>1</td>
                                    </div>
                                    <div class="col-xs-3 qty" style="margin-left:50px;">
                                        <td>Application No :</td>
                                    </div>
                                    <div class="col-xs-5 amount text-left" style="margin-left:350px;">
                                        <td>AC00765</td>
    								</div>
                                </tr>
							</div>
                            <div class="headers clearfix">
						    </div>
							<div class="row item">
                                <div class="col-xs-4 desc">
									2
								</div>
								<div class="col-xs-3 qty" style="margin-left:50px;">
                                    Receipt No :
								</div>
								<div class="col-xs-5 amount text-left" style="margin-left:375px;">
									PC147001
								</div>
							</div>
                            <div class="headers clearfix">
						    </div>
							<div class="row item">
                                <div class="col-xs-4 desc">
									3
								</div>
								<div class="col-xs-3 qty" style="margin-left:50px;">
                                    Applicant's Full Name :
								</div>
								<div class="col-xs-5 amount text-left" style="margin-left:295px;">
									Shraddha Pingle
								</div>
							</div>
                            <div class="headers clearfix">
						    </div>
                            <div class="row item">
                                <div class="col-xs-4 desc">
									4
								</div>
								<div class="col-xs-3 qty" style="margin-left:50px;">
                                    Mobile No :
								</div>
								<div class="col-xs-5 amount text-left" style="margin-left:380px;">
									9546841354
								</div>
							</div>
                            <div class="headers clearfix">
						    </div>
                            <div class="row item">
                                <div class="col-xs-4 desc">
									5
								</div>
								<div class="col-xs-3 qty" style="margin-left:50px;">
                                    Establishment Name :
								</div>
								<div class="col-xs-5 amount text-left" style="margin-left:300px;">
									Mauli  Graphics
								</div>
							</div>
                            <div class="headers clearfix">
						    </div>
                            <div class="row item">
                                <div class="col-xs-4 desc">
									6
								</div>
								<div class="col-xs-3 qty" style="margin-left:50px;">
                                    Establishment Type :
								</div>
								<div class="col-xs-5 amount text-left" style="margin-left:310px;">
                                    Stationary and Xerox
								</div>
							</div>
                            <div class="headers clearfix">
						    </div>
                            <div class="row item">
                                <div class="col-xs-4 desc">
									7
								</div>
								<div class="col-xs-3 qty" style="margin-left:50px;">
                                    Zone Name :
								</div>
								<div class="col-xs-5 amount text-left" style="margin-left:375px;">
                                    F Zone Office
								</div>
							</div>
                            <div class="headers clearfix">
						    </div>
                            <div class="row item">
                                <div class="col-xs-4 desc">
									8
								</div>
								<div class="col-xs-3 qty" style="margin-left:50px;">
                                        Ward No :
								</div>
								<div class="col-xs-5 amount text-left" style="margin-left:400px;">
                                    01
								</div>
							</div>
                            <div class="headers clearfix">
						    </div>
                            <div class="row item">
                                <div class="col-xs-4 desc">
									9
								</div>
								<div class="col-xs-3 qty" style="margin-left:50px;">
                                    Address :
								</div>
								<div class="col-xs-5 amount text-left" style="margin-left:250px;">
                                    Vrindawan Society , Patil Nagar, Chickli - 411062
								</div>
							</div>
                            <div class="headers clearfix">
						    </div>
                            <div class="row item">
                                <div class="col-xs-4 desc">
									10
								</div>
								<div class="col-xs-3 qty" style="margin-left:45px;">
                                    Attached Documents :
								</div>
								<div class="col-xs-5 amount text-left" style="margin-left:250px;">
                                    1. OC, CC <br>
                                    2. Shop Act <br>
                                    3. Fire Challan<br>
                                    4. NOC of Society<br>
                                    5. Pest Control Certificate<br>
                                    6. Rent Agreement<br>
                                    7. Property Tax Challan<br>
                                    8. Water Tax Challan<br>
                                    9. GST Certificate<br>
                                    10. FDA Certificate
								</div>
							</div>
						</div>

						<div class="total text-right">
							
							<div class="field">
								Subtotal <span>7,859.00</span>
							</div>
							<!-- <div class="field">
								Shipping <span>$0.00</span>
							</div> -->
							<div class="field">
								Discount <span>0.0%</span>
							</div>
							<div class="field grand-total">
								Total <span>7,859.00</span>
							</div>
						</div>

						<div class="print">
							<a href="#">
								<i class="fa fa-print"></i>
								Print this receipt
							</a>
						</div>
                        
					</div>
				</div>
                <div class="footer">
				</div>
			</div>
		</div>
	</div>
</div>                    


                        </div>
                </div>
            </div>
        </div>
    </div>

</section>

</body>
</html>