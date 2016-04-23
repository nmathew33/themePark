<?php
echo $_POST['submit'];
 if(isset($_POST['submit'])){
     echo "yes";
     echo "each item: ";
     foreach($_POST as $item)
    {
        echo $item;
    }
 }
?>