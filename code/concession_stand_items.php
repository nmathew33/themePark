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

    <form action="concession_stand_items.php" method="post" id="priceform" >
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
        <h2 class="total_price">	
                    Total: <span id='total_value'>0.00</span>
        </h2>
    <input type = "submit" value="Select">

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
	});


</script>

<?php
 $siteBuilder->getClosinghtmlTags();
 ?>
