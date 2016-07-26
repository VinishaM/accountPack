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
        include("functions.php");
        //Assign $_POST values, using Real_escape on atring inputs in case they contain apostropies.
        $fDate= $_POST['formDate'];
        $fAmount= $_POST['formAmount'];
        $fDetail= $_POST['formDetail'];
        $fAccToClean= mysqli_real_escape_string($server,$_POST['formToAcc']);
        $fAccFromClean= mysqli_real_escape_string($server,$_POST['formFromAcc']); 
        
        //Convert name accounts into their id numbers from the accouts table. Real_escape input in case it contains apostropies.
        $fToAcc= grabInfo($fAccToClean, $server, 'idaccounts');
        $fFromAcc= grabInfo($fAccFromClean, $server, 'idaccounts');

        //Add entry to transactions table 
        $queryAddTrans = "INSERT INTO mydb.transactions(transDate, amount, toAccount, fromAccount, details) VALUES ( '" .$fDate. "' , '" .$fAmount. "' , '" .$fToAcc. "', '" .$fFromAcc. "' , '" .$fDetail. "' )";
        $t= mysqli_query($server, $queryAddTrans); 
        
        //Update balances in the account table
        changeBals($fAccToClean,$fAccFromClean, $fAmount, $server);
        
        // Display error or success message
        if ($t) {
            $message="Success: Transaction Recorded!";
        } else { $message= "There was an error in recording your transaction. Please try again.";}
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
        <a href="addTrans.php">Enter Another Transaction</a> </br>
        <a href="addAccount.php"> Add an Account</a>
    <a href="index.php">Return Home</a> </br>
    
    </body>
</html>

