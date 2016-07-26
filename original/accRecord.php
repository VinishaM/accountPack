<?php
//If form was submitted, record new transaction and display success message
if (isset($_POST['submit'])) {
    //connect to database mydb
    $server =mysqli_connect('localhost','root','password', 'mydb');
    
    //check connection
    if (mysqli_connect_errno()) {
        die("Connection failed. The following error message was recieved: " . mysqli_connect_error() ." Please try again.");
    } 
    else {   
        //Assign $_POST values, using Real_escape on string inputs in case they contain apostropies.
        $faccName= mysqli_real_escape_string($server,$_POST['formName']);
        $faccNum= $_POST['formNum'];
        $faccType= mysqli_real_escape_string($server,$_POST['formType']);
        $faccBal= $_POST['formBal'];
        
        //Add entry to accounts table
        $query= "INSERT INTO mydb.accounts(accountName, accountType, accountBal, accountNum) VALUES( '" .$faccName. "' , '" .$faccType. "' , '" .$faccBal. "', '" .$faccNum. "')";
        $t= mysqli_query($server, $query); 
        
        // Display error or success message
        if ($t) {
            $message="Success: New Account Added!";
        } else { $message= "There was an error in recording your transaction. Make sure to enter a unique name for each account. Please try again.";}
    }
}

//if no form was submitted, do not display message
else {
    $message="";
}
?>
<!DOCTYPE html>
<html>
    <body>
        <div>
            <?php echo $message ?>
        </div>
        <a href="addAccount.php.php">Enter Account Transaction</a> </br>
    <a href="addTrans.php"> Add a Transaction</a></br>
    <a href="index.php">Return Home</a> </br>
    
    </body>
</html>
