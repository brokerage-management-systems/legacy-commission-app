<?php
include('includes/header2.php');

$message2 = NULL;
include('includes/mysqlconnect.php');
$repNum;
$todaydate;
$begindate;
$enddate;

$todaydate = $_GET['todaydate'];
$begindate = $_GET['begindate'];
$enddate = $_GET['enddate'];

?>

<table width="100%" bordercolor="black"><tr><td colspan="15" bgcolor="#000000"><font color="white"></td></tr>
<tr><td colspan="3">Commission Period Beginning: </td><td><?php echo "$begindate"; ?></td><td>Ending: </td><td><?php echo "$enddate"; ?></td></tr>
<tr><td colspan="3">Todays Data: </td><td><?php echo "$todaydate"; ?></td></tr></table>
<table border="1" bordercolor="black"><tr bgcolor="black">
<td colspan="2"><font color="white">Broker Name</td>
<td><font color="white">REP#</td>
<td><font color="white">NFS</td>
<td><font color="white">NFD MTD</td>
<td><font color="white">PEN DAILY</td>
<td><font color="white">PEN MTD</td>
<td><font color="white">TRADING</td>
<td><font color="white">MTD TOTAL</td>
<td><font color="white">$$RAISED$$</td>
<td><font color="white">MTD</td>
<td><font color="white">N/A</td>
<td><font color="white">MTD</td>
<td><font color="white">RE</td>
<td><font color="white">MTD</td></font></tr>

<?php

$query[0] = "USE commission";
$query[1] = "CREATE TEMPORARY TABLE mtd(firstName VARCHAR( 15 ) ,lastName VARCHAR( 20 ), repNumber VARCHAR( 10 ),grossDate DATE,nfsdgross DOUBLE,nfsmgross DOUBLE,pendgross DOUBLE,penmgross DOUBLE,tradegross DOUBLE,mrdgross DOUBLE,mrmgross DOUBLE,nad INT( 11 ) ,nam INT( 11 ) ,red INT( 11 ) ,rem INT( 11 ))";
$query[2] = "INSERT INTO mtd (repNumber, firstName, lastName)
    SELECT repNumber, firstName, lastName
    FROM brokers";
