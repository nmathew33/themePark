<?php
session_start();
if(isset($_SESSION['id'])){
    require_once('../db_connection.php');
    $username = $_SESSION['username']; 
    $id = $_SESSION['id'];
    $roleId = $_SESSION['roleId'];
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
} else{
    header("Location: index.php");
}
$query = "SELECT * FROM Coupon";
$response = @mysqli_query($dbc,$query);
while ($row = @mysqli_fetch_array($response)) {
    
    $result[] = $row;
}
$json = @json_encode($result);
$query = "SELECT * FROM Ticket_Pricing";
$response2 = @mysqli_query($dbc,$query);
while ($row = @mysqli_fetch_array($response2)) {
    
    $result2[] = $row;
}
$json_prices = @json_encode($result2);
@mysqli_close($dbc);
require("themeparkSiteBuilder.php");
$siteBuilder = new themeParkSiteBuilder();
$siteBuilder->getOpenHtmlTags();
$siteBuilder->getGreyOverLay();
$siteBuilder->getMenu();
?>

<div class="col-70">
    <form action="ticketingInsert.php" method="post">
            <div class="col-100">
                <h3>Adults</h3>
                <div class='ticket_input'>
                    <div class="input-group">
                        <input name="first_name[]" type="text" placeholder="First Name" />
                        <input name="last_name[]" type="text" placeholder="Last Name" />
                        <input name="email[]" type="text" placeholder="E-Mail">
                        <input name="phone[]" type="text" placeholder="Phone">
                    </div>
                    <div class="col-100">
                        <input name="address[]" class="col-100" type="text" placeholder="Address">
                    </div>
                    <div id="adultList"></div>
                    <div class="button_group">
                        <div onclick="addAdult()" >Add Adult</div>
                        <div onclick="removeItem('adultList')" >Remove Adult</div>
                    </div>
                </div>
            </div>

            <div>
                <h3>Children</h3>
                <div class='ticket_input'>
                    <div id="childList"></div>
                    <div class="button_group">
                        <div onclick="addChild()">Add Child</div>                    
                        <div onclick="removeItem('childList')">Remove Child</div>
                    </div>
                </div>
            </div>
            
            <div class="col-100">
                <div id="getCoupon">
                    <h3>Coupon</h3>
                    <input name="coupon" type="text" id="coupon_id">
                    <input type="hidden" name="coupon_value" id="coupon_value" value="0">
                    <div class="button_group">
                        <div id="addCoupon" onclick="addCoupon()">Add Coupon</div>
                    </div>
                </div>
            </div>
            
            
            
                <table class="price_table">
                    <tr>
                        <td>
                            Adults
                        </td>
                        <td id="table_adult_count"></td>
                        <td id="table_adult_price"></td>
                        <td id="table_adult_total_price"></td>
                    </tr>
                    
                    <tr>
                        <td>Children</td>
                        <td id="table_children_count"></td>
                        <td id="table_children_price"></td>
                        <td id="table_children_total_price"></td>
                    </tr>
                    <tr>
                        <td>Coupon</td>
                        <td></td>
                        <td id="table_coupon_discount"></td>
                        <td id="table_discount_total"></td>
                    </tr>
                    <tr>
                        <td>Subtotal</td>
                        <td></td>
                        <td></td>
                        <td id="table_subtotal"></td>
                    </tr>
                    <tr>
                        <td>Tax</td>
                        <td></td>
                        <td id="table_tax_percentage"></td>
                        <td id="table_tax_amount"></td>
                    </tr>
                    <tr class="price_table_total">
                        <td>Total</td>
                        <td></td>
                        <td></td>
                        <td id="table_total_price"></td>
                    </tr>
                </table>
            
            <div class="col-100">
                
                <div class="button_group">
                    <div onclick="payment_type(1)" >Card Payment</div>
                    <div onclick="payment_type(2)" >Cash Payment</div>
                </div>
                
                <div id="payment_options">
                    <div class="col-100">
                        <div id="getCash">
                            <h3>Cash</h3>
                            <input id="cash_amount"  type="number" min="0.01" step="0.01" max="2500" name="cash" placeholder="Amount">
                        </div>
                    </div>
                    
                    <div class="col-100">
                        <div id="getCard">
                            <h3>Card</h3>
                            <input  id="card_amount" type="number" min="0.01" step="0.01" max="2500" name="card_amount" placeholder="Amount">                        
                            <input type="number" name="cnumber" placeholder="Card Number">
                            <br>
                            <input type="number" name="cvv" placeholder="cvv" min="0" step="1" max="999">
                            <br>                            
                            <select name='expireMM' id='expireMM'>
                                <option value=''>Month</option>
                                <option value='01'>Janaury/01</option>
                                <option value='02'>February/02</option>
                                <option value='03'>March/03</option>
                                <option value='04'>April/04</option>
                                <option value='05'>May/05</option>
                                <option value='06'>June/06</option>
                                <option value='07'>July/07</option>
                                <option value='08'>August/08</option>
                                <option value='09'>September/09</option>
                                <option value='10'>October/10</option>
                                <option value='11'>November/11</option>
                                <option value='12'>December/12</option>
                            </select>
                            <select name='expireYY' id='expireYY'>
                                <option value=''>Year</option>
                                <option value='2016'>2016</option>
                                <option value='2017'>2017</option>
                                <option value='2018'>2018</option>
                                <option value='2019'>2019</option>
                                <option value='2020'>2020</option>
                            </select>
                            
                            <input class="inputCard" type="hidden" name="expiry" id="expiry" maxlength="4"/>
                            <br>                            
                            <select name='bank' id='bank_input'>
                                <option value='Visa'>Visa</option>
                                <option value='Mastercard'>Mastercard</option>
                                <option value='American Express'>American Express</option>
                                <option value='Discover'>Discover</option>
                            </select> 
                            
                        </div>
                    </div>
                </div>
            </div>
            
            <input type="hidden" name="adult_price" id="adult_price">
            <input type="hidden" name="child_price" id="child_price">
            <input type="hidden" value="0" id="hidden_total_price" name="total_value_input">
            
            
            
            
            
            
        <input class='full-width-submit' type="submit" name="submit" value="Complete order">
    </form>
