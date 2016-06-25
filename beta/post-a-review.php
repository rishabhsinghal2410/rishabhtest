<?
	require("./config.php");
	//include("./bl/validaterequest.php");	
	require("./bl/db.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
<script language="javascript">
	function submitform(elem) {
		var isAnySelected = false;
		for(var i = 0; i < elem.length; i++) {
			if (elem[i].type == "checkbox" && elem[i].checked == true) {
				isAnySelected = true;
			}
		}
		if (isAnySelected == false) {
			alert("Please select any news to delete");
		} else {
			var surity = confirm("Are you sure you want to delete the selected photos ?");
			if (surity == 1) {
				document.forms["frmMain"].submit();
			}
		}
	}
</script>
<script src="./js/lightbox-form.js" type="text/javascript"></script>
<script src="./js/frm.js" type="text/javascript"></script>
    <title>Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/3-col-portfolio.css" rel="stylesheet">
	<link href="css/lightbox-form.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen">
<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous.js?load=effects,builder" type="text/javascript"></script>
<script src="js/lightbox.js" type="text/javascript"></script>
<script type="text/javascript">

	if (typeof(jQuery) != 'undefined') {

     	jQuery.noConflict();

	}

</script>
</head>

<body>

    <? include('header.php') ?>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Post a review
                </h1>
            </div>
        </div>
        <!-- /.row -->
		<div id="frm1">
        <form method="post" action="./bl/manage-photo-gallery.php?method=ADD" target="_parent" enctype="multipart/form-data" onsubmit="return validateForm();">
            <table width="80%" border="0">
                <tr>
                    <td class="textHeader" width="50%" align="right">Select Photo:&nbsp;&nbsp;</td>
                    <td><input type="file" name="photo" id="photo"  /></td>
                </tr>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr>                
                <!--tr>
                    <td class="textHeader" align="right">Title:&nbsp;&nbsp;</td>
                    <td><input type="text" name="title" id="title" maxlength="60" style="border:thin solid #ABADB4;" onFocus="changeBorder(this);"></td>
                </tr>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td class="textHeader" align="right">Contect:&nbsp;&nbsp;</td>
                    <td><textarea name="descr" id="desc" maxlength="2000" rows="5" cols="50" style="border:thin solid #ABADB4;" onFocus="changeBorder(this);"></textarea></td>
                </tr>
				<tr>
                	<td colspan="2">&nbsp;</td>
                </tr-->
				<tr>
                    <td class="textHeader" align="right">Landing URL:&nbsp;&nbsp;</td>
                    <td><input type="text" name="landing_url" id="landing_url" maxlength="100%" style="border:thin solid #ABADB4;" onFocus="changeBorder(this);">&nbsp;<span id="landing_url_err"></span></td>
                </tr>
                <tr>
                	<td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td align="right"><input type="submit" name="submit" value="Submit" class="button">&nbsp;</td>
                    <td align="left">&nbsp;<input type="button" name="cancel" value="Cancel" onClick="closebox('box')" class="button"></td>
                </tr>
            </table>
        </form>
	</div>
        <hr>

        <!-- Pagination -->
        <!--div class="row text-center">
            <div class="col-lg-12">
                <ul class="pagination">
                    <li>
                        <a href="#">&laquo;</a>
                    </li>
                    <li class="active">
                        <a href="#">1</a>
                    </li>
                    <li>
                        <a href="#">2</a>
                    </li>
                    <li>
                        <a href="#">3</a>
                    </li>
                    <li>
                        <a href="#">4</a>
                    </li>
                    <li>
                        <a href="#">5</a>
                    </li>
                    <li>
                        <a href="#">&raquo;</a>
                    </li>
                </ul>
            </div>
        </div-->
        <!-- /.row -->

        <!-- Footer -->
        <? include("footer.php") ?>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <!--script src="js/jquery.js"></script-->

    <!-- Bootstrap Core JavaScript -->
    <!--script src="js/bootstrap.min.js"></script-->
</body>

</html>
