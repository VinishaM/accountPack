<?php 
                //Connect to database
                $server =mysqli_connect('localhost','root','password', 'mydb');                 //check connection
                if (mysqli_connect_errno()) {
                    die("Connection failed. The following error message was recieved: " . mysqli_connect_error() ." Please try again.");
                }
                
               //Add entry to accounts table
    $name="TEST";

    $query= "INSERT INTO mydb.accounts(accountName, accountType, accountBal, accountNum) VALUES( '" .$name. "' , 'Retail', '0', '101010')";
        $t= mysqli_query($server, $query); 
        
        // Display error or success message
        if ($t) {
            $message="Success: New Account Added Recorded!";
        } else { $message= "There was an error in recording your transaction. Make sure to enter a unique name for each account. Please try again.";}
?>
<html>
<!--
//connect to database mydb
$server =mysqli_connect('localhost','root','password', 'mydb');
//check connection
if (mysqli_connect_errno()) {
        die("Connection failed. The following error message was recieved: " . mysqli_connect_error() ." Please try again.");
    } 
else {
echo "connection successful! "; 
    
    //create array of all account names
    $query="SELECT accountName FROM mydb.accounts ORDER BY accountName";
    $result= mysqli_query($server, $query);
    while ($row= mysqli_fetch_array($result)) {
        echo $row[0];
}
}  
   /*  
    $fToAcc= grabAccID("Macy's", $server);
    $fFromAcc= grabAccID("PNC", $server);
    
    $t= $server -> query("INSERT INTO mydb.transactions(transDate, amount, toAccount, fromAccount, details) VALUES ()"); 
    
    
       
        $array=$mysql->fetch_assoc();
        return $array["idaccounts"];
    }
    


$g= $server->query("SELECT * FROM mydb.deposits WHERE SourceName='fghs'");
while($row = $g->fetch_assoc()) {
    echo "id: " . $row["idDeposits"]. " - Name: " . $row["toAccount"]. " " . $row["toAccountID"]. " " . $row["SourceName"] . "<br>";
  */ 
?>-->
</html>