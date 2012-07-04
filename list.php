<?php

class My_mongo {
    public $mongo = "";
    public $db = "";
    public $coll = "";
    function __construct(){
        $this->mongo = new Mongo();   
        $this->db = $this->mongo->selectDB("lala");   
        $this->coll = $this->db->selectCollection("mongo");
       
    }
    
    function getAlldata(){
       
        return $this->coll->find();                
    }
    
   
}
//
////Inserting data
//	$insert_string = array(
//   		 'name'=>'tert',
//   		 'address' =>'ert, Rizal',
//   		 'number'=>'234234234234'
//	);
//	$result_insert = $collection->insert($insert_string);
//var_dump($result_insert);

$my_mongo = new My_mongo();
$data = $my_mongo->getAlldata();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Simplexi board</title>
        
        <link rel="stylesheet" href="css/redmond/jquery-ui-1.7.3.custom.css" type="text/css" media="all" />
        <link type="text/css" rel="stylesheet" href="css/board.css" />
        
	<script src="js/jquery-1.3.2.min.js"></script>
        <script src="js/jquery-ui-1.7.3.custom.min.js" type="text/javascript"></script> 
    <script type="text/javascript">
    $(document).ready(function()
    {        
        
       $('#btn_delete').click(function() {
           var check = $("input[name='delete[]']:checked");
           if (check.size() > 0) {
               var val = "";
               $.each(check, function() {
                   val += $(this).val() + "-";
               });
               $.ajax({
                   url: 'lists/delete',
                   type: 'POST',
                   data: {'post': val},
                   success : function(response) {
                       if (response == 1) {
                          
                          alert('Deleted successfully.');
                          
                          $('#div_list').load('lists/reload_list');
                       }
                   }
               });
               
           }
       }); 
       
       $('#btn_search').click(function() {
            var type = $('#search_type').val();
            var query = $('#search_query').val();
            $('#div_list').load('lists/search', {search_type: type, search_query: query});
       });
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
				<input type="text" value="" name="search_query" id="search_query"/>
				<input type="button" value="Search" id="btn_search"/>
			</form>
		</div>
                        
        <div id="div_list">
                <p align="right">Today: <?php echo date('Y-m-d')?> / Total:  <?php echo count($data); ?>asd</p>
		<table class="board_list">
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
                    
            <?php foreach ($data as $val): ?>    
			<tr>
				<td><?php echo $val['id']?></td><!--post index. retrieved from db-->
				<td class="subject">
					<input type="checkbox" id="" name="delete[]" value="<?php echo $val['id']?>" title="delete" />
					<a href="view/index/<?php echo $val['id']?>"><?php echo $val['subject']?></a>
				</td><!--subject or post title. retrieved from db-->
				<td><?php echo $val['writer']?></td><!--writer's name. retrieved from db-->                                
			</tr>
            <?php endforeach;?>
		</tbody>
		</table>
        <div style="float:right; margin:20px 20px;">
            <input type="button" name="btn_delete" id="btn_delete" value="Delete"/>
            <input type="button" name="btn_write" id="btn_write" value="Write" onclick="window.location.href='write'"/>
        </div>
        </div>    
	</div>
                
</div>
</body>
</html>

