<?php
include('includes/header.php');
?>

<script type="text/javascript">
function confirmDelete()
{
  return confirm("Are you sure you want to delete this Client?");
}
</script>

<?php
if ($addClient)
{
  $message = NULL;
  if (!$fn)
  {
    $message .= "<p>Please enter First Name!";
  }
  if (!$ln)
  {
    $message .= "<p>Please enter Last Name!";
  }
  if (!$an)
  {
    $message .= "<p>Please enter Account Number!";
  }
  if ($fn && $ln && an)
  {
    include('includes/mysqlconnect.php');
    $addQuery = "INSERT INTO clientInfo (firstName,lastName,acctNum) VALUES ('$fn','$ln','$an')";
    $addResult = @mysql_query($addQuery);
    if ($addResult)
    {
      echo "<h3>Client Added</h3>";
    }
  }
  else
  {
    echo "<h3>$message</h3>";
  }
}
?>

<?php
$message2 = NULL;
include('includes/mysqlconnect.php');
$query = "SELECT lastName, firstName, acctNum FROM clientInfo";
$result = @mysql_query($query);
if ($result)
{
  echo "<form method=get name=\"editclient\" action=\"$PHP_SELF\">";
  echo "<table><tr><td>";
  echo "<select name=\"client\">";
  while($row = mysql_fetch_array($result, MYSQL_NUM))
  {
    $firstName = $row[0];
    echo "<option value=\"$row[2]\">$row[0], $row[1] - $row[2]</option>";
  }
  echo "</select></td>";
  echo "<td><input type=submit name=\"editClient\" value=\"Edit Client\"></td>";
  echo "<td><input type=submit name=\"delClient\" value=\"Delete Client\" onclick=\"return confirmDelete()\"></td></tr></table></form>";
}
if ($delClient)
{
  include('includes/mysqlconnect.php');
  $delQuery = "DELETE FROM clientInfo WHERE acctNum='$client'";
  $delResult = @mysql_query($delQuery);
  if ($delResult)
  {
    echo "<h3>Client has been Deleted.</h3>";
  }
  else
  {
    echo "<h3>Database Error.</h3>";
  }
}
if ($editClient)
{
  echo "<form method=get name=\"updateclient\" action=\"$PHP_SELF\"><table>
  <tr><td>Firstname:</td><td><input type=\"text\" name=\"ufn\"></td>
    <td>Lastname:</td><td><input type=\"text\" name=\"uln\"></td>
    <td>Acct#:</td><td><input type=\"text\" name=\"uan\" value=\"$client\"></td>
    <td><input type=submit name=\"updateClient\" value=\"Update Client\"></td>
  </tr></table></form>";
}
if ($updateClient)
{
  if (!$ufn)
  {
    $message2 .= "<h3>Please enter Firstname.</h3>";
  }
  if (!$uln)
  {
    $message2 .= "<h3>Please enter Lastname.</h3>";
  }
  if (!$uan)
  {
    $message2 .= "<h3>Please enter Account Number.</h3>";
  }
  if ($ufn && $uln && $uan)
  {
    include ('includes/mysqlconnect.php');
    $editQuery = "UPDATE clientInfo SET firstName='$ufn',lastName='$uln',acctNum='$uan' WHERE acctNum='$uan'";
    $editResult = @mysql_query($editQuery);
    if ($editResult)
    {
      echo "<h3>Client has been updated.</h3>";
    }
    else
    {
      echo "<h3>Database Error.</h3>";
    }
  }
  else
  {
    if ($message2)
    {
      $message2 .= "<h3>Please click Edit Client to try again.</h3>";
      echo $message2;
    }
  }
}
?>

<!-- BEGIN HTML -->
<form method=get name="addclient" action="<?php echo $PHP_SELF; ?>"> 
<table>
  <tr>
    <td>Firstname:</td><td><input type="text" name="fn"></td>
    <td>Lastname:</td><td><input type="text" name="ln"></td>
    <td>Acct#:</td><td><input type="text" name="an"></td>
    <td><input type=submit name="addClient" value="Add Client"></td>
  </tr>
</table>
</form>
<!-- END HTML -->

<?php
include('includes/footer.php');
?>


