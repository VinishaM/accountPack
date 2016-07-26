<!DOCTYPE html>
<html>
    <head>
        <title>Homepage</title>
        <meta charset= "utf-8"/>
        
        <!--custom CSS-->
        <link rel="stylesheet" href="styles/main.css" type="text/css">
        <!--google fonts-->
        <link href='https://fonts.googleapis.com/css?family=Architects+Daughter|Raleway|Oswald' rel='stylesheet' type='text/css'>
        <!--fancybox CSS-->
        <!--fancybox CSS-->
        <link rel="stylesheet" href="js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
        <link rel="stylesheet" href="js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
        <link rel="stylesheet" href="js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
    </head>
    <body>
        <!--form to add an account-->
        <div class="formHolder" id="accForm" hidden>
            <h1>Add an Account</h1>
            <form method="post">  
                Account Name: 
                <input class="feedback-input" type="text" name="formName" required/><br>
                Account Number: 
                <input class="feedback-input" type="number" name="formNum" required/><br>
                Initial Balance: 
                <input class="feedback-input" type="number" name="formBal" required/><br>
                Account Type:
                <input class="feedback-input" list="accType" name="formType" autocomplete="on" required/>
                <datalist class="feedback-input" id="accType">
                    <?php 
                    //Connect to database
                    $server =mysqli_connect('localhost','root','password', 'mydb');
                    //check connection
                    if (mysqli_connect_errno()) {
                        die("Connection failed. The following error message was recieved: " . mysqli_connect_error() ." Please try again.");
                    }
                        
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
                    } 
                    ?>
                </datalist><br>
                <input id='submit' type="submit" name="submit" value="Submit">
            </form>
        </div>
        <!--form to add a record-->
        <div class="formHolder" id="transForm" hidden>
            <h1>Add a Transaction</h1>
            <form action="transRecord.php" method="post">  
                Date of Transaction:
                <input class="feedback-input" id="dateEntry" type="date" maxlength="10" name="formDate" required/><br>
                Please use "MM/DD/YYYY" example: 01/21/2016<br>
                Type of Transaction: 
                <select class="feedback-input" name="formType">
                    <option value="1">Purchase</option>
                    <option value="2">Deposit</option>
                    <option value="3">Loan or Transfer</option>
                    <option value="4">Rebate</option>
                </select><br>
                Amount: 
                <input class="feedback-input" id="amountEntry" type="number" name="formAmount" required/><br>
                Please enter a purely numeric value with no dollar signs, periods, or commas.<br>
                <div id="switchq1">
                    <span>Bought at:</span>
                    <select class="feedback-input" name="formToAcc" required>
                        <?php 
                        //Connect to database
                        $server = mysqli_connect('localhost','root','password', 'mydb');
                        //check connection
                        if (mysqli_connect_errno()) {
                            die("Connection failed. The following error message was recieved: " . mysqli_connect_error() ." Please try again.");
                        }

                        //create array of all account names
                        $query="SELECT accountName FROM mydb.accounts ORDER BY accountName";
                        $result= mysqli_query($server, $query);
                        while ($row= mysqli_fetch_array($result)) {
                            echo "<option value=" .$row[0]. "> " .$row[0]. "</option>";
                        } 
                        ?>
                    </select>
                </div>
                <div id="switchq2">
                    <span>Paid to Account:</span>
                    <select class="feedback-input" name="formFromAcc" required>  
                        <?php 
                        $result = mysqli_query($server, $query);
                        while ($row= mysqli_fetch_array($result)) {
                            echo "<option value=" .$row[0]. "> " .$row[0]. "</option>";
                        } 
                        ?>
                    </select>
                </div> 
                Details: <br> 
                <textarea class="feedback-input" name="formDetail" coulmns="30" rows="5"></textarea><br>
                <input type="submit" name="submit2" value="Submit"/>
            </form>
        </div>
        
        <!--visible content-->
        <div id="content">
            <!--navigation bar-->
            <ul>
                <div id="account" class='grid' id='fancyAccForm'>
                    <a class='fancybox' href='#accForm'>Add a Bank Account</a>
                </div>
                <div id="trans" class='grid' id='fancyTransForm'>
                    <a class='fancybox' href='#transForm'>Add a Transaction </a>
                </div>
            </ul>
            
            <div class='resuts'>
                <?php
                //If record form was submitted, process and display success message
                if (isset($_POST['submit'])) {
                    if (empty(trim($_POST['formName'])) | empty(trim($_POST['formNum'])) | empty(trim($_POST['formType'])) | empty(trim($_POST['formBal']))) {
                            $message = "<p class=result'>All fields must be filled to submit a form</p>";
                        } else { 
                             //Assign $_POST values, using real_escape on string inputs in case they contain apostropies.
                            $faccName= htmlentities(trim($server,$_POST['formName']));
                            $faccNum= htmlentities(trim($_POST['formNum']));
                            $faccType= htmlentities(trim($server,$_POST['formType']));
                            $faccBal= htmlentities(trim($_POST['formBal']));
                        
                            $array= array($faccName, $faccNum, $faccType, $faccBal);

                             //test inputs
                             $error='';
                            $legalNames = "/^[a-zA-Z0-9 '.-]+$/";
                            $legalNums = "/^[0-9]*$/";
                            if (!preg_match($legalNames,$faccName)) {
                                $error .= "Names cannot contain characters other than letters, numbers, apostrophies and dashes. ";
                            } 
                            if (!preg_match($legalNames, $faccType)){
                                $error .= "Type identifier cannot contain characters other than letters, numbers, apostrophies and dashes. ";
                            }
                            if (!preg_match($legalNums, $faccNum)) {
                                $error .=  "Account number must contain only digits, no dollar signs, periods, or commas. ";
                            } 
                            if (!preg_match($faccBal)) {
                                 $error .=  "Balance must contain only digits, no dollar signs, periods, or commas. ";
                            } 
                            
                             //if no error, add album, else print error
                             if ($error=='') {
                                //connect to database mydb
                                $server =mysqli_connect('localhost','root','password', 'mydb');
                                 
                                //make sure name is unique 
                                $query= "SELECT accountNum FROM mydb.accounts WHERE accountName='$faccName'";
                                $check= mysqli_query($server, $query); 
                                
                                if (!$check) {
                                     //Add entry to accounts table
                                    $query= "INSERT INTO mydb.accounts(accountName, accountType, accountBal, accountNum) VALUES( '$faccName' , '$faccType' , '$faccBal', '$faccNum')";
                                    $t= mysqli_query($server, $query); 

                                    //render message based on success/fail
                                    if ($t) {
                                        $message = "Entry recorded successfully.";
                                    } else { 
                                        $message= "There was an error in recording your transaction. Please try again.";
                                    }     
                                    
                                } else {
                                    $message = "This account name already exists. Please choose a unique name. ";
                                }
                             } else {
                                $message = $error;
                             }
                        }    
                    }

                    //If account form was submitted, process and display success message
                    elseif (isset($_POST['submit2'])) {
                       if (empty(trim($_POST['formName'])) | empty(trim($_POST['formNum'])) | empty(trim($_POST['formType'])) | empty(trim($_POST['formBal']))) {
                            $message = "<p class=result'>All fields must be filled to submit a form</p>";
                        } else {   
                        
                    } 
                        
                    //else print nothing
                    else {
                        $message="";
                    }
                
                    //display the message
                    echo $message;
                ?> 
            </div>
        <!--FIX ERROR 
        <div id="list">
            <h2>All Transactions</h2>
            <table>
                <tr>
                    <th>From</th>
                    <th>To</th>		
                    <th>Account Balance</th>
                    <th>Date</th>
                </tr>-->
                <!--?php 
                    $query="SELECT accountName FROM mydb.accounts ORDER BY accountName";
                    $result= mysqli_query($server, $query);
                    while ($row= mysqli_fetch_array($result)) {
                        echo "<option value=" .$row[0]. "> " .$row[0]. "</option>";
                        echo "<tr class='store'> 
                            <td> ". $name . " </td>
                            <td> ". $address . " </td>
                            <td> ". $rating . " </td>
                            <td> ". $type . " </td>
                            </tr> ";
                ?
            </table>
        </div>-->
        </div>
    </body> 
    
    <!--jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!--fancybox-->
     <script type="text/javascript" src="js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

    <!-- Optionally add helpers - button, thumbnail and/or media -->
    <script type="text/javascript" src="js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
    <script type="text/javascript" src="js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
    <script type="text/javascript" src="js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
    
    <script type="text/javascript">
        //Set default current date in the date section of the form
        
        $(document).ready(function(){
            $(".fancybox").fancybox({
                openEffect  : 'none',
                closeEffect : 'none',
                iframe : {
                preload: false
                }
            });
            $(".various").fancybox({
                maxWidth    : 800,
                maxHeight    : 600,
                fitToView    : false,
                width        : '80%',
                height        : '80%',
                autoSize    : false,
                closeClick    : false,
                openEffect    : 'none',
                closeEffect    : 'none'
            });
            $('.fancybox-media').fancybox({
                openEffect  : 'none',
                closeEffect : 'none',
                helpers : {
                media : {}
                }
            });
        });

        
     /*$("#account").click( function() {
            $(".overlay").fadeIn();
            $("#accForm").fadeIn();

            $(".close").click( function() {
                $(".overlay").fadeOut();
                $("#accForm").fadeOut();
            });
        });
        
      $("#trans").click( function() {
        $(".overlay").fadeIn();
        $("#transForm").fadeIn();
        
        $(".close").click( function() {
            $(".overlay").fadeOut();
            $("#transForm").fadeOut();
        });
        */
        $(document).ready( function() {
            var getDate= new Date();
            var month= getDate.getMonth() + 1;
            if (month < 10) month= "0" + month;
            
            var day= getDate.getDate();
            if (day < 10) day= "0" + day;
            
            var year= getDate.getFullYear();
           $("#dateEsntry").val(year + "-" + month + "-" + day);  
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