$result[0] = @mysql_query($query[0]);
$result[1] = @mysql_query($query[1]);
$result[2] = @mysql_query($query[2]);
if ($result[0] && $result[1] && $result[2])
{

  #Rep Number Loop
  $loopquery = "select repNumber from brokers";
  $loopresult = @mysql_query($loopquery);
  if ($loopresult)
  {
    while($row = mysql_fetch_array($loopresult, MYSQL_NUM))
    {
		$repNum = $row[0];

		$query[3] = "UPDATE mtd SET grossDate='$todaydate', nfsdgross=(
			SELECT gross FROM nfsGross WHERE repNumber='$repNum' AND grossDate='$todaydate') WHERE mtd.repNumber='$repNum'";
		$query[4] = "UPDATE mtd SET nfsmgross=(SELECT SUM(gross )
    		FROM nfsGross
    		WHERE repNumber='$repNum' AND grossDate BETWEEN '$begindate' AND '$enddate'
    		GROUP BY repNumber) WHERE mtd.repNumber='$repNum'";
		$query[5] = "UPDATE mtd SET pendgross=(
			SELECT gross FROM pensonGross WHERE repNumber='$repNum' AND grossDate='$todaydate') WHERE mtd.repNumber='$repNum'";
		$query[6] = "UPDATE mtd SET penmgross=(SELECT SUM(gross )
			FROM pensonGross
			WHERE repNumber='$repNum' AND grossDate BETWEEN '$begindate' AND '$enddate'
			GROUP BY repNumber) WHERE mtd.repNumber='$repNum'";
		$query[7] = "UPDATE mtd SET tradegross=(
			SELECT gross FROM tradingGross WHERE repNumber='$repNum' AND grossDate='$todaydate') WHERE mtd.repNumber='$repNum'";
		$query[8] = "UPDATE mtd SET mrdgross=(
			SELECT gross FROM moneyRaised WHERE repNumber='$repNum' AND grossDate='$todaydate') WHERE mtd.repNumber='$repNum'";
		$query[9] = "UPDATE mtd SET mrmgross=(SELECT SUM(gross )
			FROM moneyRaised
			WHERE repNumber='$repNum' AND grossDate BETWEEN '$begindate' AND '$enddate'
			GROUP BY repNumber) WHERE mtd.repNumber='$repNum'";
		$query[10] = "UPDATE mtd SET nad=(
			SELECT newacct FROM newAccts WHERE repNumber='$repNum' AND grossDate='$todaydate') WHERE mtd.repNumber='$repNum'";
		$query[11] = "UPDATE mtd SET nam=(SELECT SUM(newacct)
    		FROM newAccts
    		WHERE repNumber='$repNum' AND grossDate BETWEEN '$begindate' AND '$enddate'
    		GROUP BY repNumber) WHERE mtd.repNumber='$repNum'";
		$query[12] = "UPDATE mtd SET red=(
			SELECT reneg FROM newAccts WHERE repNumber='$repNum' AND grossDate='$todaydate') WHERE mtd.repNumber='$repNum'";
		$query[13] = "UPDATE mtd SET rem=(
			SELECT SUM(reneg)
			FROM newAccts
			WHERE repNumber='$repNum' AND grossDate BETWEEN '$begindate' AND '$enddate'
			GROUP BY repNumber) WHERE mtd.repNumber='$repNum'";

			 
		$result[3] = @mysql_query($query[3]);
		$result[4] = @mysql_query($query[4]);
		$result[5] = @mysql_query($query[5]);
		$result[6] = @mysql_query($query[6]);
		$result[7] = @mysql_query($query[7]);
		$result[8] = @mysql_query($query[8]);
		$result[9] = @mysql_query($query[9]);
		$result[10] = @mysql_query($query[10]);
		$result[11] = @mysql_query($query[11]);
		$result[12] = @mysql_query($query[12]);
		$result[13] = @mysql_query($query[13]);

	# Rep Number Loop
	}
  }

  $query[14] = "SELECT * FROM mtd";
  $result[14] = @mysql_query($query[14]);
  if ($result[14])
  {
    while($row = mysql_fetch_array($result[14], MYSQL_NUM))
	{
	  $total = $row[5] + $row[7] + $row[8]; //MTD Totals
	  echo "<tr><td>$row[0]</td>
		<td>$row[1]</td>
		<td>$row[2]</td>
		<td align=\"right\">\$$row[4]</td>
		<td align=\"right\">\$$row[5]</td>
		<td align=\"right\">\$$row[6]</td>
		<td align=\"right\">\$$row[7]</td>
		<td align=\"right\">\$$row[8]</td>
		<td align=\"right\">\$$total</td>
		<td align=\"right\">\$$row[9]</td>
		<td align=\"right\">\$$row[10]</td>
		<td align=\"center\">$row[11]</td>
		<td align=\"center\">$row[12]</td>
		<td align=\"center\">$row[13]</td>
		<td align=\"center\">$row[14]</td></tr>";
	}
  }
}

#Firm running totals

$nfsd;
$nfsm;
$pend;
$penm;

# NFS
$nfsdtotalquery = "SELECT SUM(gross) FROM nfsGross WHERE grossDate='$todaydate'";
$nfsdtotalresult = @mysql_query($nfsdtotalquery);
if ($nfsdtotalresult)
{
  echo "<tr bgcolor=\"black\"><td colspan=\"3\"><font color=\"white\">Monthly Running Firm Totals:";
  while($row = mysql_fetch_array($nfsdtotalresult, MYSQL_NUM))
  {
    $nfsd = $row[0];
    echo "<td align=\"right\"><font color=\"white\">\$$row[0]</td>";
  }
  $nfsmtotalquery = "SELECT SUM(gross) FROM nfsGross WHERE grossDate BETWEEN '$begindate' AND '$enddate'";
  $nfsmtotalresult = @mysql_query($nfsmtotalquery);
  if ($nfsmtotalresult)
  {
    while($row = mysql_fetch_array($nfsmtotalresult, MYSQL_NUM))
    {
	  $nfsm = $row[0];
      echo "<td align=\"right\"><font color=\"white\">\$$row[0]</td>";
    }
  }
}

