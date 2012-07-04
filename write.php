<?php

class My_mongo {
    public $mongo = "";
    public $db = "";
    public $coll = "";
    function __construct(){
        $this->mongo = new Mongo();   
        $this->db = $this->mongo->selectDB("board_db");   
        $this->coll = $this->db->selectCollection("board_tb");
       
    }
    
    function insertData(){
        if($_POST['writer']!="" || $_POST['subject'] != "" || $_POST['message']!=""){
            $insert_string = array(
                'writer'=>ucwords($_POST['writer']),
                'subject' =>ucwords($_POST['subject']),
                'message'=>ucfirst($_POST['message']),
                'registerTime'=> date("Y-m-d h:i:s")
            );
            $result_insert = $this->coll->insert($insert_string);
            header("Location:index.php");
        }
    }
    
   
}

$my_mongo = new My_mongo();
$data = $my_mongo->insertData();
//var_dump($_POST['btn_submit']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Simplexi board</title>
        
        <link rel="stylesheet" href="css/redmond/jquery-ui-1.7.3.custom.css" type="text/css" media="all" />
        <link type="text/css" rel="stylesheet" href="css/board.css" />
            <link rel="stylesheet" type="text/css" href="css/bootstrap.css" media="screen, projection, handheld" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css" media="screen, projection, handheld" />
	<script src="js/jquery-1.3.2.min.js"></script>
        <script src="js/jquery-ui-1.7.3.custom.min.js" type="text/javascript"></script> 
    <script type="text/javascript">
    $('document').ready(function()
    {
        $('.alert-success').hide();  
        $('.alert-error').hide();  
        
        $("#goList").live("click",function(){
            window.location.href="index.php";
        });
            
        $( "#dialog" ).dialog({
            autoOpen: false
	});
        $( "#dialog_success" ).dialog({
            autoOpen: false
	});
        
        $('#btn_submit').click(function()
        {
            $('.alert-error').hide();
            var writer = $("#writer").val();
            var subject = $("#subject").val();
            var message = $("#message").val();
            var error = false;
            var require = new Array();
            
            if (writer == "") {
                require.push("writer");
                error = true;
            }
            
            if (subject == "") {
                require.push("subject");
                error = true;
            }
            
            if (message == "") {
                require.push("message");
                error = true;
            }
            
            if (require.length > 0) {
                $('.alert-error').show().fadeOut(50000);
                //alert("Please input required field [" +require.join(', ')+ "]");
            }
            
            if (error == false) {

                $('form').submit();
                $('.alert-success').show().fadeOut(50000);
            }
        });
    });
    </script>
</head>

<body>
<div id="wrap">
	<div id="content">
		<h2>Board Write</h2>
                <div class="alert alert-success" style="text-align: center;display: none;">
                    Well done! You successfully saved.
                </div>
                <div class="alert alert-error" style="text-align: center;display: none;">
                    Oh snap! Change a few things up and try submitting again.
                </div>
        <form action="write.php" method="post" enctype="multipart/form-data">
			<ul class="board_detail" style="list-style: none;">
				<li>
					<dl>
						<dt>Writer *</dt>
						<dd><input type="text" name="writer" id="writer" maxlength="15"/></dd>
					</dl>
				</li>
				<li>
					<dl>
						<dt>Subject *</dt>
						<dd><input type="text" name="subject" id="subject"/></dd>
					</dl>
				</li>
				<li>
					<dl>
						<dt>Message *</dt>
						<dd class="message"><textarea rows="8" cols="40" name="message" id="message"></textarea></dd>
					</dl>
				</li>
				
				<li class="submit">
					<input type="button" value="Save" class="btn btn-primary" name="btn_submit" id="btn_submit"/>
                                        <input type="button" value="Cancel" class="btn"  id="goList"/>
				</li>
			</ul>
        </form>   
	</div>
  
                
</div>
</body>
</html>

