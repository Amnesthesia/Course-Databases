<?php if($user->getUsername() != "Guest"): ?>
<form action="index.php?route=post/save/" method="POST">
	<input type="hidden" name="author" value="<?php echo $user->getID(); ?>" />
	<?php if(is_numeric($parameters["post"]->getID()) && $parameters["post"]->getID() > 0): ?>
	<input type="hidden" name="id" value="<?php echo $parameters["post"]->getID(); ?>" />
	<?php endif; ?>
	<div class="single post">
		<header>
			<input type="text" name="title" class="input-text" <?php echo "value='" . $parameters["post"]->getTitle() . "'" ?>/>
			<input type="checkbox" name="published" <?php echo "checked='" . $parameters["post"]->isPublished() . "'" ?> /> Publish
		</header>
		<article>
			<textarea name="content"><?php echo $parameters["post"]->getContent(); ?></textarea>
		</article>
		<footer>
			<input type="submit" value="Save" />
		</footer>
	</div>
</form>

<?php 
	// If the user isn't logged in, ask user to login.
	// If the user IS logged in, but not as the original user of this post (if this is a pre-existing post, as checked by existance of its ID)
	// ask the user to log in as the user who originally posted this.
	else: 
	
	?>

	<h2>Please log in <?php echo ($parameters["post"]->getID() != NULL && $parameters["post"]->getID() > 0 ? "as " . $parameters["post"]->getAuthor()->getUsername() : " "); ?></h2>

<?php endif; ?>

