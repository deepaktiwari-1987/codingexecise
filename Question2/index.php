<?php /* 
    Document   : index
    Created on : 29 Jan, 2015, 10:05:59 AM
    Author     : Deepak Tiwari
    Description:
        1. Create a HTML table having each Company’s year and month in which the share price was highest.
        2. Echo the company having highest total share price in average and in total.
*/


?>

<html>
    <head>
        <link type="text/css" href="css/style.css" />
    </head>
    <body>
        <table width="80%">
<?php
        //error_reporting(0);
        
        //Read the Company Share File
        $file = fopen("companyshare.csv","r") or die("File doest'nt Exist");
        $fileHeader = fgetcsv($file); //Get the Header of File
        $invalidFileMsg = 'Opps File is Empty or not valid data in file.';
        if(!empty($fileHeader))  //Process Records if file is not empty or valid file
        {
            $headerCount=count($fileHeader);    //Count number of Columns in Header
            $highestShareDetail = array(); //Highest Share detail month in year basis
            $highestSharePrice = array(); //Highest Share Price detail of Comany
            while($shareDetail = fgetcsv($file)) 
            {
                if($headerCount == count($shareDetail)) //If header and given detail for company is same then consider the data otherwise skip
                {
                    $shareData=array();
                    for($i=2;$i<$headerCount;$i++)
                    {
                        $companyDetailIndex=$fileHeader[$i].'|'.$shareDetail[0];//.'|'.$shareDetail[1];
                        $shareData['SharePrice']=$shareDetail[$i];
                        $shareData['CompanyName'] = $fileHeader[$i];
                        $shareData['Month'] = $shareDetail[1];
                        $shareData['Year'] = $shareDetail[0];
                        if((isset($highestShareDetail[$companyDetailIndex]) && $highestShareDetail[$companyDetailIndex]['SharePrice']<$shareDetail[$i]) || !isset($highestShareDetail[$companyDetailIndex]))
                        {
                                $highestShareDetail[$companyDetailIndex]=$shareData;
                        }
                        
                        /* Calculate Total number of months and Total Amount of share per company */
                        $highestSharePrice[$fileHeader[$i]]['TotalMonth'] =@$highestSharePrice[$fileHeader[$i]]['TotalMonth'] +  1;
                        $highestSharePrice[$fileHeader[$i]]['TotalAmount'] =@$highestSharePrice[$fileHeader[$i]]['TotalAmount']+$shareDetail[$i];
                        /* EOC Calculate Total number of months and Total Amount of share per company */
                    }
                    
                }
            }
            /* Calculate Company Name which has highest (average) amount of share */
            $highestSharePriceCompanyDetail = array();
            foreach($highestSharePrice as $companyName=>$shareData)
            {
                if(@$highestSharePriceCompanyDetail['TotalAmount']<$shareData['TotalAmount'])
                {
                    $highestSharePriceCompanyDetail['TotalAmount'] = $shareData['TotalAmount'];
                    $highestSharePriceCompanyDetail['CompanyName'] = $companyName;
                }
                if(($shareData['TotalAmount']/$shareData['TotalMonth'])>@$highestSharePriceCompanyDetail['AverageTotalAmount'])
                {
                    $highestSharePriceCompanyDetail['AverageTotalAmount'] = $shareData['TotalAmount']/$shareData['TotalMonth'];
                    $highestSharePriceCompanyDetail['AverageCompanyName'] = $companyName;
                }
            }
            /*EOC  Calculate Company Name which has highest (average) amount of share */
           //echo "<pre>";print_r($highestSharePriceCompanyDetail);die;
            if(!empty($highestShareDetail))
            {
?>
            <tr>
                <th colspan="4">Company Highest Share Price Year Month Basis</th>
            </tr>
            <tr>
                <th>Company</th>
                <th>Year</th>
                <th>Month</th>
                <th>Share Price</th>
            </tr>
<?php
                foreach($highestShareDetail as $shareRecord)
                {
?>
                   <tr>
                    <td align="center"><?php echo $shareRecord['CompanyName']; ?></td>
                    <td align="center"><?php echo $shareRecord['Year']; ?></td>
                    <td align="center"><?php echo $shareRecord['Month']; ?></td>
                    <td align="center"><?php echo $shareRecord['SharePrice']; ?></td>
                   </tr>
<?php            

                }
                
?>
                   <tr>
                       <th colspan="3"><?php echo $highestSharePriceCompanyDetail['CompanyName']." Having Highest Share Amount of ".$highestSharePriceCompanyDetail['TotalAmount']; ?></th>
                       <th><?php echo $highestSharePriceCompanyDetail['AverageCompanyName']." Having Highest Average Share Amount of ".$highestSharePriceCompanyDetail['AverageTotalAmount']; ?></th>
                   </tr>
<?php                   
            }
            else
            {
?>
            <tr>
                 <th class="error"><?php echo $invalidFileMsg; ?></th>
            </tr>
<?php           
            }
        }
        else
        {
?>
             <tr>
                 <th class="error"><?php echo $invalidFileMsg; ?></th>
            </tr>
<?php            
        }
?> 
            
        </table>
    </body>
</html>