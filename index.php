<?php
$curr_page = $_GET["page"];
$iRows = 10;
class My_mongo {
    public $mongo = "";
    public $db = "";
    public $coll = "";
    
    function __construct(){
        $this->mongo = new Mongo();   
        $this->db = $this->mongo->selectDB("board_db");   
        $this->coll = $this->db->selectCollection("board_tb");
    }
    
    function getAlldata($iRows)
    {
        
        $iPage = $_GET['page'] ? $_GET['page'] : 1;
        $limit = $iRows;
        $offset = $iRows * ($iPage - 1);
        
        if($_GET['search_type'] == "subject"){
            return $this->coll->find(array("subject"=>array('$regex'=>$_GET['search_query'])));  
        }elseif($_GET['search_type'] == "message"){
            return $this->coll->find(array("message"=>array('$regex'=>$_GET['search_query']))); 
        }else{            
            return $this->coll->find()->skip($offset)->limit($limit)->sort(array('registerTime' => -1));
        }
            
    }
    
    function paging($iRows)
    {
        include 'class_Pagination.php';
        return $paginates->paginate($iRows,$this->coll->find()->count(true));

    }
    
    function getTotal(){
        return $this->coll->find()->count(true);
    }
}

$my_mongo = new My_mongo();
 $data = $my_mongo->getAlldata($iRows);
$paging = $my_mongo->paging($iRows);
$total = $my_mongo->getTotal();
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
    $(document).ready(function()
    {        

       $('#btn_delete').click(function() {
           var check = $("input[name='delete[]']:checked");
           if (check.size() > 0) {
             
               var aId = new Array()
               $.each(check, function() {
                   aId.push($(this).val());
               });
                $('#notice_dialog').dialog({ 
                    modal : true,
                    buttons: { 
                        "Yes": function() { window.location.href="delete.php?ids="+aId; },
                        "Cancel" : function() {$(this).dialog("destroy");}
                    } 
                });
                
               //window.location.href="delete.php?ids="+aId;               
           }
       }); 
       
       $('#btn_search').click(function() {
            var type = $('#search_type').val();
            var query = $('#search_query').val();
            if(query == ""){
                $("#btn_search").attr("disabled", "disabled");
            }else{
                window.location.href = 'index.php?search_type='+type+'&search_query='+query;
            }
            
       });
       
       $()
    });  
    </script>
</head>

<body>
<div id="wrap">
    
	<div id="content">
		<h2>Board List</h2>
               
		<div class="search">
			<form>
				<select name="search_type" id="search_type">
					<option value="subject">subject</option>
					<option value="message">message</option>
				</select>
				<input type="text" value="" class="form-search" name="search_query" id="search_query"/>
				<input type="button" value="Search" name ="btn_search" id="btn_search"/>
			</form>
		</div>
                        
        <div id="div_list">
                <p align="right"><em style="color:red">Today:</em> <?php echo date('Y-m-d')?> | <em style="color:red"> Total: </em> <?php echo $data->count(true) ."/". $total; ?></p>

		<table class="board_list table table-striped">
		<caption>&nbsp;</caption>
		<thead>
			<tr>
				<th>No</th>
				<th>Subject</th>
				<th>Writer</th>
				<th>Date</th>
			</tr>
		</thead>
		<tbody>
                    
            <?php if($data->count(true)!=0){
                $i = 0;
                foreach ($data as $val){ 
                        $i++; ?>    
			<tr>
				<td><?php echo $i;?></td><!--post index. retrieved from db-->
				<td class="subject">
					<input type="checkbox" id="" name="delete[]" value="<?php echo $val['_id']?>" title="delete" />
					<a href="update.php?id=<?php echo $val['_id']?>"><?php echo $val['subject']?></a>
				</td><!--subject or post title. retrieved from db-->
				<td><?php echo $val['writer']?></td><!--writer's name. retrieved from db-->
                                <td><?php echo date('d/m/Y', strtotime($val['registerTime']))?></td><!--written date. retrieved from db. Timestamp in DB. display format:dd/mm/yyyy-->
			</tr>
            <?php }
            } else{ ?>
                <tr>
                        <td colspan="4">No records found.</td>
                </tr>
            <?php }?>
		</tbody>
		</table>
        <div style="float:right; margin:20px 20px;">
            <input type="button" name="btn_delete" class="btn btn-danger" id="btn_delete" value="Delete"/>
            <input type="button" name="btn_write" class="btn btn-primary" id="btn_write" value="Write" onclick="window.location.href='write.php'"/>
        </div>
        <div class="paging">
            <?php echo $paging; ?>
	</div> 

         <div id ="notice_dialog" title="Delete" style="display:none">
            <p>Are you sure you want to delete these data?</p>
        </div>
                
        </div>    
	</div>
       
                
</div>
</body>
</html>