</div>

<script> 
    console.log("query", "<?php echo $query; ?>");
    var output = <?php echo $json; ?>;
    console.log("coupons", output);
    var prices = <?php echo $json_prices ?>;
    console.log(prices);
    var coupon_discount = 0;
    var adult_price = prices.filter(function( obj ) { return obj.name == 'adult'; })[0];
    var child_price = prices.filter(function( obj ) { return obj.name == 'child'; })[0];
    var total_price = adult_price.price;
    
    document.getElementById("adult_price").value =  adult_price.price;
    document.getElementById("child_price").value =  child_price.price;
    
function payment_type(type){
    switch (type) {
        case 1:
            document.getElementById('getCash').style.display = "none";
            document.getElementById('getCard').style.display = "block";
        break;   
        
        case 2:
            document.getElementById('getCash').style.display = "block";
            document.getElementById('getCard').style.display = "none";
        break;   
    }
}
function addAdult() {
    var append_list = document.createElement('div');
    append_list.className = 'input-group';
    append_list.innerHTML = '<input name="first_name[]" type="text" placeholder="First Name" />\
                        <input name="last_name[]" type="text" placeholder="Last Name" />\
                        <input name="email[]" type="text" placeholder="E-Mail">\
                        <input name="phone[]" type="text" placeholder="Phone">\
                    </div>\
                    <div class="col-100">\
                        <input name="address[]" class="col-100" type="text" placeholder="Address">\
                    </div>\
    ';
    
    addItem("adultList", append_list);
}
function addChild(){
    var append_list = document.createElement('div');
    append_list.className = 'input-group';
    append_list.innerHTML = '<input name="child_first_name[]" type="text" placeholder="First Name" />\
                        <input name="child_last_name[]" type="text" placeholder="Last Name" />\
                        <input name="child_email[]" type="text" placeholder="E-Mail">\
                        <input name="child_phone[]" type="text" placeholder="Phone">\
                    </div>\
                    <div class="col-100">\
                        <input name="child_address[]" class="col-100" type="text" placeholder="Address">\
                    </div>\
    ';
    
    addItem("childList", append_list);
    
    
    
    
    
    
}
function addItem(element_id, append_item){
    var element = document.getElementById(element_id);
    element.appendChild(append_item);
    updatePrice();
}
function updatePrice(){
    var finalTotal;
    var adult_count = document.getElementById("adultList").childElementCount;
    var child_count = document.getElementById("childList").childElementCount;
    adult_count += 1;
    
    document.getElementById('table_adult_count').innerHTML = adult_count;    
    document.getElementById('table_adult_price').innerHTML = adult_price.price;    
    document.getElementById('table_children_count').innerHTML = child_count;    
    document.getElementById('table_children_price').innerHTML = child_price.price;    
    
    console.log("adult_count", adult_count);
    
    total_price1 = adult_count  * adult_price.price;
    document.getElementById('table_adult_total_price').innerHTML = (adult_count * adult_price.price).toFixed(2);        
    document.getElementById('table_children_total_price').innerHTML = (child_count * child_price.price).toFixed(2);        
    total_price1 += child_count * child_price.price;
    console.log(coupon_discount);
    if(coupon_discount === 0){
        console.log("no discount");
        document.getElementById('table_coupon_discount').innerHTML = '';
        document.getElementById('table_discount_total').innerHTML = '';
    } else if (coupon_discount < 1){   
        var discount_amount = total_price1 * coupon_discount;
        total_price1 = total_price1 * (1 - coupon_discount);
        document.getElementById('table_coupon_discount').innerHTML = (coupon_discount*100) +'% off';
        document.getElementById('table_discount_total').innerHTML = "$" + discount_amount.toFixed(2);
    } else {
        var discount_amount = coupon_discount;        
        total_price1 = total_price1 - coupon_discount;
        document.getElementById('table_coupon_discount').innerHTML = '$'+coupon_discount+' off';
        document.getElementById('table_discount_total').innerHTML = "$" + discount_amount.toFixed(2);               
    }
    
    console.log('total price', total_price);
    document.getElementById('table_subtotal').innerHTML = total_price1.toFixed(2);     
    document.getElementById('table_tax_percentage').innerHTML = '8.25%';     
    document.getElementById('table_tax_amount').innerHTML = (total_price1 * .0825).toFixed(2);     
    finalTotal = total_price1 * 1.0825;
    document.getElementById('table_total_price').innerHTML = finalTotal.toFixed(2);
    document.getElementById('hidden_total_price').value = finalTotal.toFixed(2);
}    
    
function removeItem(name){
    var list = document.getElementById(name); 
    list.removeChild(list.childNodes[list.childElementCount - 1]);
    updatePrice();
}
   
function addCoupon() {
    var coupon;
    var coupon_value;
    if (document.getElementById('coupon_id').value != '') {
        coupon = document.getElementById('coupon_id').value;
        coupon_value = output.filter(function( obj ) { return obj.code == coupon; });
        if(typeof coupon_value != 'undefined'){
            console.log("typeof",typeof coupon_value);
            console.log(coupon_value[0].name);
            coupon_discount = coupon_value[0].amount;
            console.log(coupon_value);
        }
    } else {
        coupon = "";
        coupon_discount = 0;
    }
    updatePrice();
    
}
updatePrice();
    
</script>


<?php
$siteBuilder->getClosinghtmlTags();
?>