$pendtotalquery = "SELECT SUM(gross) FROM pensonGross WHERE grossDate='$todaydate'";
$pendtotalresult = @mysql_query($pendtotalquery);
if ($pendtotalresult)
{
  while($row = mysql_fetch_array($pendtotalresult, MYSQL_NUM))
  {
    $pend = $row[0];
    echo "<td align=\"right\"><font color=\"white\">\$$row[0]</td>";
  }
  $penmtotalquery = "SELECT SUM(gross) FROM pensonGross WHERE grossDate BETWEEN '$begindate' AND '$enddate'";
  $penmtotalresult = @mysql_query($penmtotalquery);
  if ($penmtotalresult)
  {
    while($row = mysql_fetch_array($penmtotalresult, MYSQL_NUM))
    {
	  $penm = $row[0];
      echo "<td align=\"right\"><font color=\"white\">\$$row[0]</td>";
    }
  }
}

$tradedtotalquery = "SELECT SUM(gross) FROM tradingGross WHERE grossDate='$todaydate'";
$tradedtotalresult = @mysql_query($tradedtotalquery);
if ($tradedtotalresult)
{
  while($row = mysql_fetch_array($tradedtotalresult, MYSQL_NUM))
  {
    echo "<td align=\"right\"><font color=\"white\">\$$row[0]</td>";
  }
}

echo "<td></td>";

$mondtotalquery = "SELECT SUM(gross) FROM moneyRaised WHERE grossDate='$todaydate'";
$mondtotalresult = @mysql_query($mondtotalquery);
if ($mondtotalresult)
{
  while($row = mysql_fetch_array($mondtotalresult, MYSQL_NUM))
  {
    echo "<td align=\"right\"><font color=\"white\">\$$row[0]</td>";
  }
  $monmtotalquery = "SELECT SUM(gross) FROM moneyRaised WHERE grossDate BETWEEN '$begindate' AND '$enddate'";
  $monmtotalresult = @mysql_query($monmtotalquery);
  if ($monmtotalresult)
  {
    while($row = mysql_fetch_array($monmtotalresult, MYSQL_NUM))
    {
      echo "<td align=\"right\"><font color=\"white\">\$$row[0]</td>";
    }
  }
}

$nadtotalquery = "SELECT SUM(newacct) FROM newAccts WHERE grossDate='$todaydate'";
$nadtotalresult = @mysql_query($nadtotalquery);
if ($nadtotalresult)
{
  while($row = mysql_fetch_array($nadtotalresult, MYSQL_NUM))
  {
    echo "<td align=\"center\"><font color=\"white\">$row[0]</td>";
  }
  $namtotalquery = "SELECT SUM(newacct) FROM newAccts WHERE grossDate BETWEEN '$begindate' AND '$enddate'";
  $namtotalresult = @mysql_query($namtotalquery);
  if ($namtotalresult)
  {
    while($row = mysql_fetch_array($namtotalresult, MYSQL_NUM))
    {
      echo "<td align=\"center\"><font color=\"white\">$row[0]</td>";
    }
  }
}

$redtotalquery = "SELECT SUM(reneg) FROM newAccts WHERE grossDate='$todaydate'";
$redtotalresult = @mysql_query($redtotalquery);
if ($redtotalresult)
{
  while($row = mysql_fetch_array($redtotalresult, MYSQL_NUM))
  {
    echo "<td align=\"center\"><font color=\"white\">$row[0]</td>";
  }
  $remtotalquery = "SELECT SUM(reneg) FROM newAccts WHERE grossDate BETWEEN '$begindate' AND '$enddate'";
  $remtotalresult = @mysql_query($remtotalquery);
  if ($remtotalresult)
  {
    while($row = mysql_fetch_array($remtotalresult, MYSQL_NUM))
    {
      echo "<td align=\"center\"><font color=\"white\">$row[0]</td>";
    }
  }
}

echo "</tr><tr bgcolor=\"black\">";

$totalwpend = $nfsd + $pend;
$totalwpenm = $nfsm + $penm;

echo "<td colspan=\"3\"><font color=\"white\">Firm total with Penson:</td>
	<td align=\"right\"><font color=\"white\">\$$totalwpend</td>
	<td align=\"right\"><font color=\"white\">\$$totalwpenm</td>
	<td></td>
	<td><font color=\"white\">PEN MTD</td>
	<td><font color=\"white\">TRADING</td>
	<td colspan=\"7\"></td></tr>";

?>

</table>

<?php
include('includes/footer2.php');
?>
