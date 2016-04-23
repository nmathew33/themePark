<?php

session_start();

if(isset($_SESSION['id'])){
    $username = $_SESSION['username']; 
    $id = $_SESSION['id'];
    $roleId = $_SESSION['roleId'];
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
} else{
    header("Location: index.php");
}

require("themeparkSiteBuilder.php");
	$siteBuilder = new themeParkSiteBuilder();

	$siteBuilder->getOpeningHtmlTags('Concessions');

	$siteBuilder->getGreyOverLay();

	$siteBuilder->getMenu();
?>

<center>
    <h1>Concessions Stands</h1>

    <form action="concession_stand_items_insert.php" method="post" id="priceform" >
        <p>Concession Stand Name:

            <table border = "1" bgcolor="#FFFFFF" align="left"
            cellspacing="5" cellpadding="8" class="report" id='concession_table'>
                <tr>
                <td align="left"><b>Item</b></td>
                <td align="left"><b>Price</b></td>
                <td align="left"><b>Quantity</b></td>
                </tr>
            </table>

            <?php 

                require_once('../db_connection.php');

                $query = "SELECT * FROM Concession_Stands";
                $response = @mysqli_query($dbc, $query);
                if($response){
                    echo '<select name="ConcessionName"  form="priceform">';

                    while($row = @mysqli_fetch_array($response)){
                        echo '<option value="' . $row['idConcession_Stands'] . '">' . $row['name'];
                        echo '</option>';
                    }

                    echo '</select>';
                } else {
                    echo "Couldn't obtain role list";

                    echo mysqli_error($dbc);
                }
            ?>
        </p>
        <p>Customer ID:<input name="customerID" type="text" placeholder="Customer ID" form="priceform" /></p>
        <h2 class="total_price">	
                    Total: <span id='total_value'>0.00</span>
                    <input type="hidden" name="total" id="total_value_input" form="priceform">
        </h2>
        <div id="payment_options" style="display: inline-block;">>
                <div class="col-50">
                    <div id="getCash" class=" ticket_input">
                        <h3>Cash</h3>
                        <input type="number" min="0.01" step="0.01" max="2500" name="cash" placeholder="Cash">
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
    <input type = "submit" name="submit" value="Purchase">

    </form>
    </center>


    <?php

            if(isset($_POST['ConcessionName'])){
            
            require_once('../db_connection.php');

            $query = "SELECT idConcession_Pricing, name ,price 
                        FROM Concession_Pricing
                        WHERE location = " . $_POST['ConcessionName'];

            $response = @mysqli_query($dbc, $query);

            if($response){


            while($row =@mysqli_fetch_array($response)){

                $field_array[] = $row; 

            // echo '<tr><td align="left">' .
            // $row['idConcession_Pricing'] . '</td><td align="left">' . 
            // $row['name'] . '</td><td align="left">' .
            // $row['price'] . '</td><td align="left">' .
            // '<input name="'. $row['idConcession_Pricing'].'" type="number" min="0" value="0">';
            // echo '</tr>';

            }
            // echo '</table>';

            $output = @json_encode($field_array);
        } else {
            echo "Couldn't issue database query<br />";
        }
    }
    mysqli_close($dbc);
?>

<script>
	var json = <?php echo $output ?>;
	console.log(json);
	var table = document.getElementById('concession_table');
	// for (var i = json.length - 1; i >= 0; i--) ;
	json.forEach(function(concession){
		var append_row = document.createElement('tr');
		append_row.class = "concession_row";
		var append_data = document.createElement('td');
		append_data.align ="left";
		append_data.innerText = concession.name;
		append_row.appendChild(append_data);

		append_data = document.createElement('td');
		append_data.align ="left";
		append_data.innerText = concession.price;
		append_data.className = "concession_price";
		append_row.appendChild(append_data);
		table.appendChild(append_row);


		append_data = document.createElement('td');
		var input_element = document.createElement('input');
		input_element.type = 'number';
		input_element.min = 0;
		input_element.value = 0;
		append_data.appendChild(input_element);
		append_data.align ="left";
		append_row.appendChild(append_data);
		table.appendChild(append_row);

	});



	var x = document.getElementById('concession_table');
	console.log(x);

	x.addEventListener('input', function(event){
		var total_price = 0.00;
		var price_table = x;
		for (var i = 0, row; row = price_table.rows[i]; i++) {
	        for (var j = 0, col; col = row.cells[j]; j++) {
	        		if (col.className == 'concession_price') {
	        			if (typeof row.cells[j+1].childNodes[0].value != 'undefined') {
	        				total_price += parseFloat(col.innerText) * parseFloat(row.cells[j+1].childNodes[0].value);
	        			};
	        		};
			} 
		}
		console.log("total", total_price);
		document.getElementById('total_value').innerHTML = total_price.toFixed(2);
        document.getElementById("total_value_input").value =  total_price.toFixed(2);
	});


</script>

<?php
 $siteBuilder->getClosinghtmlTags();
 ?>
