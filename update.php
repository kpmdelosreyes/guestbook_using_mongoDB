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
    function getData($id){
        return $this->coll->findOne(array('_id' => new MongoId(trim($id))));              
    }
    
    function updateData($id){      
        if($_POST['writer']!="" || $_POST['subject'] != "" || $_POST['message']!=""){
            $sId = array("_id" => new MongoId(trim($id)));
            $insert_string = array(
                '$set'=>array('writer' =>  ucwords($_POST['writer']), 'subject' =>ucwords($_POST['subject']), 'message' =>ucfirst($_POST['message']), 'registerTime'=> date("Y-m-d h:i:s"))
            );
           
            $result_update = $this->coll->update($sId,$insert_string);
            header("Location:index.php");
        }
    }
    
   
}
$id = $_GET["id"];

$my_mongo = new My_mongo();
$getData = $my_mongo->getData($id);
$data = $my_mongo->updateData($id);
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
		<h2>Board Modify</h2>
                <div class="alert alert-success" style="text-align: center;display: none;">
                    Well done! You successfully saved.
                </div>
                <div class="alert alert-error" style="text-align: center;display: none;">
                    Oh snap! Change a few things up and try submitting again.
                </div>
        <form action="update.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
			<ul class="board_detail" style="list-style: none;">
                         
				<li>
					<dl>
						<dt>Writer *</dt>
						<dd><input type="text" name="writer" id="writer" maxlength="15" value="<?php echo $getData['writer']; ?>" /></dd>
					</dl>
				</li>
				<li>
					<dl>
						<dt>Subject *</dt>
						<dd><input type="text" name="subject" id="subject" value="<?php echo $getData['subject']; ?>" /></dd>
					</dl>
				</li>
				<li>
					<dl>
						<dt>Message *</dt>
						<dd class="message"><textarea rows="8" cols="40" name="message" id="message" ><?php echo $getData['message']; ?></textarea></dd>
					</dl>
				</li>
				
				<li class="submit">
					<input type="button" value="Save" class="btn btn-primary" name="btn_submit" id="btn_submit"/>
                                        <input type="submit" value="Cancel" class="btn" onclick="window.location.href='index.php'"/>
				</li>
			</ul>
        </form>   
	</div>
                
</div>
</body>
</html>

