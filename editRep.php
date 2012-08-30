<?php
include('includes/header.php');
?>

<script type="text/javascript">
function confirmDelete()
{
  return confirm("Are you sure you want to delete this Rep?");
}
</script>

<?php
if ($addRep)
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
  if (!$rn)
  {
    $message .= "<p>Please enter Rep Number!";
  }
  if ($fn && $ln && rn)
  {
    include('includes/mysqlconnect.php');
    $addQuery = "INSERT INTO brokers (repNumber,firstName,lastName) VALUES ('$rn','$fn','$ln')";
    $addResult = @mysql_query($addQuery);
    if ($addResult)
    {
      echo "<h3>Rep Added</h3>";
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
$query = "SELECT repNumber, firstName, lastName FROM brokers ORDER BY lastName ASC";
$result = @mysql_query($query);
if ($result)
{
  echo "<form method=get name=\"editrep\" action=\"$PHP_SELF\">";
  echo "<table><tr><td>";
  echo "<select name=\"rep\">";
  while($row = mysql_fetch_array($result, MYSQL_NUM))
  {
    $firstName = $row[0];
    echo "<option value=\"$row[0]\">$row[2], $row[1] - $row[0]</option>";
  }
  echo "</select></td>";
  //echo "<td><input type=submit name=\"editRep\" value=\"Edit Rep\"></td>";
  echo "<td><input type=submit name=\"delRep\" value=\"Delete Rep\" onclick=\"return confirmDelete()\"></td></tr></table></form>";
}
if ($delRep)
{
  include('includes/mysqlconnect.php');
  $delQuery = "DELETE FROM brokers WHERE repNumber='$rep'";
  $delResult = @mysql_query($delQuery);
  if ($delResult)
  {
    echo "<h3>Rep has been Deleted.</h3>";
  }
  else
  {
    echo "<h3>Database Error.</h3>";
  }
}
if ($editRep)
{
  echo "<form method=get name=\"updaterep\" action=\"$PHP_SELF\"><table>
  <tr><td>Firstname:</td><td><input type=\"text\" name=\"ufn\"></td></tr>
   <tr><td>Lastname:</td><td><input type=\"text\" name=\"uln\"></td></tr>
   <tr><td>Rep#:</td><td><input type=\"text\" name=\"urn\" value=\"$rep\"></td></tr>
   <tr><td><input type=submit name=\"updateRep\" value=\"Update Rep\"></td>
  </tr></table></form>";
}
if ($updateRep)
{
  if (!$ufn)
  {
    $message2 .= "<h3>Please enter Firstname.</h3>";
  }
  if (!$uln)
  {
    $message2 .= "<h3>Please enter Lastname.</h3>";
  }
  if (!$urn)
  {
    $message2 .= "<h3>Please enter Rep Number.</h3>";
  }
  if ($ufn && $uln && $urn)
  {
    include ('includes/mysqlconnect.php');
    $editQuery = "UPDATE brokers SET firstName='$ufn',lastName='$uln',repNumber='$urn' WHERE repNumber='$urn'";
    $editResult = @mysql_query($editQuery);
    if ($editResult)
    {
      echo "<h3>Rep has been updated.</h3>";
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
      $message2 .= "<h3>Please click Edit Rep to try again.</h3>";
      echo $message2;
    }
  }
}
?>

<!-- BEGIN HTML -->
<form method=get name="addRep" action="<?php echo $PHP_SELF; ?>"> 
<table>
  <tr>
    <td>Firstname:</td><td><input type="text" name="fn"></td></tr>
    <tr><td>Lastname:</td><td><input type="text" name="ln"></td></tr>
    <tr><td>Rep#:</td><td><input type="text" name="rn"></td></tr>
    <tr><td><input type=submit name="addRep" value="Add Rep"></td>
  </tr>
</table>
</form>
<!-- END HTML -->

<?php
include('includes/footer.php');
?>


