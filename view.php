<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Simplexi board</title>
        <link rel="stylesheet" href="<?php echo base_url();?>public/css/redmond/jquery-ui-1.7.3.custom.css" type="text/css" media="all" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>public/css/board.css" />
        
	<script src="<?php echo base_url();?>public/js/jquery-1.3.2.min.js"></script>
        <script src="<?php echo base_url();?>public/js/jquery-ui-1.7.3.custom.min.js" type="text/javascript"></script>
    <script type="text/javascript">
    $('document').ready(function() {
       $('#btn_modify').click(function() {
           window.location.href="<?php echo site_url()?>/modify/index/<?php echo $id ?>";
       });
       $('#btn_list').click(function() {
           window.location.href="<?php echo site_url()?>/lists";
       });
    });
    </script>
</head>

<body>
<div id="wrap">
	<div id="content">
		<h2>Board View</h2>
			<ul class="board_detail">
                <li>
					<dl>
						<dt>Subject</dt>
						<dd> <?php echo $subject ?> </dd>
					</dl>
				</li>
				<li>
					<dl>
						<dt>Writer</dt>
						<dd> <?php echo $writer ?> </dd>
					</dl>
				</li>
				<li>
					<dl>
						<dt>Date</dt>
                        <dd> <?php echo date('d/m/Y', strtotime($registerTime))?> </dd>
					</dl>
				</li>
				<li>
					<dl>
						<dt> Message </dt>
						<dd class="message"> <?php echo $message ?> </dd>
					</dl>
				</li>
				<li>
					<dl>
						<dt>File</dt>
						<dd><a href="#"></a></dd>
					</dl>
				</li>
				<li class="submit">
					<input type="button" value=" List " id="btn_list"/>
					<input type="button" value="Modify" id="btn_modify" />
				</li>
			</ul>
	</div>
</div>
</body>
</html>