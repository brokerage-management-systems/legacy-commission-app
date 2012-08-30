<?php
include("includes/header.php");
include("includes/mysql_connect.php");

echo "<p>Rep Status</p>";
?>
<form name=edit action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<fieldset><legend>Edit Rep</legend>
<table border="1" bgcolor="FFFFFF">
  <tr>
    <td>

<?php
echo "<select name=\"rep\"><option value=\"\"></option>";

$repQuery = "SELECT * FROM brokers";
$repResult = @mysql_query($repQuery);
if($repResult)
{
  while($repRow = @mysql_fetch_array($repResult))
  {
    $rn = $repRow[0];
    $fn = $repRow[1];
    $ln = $repRow[2];
    $st = $repRow[3];
    echo "<option value=\"$rn\">$ln, $fn - $rn</option>";
  }
}
else echo "<option value=\"\">No Values Returned</option";
echo "</select></td>";
echo "<td><input type=\"submit\" name=\"edit\" value=\"Edit\" /></td></fieldset></form>";
echo "</tr></table>";

include("includes/footer.php");
?>
