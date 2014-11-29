 <div class="post">
	<div class="row article-header">
		<div class="span6">
			<h1><?php echo $parameters["post"]->getTitle(); ?></h1>	
		</div>
	</div>
	<div class="row article-meta">
		
		<div class="span8">
			<div class="row">
				<div class="span6">
					<?php echo "<small>Posted by " . $parameters["post"]->getAuthor()->getUsername() . "</small>"; ?>	
				</div>
				<div class="span3">
					<?php echo $parameters["post"]->getDate(); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row article-body">
		<div class="span6"><?php echo $parameters["post"]->getContent(); ?></div>
	</div>
	
 </div>

