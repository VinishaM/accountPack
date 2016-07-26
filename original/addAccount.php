<!DOCTYPE html>
<html>
    <head>
        <title>Add an Account</title>
        <meta charset= "utf-8"/>
        
        <link rel="stylesheet" href="css/main3.css" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Architects+Daughter|Raleway|Oswald' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <h1>Add an Account</h1>
        <div id="form1">
            <form action="accRecord.php" method="post" >  
                Account Name: 
                <input type="text" name="formName" required/></br>
                Account Number: 
                <input type="number" name="formNum" required/></br>
                Initial Balance: 
                <input type="number" name="formBal" required/></br>
                Please enter a purely numeric value with no dollar signs, periods, or commas.</br>
                Account Type:
                <input list="accType" name="formType" autocomplete="on" required>
                <datalist id="accType">
                    <?php 
                    //Connect to database
                    $server =mysqli_connect('localhost','root','password', 'mydb');
                    //create array of all account names
                    $query="SELECT accountType FROM mydb.accounts ORDER BY accountName";
                    $result= mysqli_query($server, $query);
                    $uniqueNames= array();
                    while ($row= mysqli_fetch_array($result)) {
                        $name= $row[0];
                        if (!in_array($name, $uniqueNames)) {
                            $uniqueNames[]= $name;
                            echo "<option value=" .$name. ">";
                        }
                    } ?>
                </datalist> 
</input></br>
                <input type="submit" name="submit" value="Submit">
            </form>
        </div>
    </body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</html>