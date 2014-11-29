
<?php foreach($parameters["post_list"] as $post): ?>
 <div class="post">
	<div class="row article-header">
		<div class="span7">
			<h1><?php echo $post->getTitle(); ?></h1>
		</div>
		
		<?php if($user->getUsername() == $post->getAuthor()->getUsername()): ?>
		<div class="span1">
			<a <?php echo "href='index.php?route=post/update/".$post->getID()."'"; ?>><small>Edit</small></a>
		</div>
		<?php endif; ?>
		
	</div>
	<div class="row article-meta">
		
		<div class="span8">
			<div class="row">
				<div class="span6">
					<?php echo "<small>Posted by " . $post->getAuthor()->getUsername() . "</small>"; ?>	
				</div>
				<div class="span3">
					<small><?php echo $post->getDate(); ?></small>
				</div>
			</div>
			
		</div>
	</div>
	<div class="row article-body">
		<div class="span8"><?php echo $post->getContent(); ?></div>
	</div>
	
 </div>
<?php endforeach; ?>
