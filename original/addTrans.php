<!DOCTYPE html>
<html>
    <head>
        <title>Add Transactions</title>
        <meta charset= "utf-8"/>
        
        <link rel="stylesheet" href="css/main3.css" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Architects+Daughter|Raleway|Oswald' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <h1>Add a Transaction</h1>
        <div id="form1">
            <form action="transRecord.php" method="post" >  
                Date of Transaction:
                <input id="dateEntry" type="date" maxlength="10" name="formDate" required/></br>
                Please use "MM/DD/YYYY" example: 01/21/2016</br>
                Type of Transaction: 
                <select name="formType">
                    <option value="1">Purchase</option>
                    <option value="2">Deposit</option>
                    <option value="3">Loan or Transfer</option>
                    <option value="4">Rebate</option>
                </select></br>
                Amount: 
                <input id="amountEntry" type="number" name="formAmount" required/></br>
                Please enter a purely numeric value with no dollar signs, periods, or commas.
                <div id="switchq1">
                    <span>Bought at:</span>
                    <select name="formToAcc" required>
                        <?php 
                        //Connect to database
                        $server =mysqli_connect('localhost','root','password', 'mydb');
                        //check connection
                        if (mysqli_connect_errno()) {
                            die("Connection failed. The following error message was recieved: " . mysqli_connect_error() ." Please try again.");
                        }
                        
                        //create array of all account names
                        $query="SELECT accountName FROM mydb.accounts ORDER BY accountName";
                        $result= mysqli_query($server, $query);
                        while ($row= mysqli_fetch_array($result)) {
                            echo "<option value=" .$row[0]. "> " .$row[0]. "</option>";
                        } ?>
                    </select>
                </div>
                <div id="switchq2">
                    <span>Paid to Account:</span>
                    <select name="formFromAcc" required>  
                        <?php 
                        $result= mysqli_query($server, $query);
                        while ($row= mysqli_fetch_array($result)) {
                            echo "<option value=" .$row[0]. "> " .$row[0]. "</option>";
                        } ?>
                    </select>
                </div>
                Details: </br> 
                <textarea name="formDetail" coulmns="30" rows="5"></textarea></br>
                <input type="submit" name="submit" value="Submit">
            </form>
        </div>
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
    </script>
    <script>
        //Set default current date in the date section of the form
        $(document).ready( function() {
            var getDate= new Date();
            var month= getDate.getMonth() + 1;
            if (month < 10) month= "0" + month;
            
            var day= getDate.getDate();
            if (day < 10) day= "0" + day;
            
            var year= getDate.getFullYear();
           $("#dateEntry").val(year + "-" + month + "-" + day);  
        });
        
        //Change text of certain questions based on transaction Type
        $("select").on("change", function()  {
            if ($("select").val()=="1") {
                $("#switchq2 span").text("Paid from Account:");
                $("#switchq1 span").text("Bought at:");
            }
            if ($("select").val()=="2") {
                $("#switchq2 span").text("Source:");
                $("#switchq1 span").text("Deposited to Account:");
            }
            if ($("select").val()=="3") {
                $("#switchq2 span").text("Transferred or Borrowed from:");
                $("#switchq1 span").text("Transferred to Account:");
            }
            if ($("select").val()=="4") {
                $("#switchq2 span").text("From:");
                $("#switchq1 span").text("Paid to Account:");
            }
        });
    </script>
</html>