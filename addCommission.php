<?php
include('includes/header.php');
?>

<script type="text/javascript">
function confirmAdd()
{
  return confirm("Are you sure you want to add these values?");
}
</script>

<?php
$message2 = NULL;
include('includes/mysqlconnect.php');
$query = "SELECT repNumber, firstName, lastName FROM brokers ORDER BY lastName ASC";
$result = @mysql_query($query);
if ($result)
{
	echo "<form method=get name=\"addcommission\" action=\"$PHP_SELF\">";
	echo "<table><tr><td>";
	echo "<select name=\"rep\">";
	while($row = mysql_fetch_array($result, MYSQL_NUM))
 		{
	   		$repNumber = $row[0];
    		echo "<option value=\"$row[0]\">$row[2], $row[1] - $row[0]</option>";
  		}
}
?>
    </select></td></tr>
    <tr><td>Gross Date:</td>
	<td><input name="grossDate" type="text" value="<?php if (isset($_POST['grossDate'])) echo $_POST['grossDate']; else echo date('Y-m-d');?>" /></td></tr>
    <tr><td>NFS Gross:</td>
    <td><input type="text" name="nfsGross"></td></tr>
    <tr><td>Penson Gross:</td>
    <td><input type="text" name="pensonGross"></td></tr>
    <tr><td>Trading Gross:</td>
    <td><input type="text" name="tradingGross"></td></tr>
    <tr><td>Money Raised:</td>
    <td><input type="text" name="moneyRaised"></td></tr>
    <tr><td>New Accounts:</td>
    <td><input type="text" name="na"></td>
    <td>Renegs:</td>
    <td><input type="text" name="re"></td></tr>
    <tr><td><input type="submit" name="submit" value="submit" onclick="return confirmAdd()"></td></tr>
</form>
</table>

<?php
if ($submit)
{
    //include ('includes/mysqlconnect.php');
	if($nfsGross)
	{
    $nfsQuery = "INSERT INTO nfsGross (grossDate,gross,repNumber) VALUES ('$grossDate','$nfsGross','$rep')";
	echo "<p>$nfsQuery</p>";
    $nfsResult = @mysql_query($nfsQuery);
    if ($nfsResult)
    {
      echo "<h3>NFS Gross has been updated.</h3>";
    }
    else
    {
      echo "<h3>NFS: Database Error.</h3>";
    }
	}
	
	if($pensonGross)
	{
	$pensonQuery = "INSERT INTO pensonGross (grossDate,gross,repNumber) VALUES ('$grossDate','$pensonGross','$rep')";
	echo "<p>$pensonQuery</p>";
    $pensonResult = @mysql_query($pensonQuery);
    if ($pensonResult)
    {
      echo "<h3>Penson Gross has been updated.</h3>";
    }
    else
    {
      echo "<h3>Penson: Database Error.</h3>";
    }
	}
	
	if($tradingGross)
	{	
	$tradingQuery = "INSERT INTO tradingGross (grossDate,gross,repNumber) VALUES ('$grossDate','$tradingGross','$rep')";
	echo "<p>$tradingQuery</p>";
    $tradingResult = @mysql_query($tradingQuery);
    if ($tradingResult)
    {
      echo "<h3>Trading Gross has been updated.</h3>";
    }
    else
    {
      echo "<h3>Trading: Database Error.</h3>";
    }
	}
	
	if($moneyRaised)
	{
	$moneyQuery = "INSERT INTO moneyRaised (grossDate,gross,repNumber) VALUES ('$grossDate','$moneyRaised','$rep')";
	echo "<p>$moneyQuery</p>";
    $moneyResult = @mysql_query($moneyQuery);
    if ($moneyResult)
    {
      echo "<h3>Money Raised has been updated.</h3>";
    }
    else
    {
      echo "<h3>MoneyRaised: Database Error.</h3>";
    }
	}
	
	if($na || $re)
	{
	$naQuery = "INSERT INTO newAccts (grossDate,newacct,reneg,repNumber) VALUES ('$grossDate','$na','$re','$rep')";
	echo "<p>$naQuery</p>";
    $naResult = @mysql_query($naQuery);
    if ($naResult)
    {
      echo "<h3>New Accounts has been updated.</h3>";
    }
    else
    {
      echo "<h3>NewAccts: Database Error.</h3>";
    }
	}
}
?>

<?php
include('includes/footer.php');
?>