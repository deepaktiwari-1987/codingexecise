<?php

/*
  Document   : index
  Created on : 29 Jan, 2015, 10:05:59 AM
  Author     : Deepak Tiwari
  Description:
  1. Write a program to check that the the input string 2 is the anagram of input string 1.
 */

/*
 Author : Deepak Tiwari 
 Created On : 29 Jan 2015 
 @params : string,string
 Description : get input string and an anagram string and return whether string is anagram or not
 Return : String
 */
function checkAnagram($inputStr, $anagram) {
    //$inputStr = 'Upshot Tech';
    //$anagram = 'Hutches Top';
    $errorMsg = 'Not an anagram string';
    $successMsg = "'$anagram' is anagram of '$inputStr'";
    if (strlen($inputStr) < strlen($anagram)) {
        return $errorMsg;
    }
    $inputStringAvaiArr = array();
    for ($i = 0; $i < strlen($inputStr); $i++) {
        $index=  strtolower($inputStr[$i]);
        $inputStringAvaiArr[$index] = @$inputStringAvaiArr[$index] + 1;
    }
    for ($i = 0; $i < strlen($anagram); $i++) {
        $index=  strtolower($anagram[$i]);
        if (!isset($inputStringAvaiArr[$index]) || $inputStringAvaiArr[$index] <= 0) {
            return $errorMsg;
        } else {
            $inputStringAvaiArr[$index] -=1;
        }
    }
    return $successMsg;
}

//Check Whether form is post or not
if(isset($_POST['anagramstr']))
{
    $anagramMsg=checkAnagram($_POST['inputstr'],$_POST['anagramstr']);
}
?>

<html>
    <head>
        <script type="text/javascript">
            
            /* Validate the form */
            function validate()
            {
                if(document.getElementById('inputstr').value=='')
                {
                    alert("Please enter input string");
                    document.getElementById('inputstr').focus();
                    return false;
                }
                if(document.getElementById('anagramstr').value=='')
                {
                    alert("Please enter anagram string");
                    document.getElementById('anagramstr').focus();
                    return false;
                }
                
            }
            /*EOC  Validate the form */
        </script>
    </head>
    <body>
        <form name="anagram" onsubmit="return validate();" method="post">
        <table width="60%">
            <tr>
                <th>Input String </th>
                <td><input type="text" name="inputstr" id="inputstr"></td>
            </tr>
            <tr>
                <th>Anagram</th>
                <td><input type="text" name="anagramstr" id="anagramstr"></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" name="anagramsubmit" value="Check Anagram"></td>
            </tr>
            <?php if(!empty($anagramMsg)) { ?>
            <tr>
                <th colspan="2" style="color:#FF0000;font-weight: bold;"><?php echo $anagramMsg; ?></th>
            </tr>
            <?php } ?>
        </table>
        </form>
    </body>
</html>