<HTML>
<HEAD>

<?
if(isset($_POST['submit'])){
  $age = $_POST['group1'];
  mail('sharon.zahra@gmail.com','subject here','Answer Selected: '.$age);
}
?>

<SCRIPT LANGUAGE="JavaScript"><!--
function copyForm() {
    opener.document.hiddenForm.myTextField.value = document.popupForm.myTextField.value;
    opener.document.hiddenForm.submit();
    window.close();
    return false;
}
//--></SCRIPT>
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
}
-->
</style>
</HEAD>
<BODY>

<FORM NAME="popupForm" onSubmit="return copyForm()" action="" method="post">
  <p>
  <h1 class="style2"> How did you get to know about us? </h1>
    <INPUT TYPE="radio" NAME="group1" value="YellowPages">
    <span class="style1">    a) Yellow Pages<br>
    </span>
    <input type="radio" name="group1" value="other">
    <span class="style1">b) Other means of communication</span><br>
    <input type="radio" name="group1" value="friend">
    <span class="style1">c) By Friends</span><br>
    <input type="radio" name="group1" value="purchased" checked>
    <span class="style1">d) Purchased before</span></p>
  <p align="right">
    <INPUT name="Submit" TYPE="submit" onClick="copyForm()" VALUE="Submit">
    </p>
</FORM>
</BODY>
</HTML>