<?php

//returns single piece of data from the given database for the selected column. Use only for extracting unique data. 
function grabInfo($name, $db, $select) {
    $query= "SELECT " .$select. " FROM mydb.accounts WHERE accountName= '" .$name. "' ";
    $result= mysqli_query($db, $query);
    //check query execution
    if (!$result) {
        //add given accounts to the accounts table
        die("Database query failed.");
    } 
    $row= mysqli_fetch_row($result);
    return $row[0];
}

//changes the balance recorded in to and from accounts when a transaction is made.
function changeBals($toAcc, $fromAcc, $amt , $db) {
    //assign new balances
    $newBalTo= grabInfo($toAcc, $db,'accountBal') + $amt;
    $newBalFrom= grabInfo($fromAcc, $db, 'accountBal') - $amt;
    //Update current balances 
    $queryTo= "UPDATE mydb.accounts SET accountBal=" .$newBalTo. " WHERE accountName= '" .$toAcc. "' ";
    $queryFrom= "UPDATE mydb.accounts SET accountBal= " .$newBalFrom. " WHERE accountName= '" .$fromAcc. "'";
    $resultTo= mysqli_query($db, $queryTo);
    $resultFrom= mysqli_query($db, $queryFrom);
    //return error message if needed
    if (!$resultTo || !$resultFrom) {
        die("An error occured in updating account balance. Please try again.");
    } 
}
?>