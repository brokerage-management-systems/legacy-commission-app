<?php
include('includes/header.php');
?>

<script language="JavaScript" src="calendar2.js"></script>

<table><tr>
<form action="report01.php" method="get" name="commissiondate">
<td>Today Date: </td><td>
<input type="text" name="todaydate" size="12" value="<?php echo date('Y-m-d'); ?>" >
<a href="javascript:cal3.popup();"<img src="img/cal.gif" width="16" height="16" border="0" alt="Click for today date"></a>
<!-- <input type="hidden" name="todaydate" value="<?php echo date('Y-m-d'); ?>"> -->
</td>
</tr><tr>
<td>Commission Begin: </td><td><input type="text" name="begindate" size="12"><a href="javascript:cal1.popup();"><img src="img/cal.gif" width="16" height="16" border="0" alt="Click for begin date"></a></td>
</tr><tr>
<td>Commission End: </td><td><input type="text" name="enddate" size="12"><a href="javascript:cal2.popup();"<img src="img/cal.gif" width="16" height="16" border="0" alt="Click for end date"></a></td>
</tr><tr>
<td colspan="2"><input type="submit"></td>
</form>
</tr>
</table>

<!-- Calendar -->
<script language="JavaScript">
var cal1 = new calendar2(document.forms['commissiondate'].elements['begindate']);
cal1.year_scroll = true;
cal1.time_comp = false;
var cal2 = new calendar2(document.forms['commissiondate'].elements['enddate']);
cal2.year_scroll = true;
cal2.time_comp = false;
var cal3 = new calendar2(document.forms['commissiondate'].elements['todaydate']);
cal3.year_scroll = true;
cal3.time_comp = false;
</script>
<!-- End Calendar -->

<?php
include('includes/footer.php');
?>
