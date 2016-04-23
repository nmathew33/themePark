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

<div>
    <form action="ticketing.php" method="post">
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
                <h3>Coupon</h3>
                <input name="coupon" type="text" id="coupon_id">
                <input type="hidden" name="coupon_value" id="coupon_value">
                <div id="addCoupon" onclick="addCoupon()">Add Coupon</div>
            </div>
            
            <h2>$<span id="total_price">0.00</span></h2>
            
            <div id="payment_options">
                <div class="col-50">
                    <div id="getCash" class=" ticket_input">
                        <h3>Cash</h3>
                        <input   type="number" min="0.01" step="0.01" max="2500" name="cash" placeholder="Cash">
                    </div>
                </div>
                
                <div class="col-50">
                    <div id="getCard">
                        <h3>Card</h3>
                        <input type="number" placeholder="Card Number">
                        <br>
                        <input type="number" placeholder="cvv" min="0" step="1" max="999">
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
                            <option value='10'>2016</option>
                            <option value='11'>2017</option>
                            <option value='12'>2018</option>
                            <option value='12'>2019</option>
                        </select>
                        
                        <input class="inputCard" type="hidden" name="expiry" id="expiry" maxlength="4"/>
                        <br>                            
                        <select name='bank' id='bank_input'>
                            <option value='Visa'>Visa</option>
                            <option value='Mastercard'>Mastercard</option>
                        </select> 
                        
                    </div>
                </div>
            </div>
        <input class='full-width-submit' type="submit" value="Complete order">
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
    
    
    
// var para = document.createElement("p");
// var node = document.createTextNode("This is new.");
// para.appendChild(node);

// var element = document.getElementById("div1");
// element.appendChild(para);


function addAdult() {
    var append_list = document.createElement('div');
    
    var input = document.createElement('input');
    input.name = "first_name[]";
    input.type = "text";
    input.placeholder = "First Name";
    append_list.appendChild(input);
    
    input = document.createElement('input');
    input.name = "last_name[]";
    input.type = "text";
    input.placeholder = "Last Name";
    append_list.appendChild(input);
    
    input = document.createElement('input');
    input.name = "email[]";
    input.type = "text";
    input.placeholder = "Email";
    append_list.appendChild(input);
    
    input = document.createElement('input');
    input.name = "address[]";
    input.type = "text";
    input.placeholder = "Address";
    append_list.appendChild(input);
    
    input = document.createElement('input');
    input.name = "phone[]";
    input.type = "text";
    input.placeholder = "Phone";
    append_list.appendChild(input);
    
    addItem("adultList", append_list);
}

function addChild(){
     var append_list = document.createElement('div');
    
    var input = document.createElement('input');
    input.name = "child_first_name[]";
    input.type = "text";
    input.placeholder = "First Name";
    append_list.appendChild(input);
    
    input = document.createElement('input');
    input.name = "child_last_name[]";
    input.type = "text";
    input.placeholder = "Last Name";
    append_list.appendChild(input);
    
    input = document.createElement('input');
    input.name = "child_email[]";
    input.type = "text";
    input.placeholder = "Email";
    append_list.appendChild(input);
    
    input = document.createElement('input');
    input.name = "child_address[]";
    input.type = "text";
    input.placeholder = "Address";
    append_list.appendChild(input);
    
    input = document.createElement('input');
    input.name = "child_phone[]";
    input.type = "text";
    input.placeholder = "Phone";
    append_list.appendChild(input);
    
    addItem("childList", append_list);  
}



function addItem(element_id, append_item){
    var element = document.getElementById(element_id);
    element.appendChild(append_item);
    updatePrice();
    
}



function updatePrice(){
    var adult_count = document.getElementById("adultList").childElementCount;
    var child_count = document.getElementById("childList").childElementCount;
    console.log("adults", document.getElementById("adultList").childElementCount);
    console.log('update price begin');
    console.log("adult_count", adult_count);
    console.log("adult_price", adult_price.price);
    adult_count += 1;
    console.log("adult_count", adult_count);
    
    total_price1 = adult_count  * adult_price.price;
    total_price1 += child_count * child_price.price;
    console.log(coupon_discount);
    if(coupon_discount < 1){   
        total_price1 = total_price1 * (1 - coupon_discount);
    } else {
        total_price1 = total_price1 - coupon_discount;
    }
    
    console.log('total price', total_price);
    document.getElementById('total_price').innerHTML = total_price1.toFixed(2);        
}    
    
    
function removeItem(name){
    var list = document.getElementById(name); 
    list.removeChild(list.childNodes[list.childElementCount - 1]);
    updatePrice();
}
 

   
function addCoupon() {
    var coupon;
    var coupon_value;
    if (typeof document.getElementById('coupon_id').value != '') {
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
        coupon_value = null;
    }
    updatePrice();
    
}


updatePrice();
    

</script>


<?php
$siteBuilder->getClosinghtmlTags();
?>