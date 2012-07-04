<script type="text/javascript">
    $(document).ready(function()
    {        
        
       $('#btn_delete').click(function() {
           var check = $("input[name='delete[]']:checked");
           if (check.size() > 0) {
               var param = new Array();
               $.each(check, function() {
                   param.push($(this).val());
               });
               $.ajax({
                   url: '<?php echo site_url();?>/lists/delete',
                   type: 'POST',
                   data: {post: param},
                   success : function(response) {
                       if (response == 1) {
                          
                          alert('Deleted successfully.');
                          
                          $('#div_list').load('<?php echo site_url();?>/lists/reload_list/<?php echo $val['id']?>');
                       }
                   }
               });
               
           }
       }); 
       
       $('#btn_search').click(function() {
            var type = $('#search_type').val();
            var query = $('#search_query').val();
            $('#div_list').load('<?php echo site_url();?>/lists/search/<?php echo $val['id']?>', {search_type: type, search_query: query});
       });
    });  
    </script>
                <p align="right">Today: <?php echo date('Y-m-d')?> / Total <?php echo count($data)?></p> 
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
					<a href="<?php echo site_url()?>/view/index/<?php echo $val['id']?>"><?php echo $val['subject']?></a>
				</td><!--subject or post title. retrieved from db-->
				<td><?php echo $val['writer']?></td><!--writer's name. retrieved from db-->
				<td><?php echo date('d/m/Y', strtotime($val['registerTime']))?></td><!--written date. retrieved from db. Timestamp in DB. display format:dd/mm/yyyy-->
			</tr>
            <?php endforeach;?>
		</tbody>
		</table>
        <div style="float:right; margin:20px 20px;">
            <input type="button" name="btn_delete" id="btn_delete" value="Delete"/>
            <input type="button" name="btn_write" id="btn_write" value="Write" onclick="window.location.href='<?php echo site_url()?>/write'"/>
        </div>
		