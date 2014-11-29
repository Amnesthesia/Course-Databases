<form class="form-horizontal" method="POST" action="index.php?route=user/save/">
<input type="hidden" name="route" value="user/save/" />

<?php if($parameters["user"]->getID() > 0 && $parameters["user"]->getID() != NULL): ?>
	<input type="hidden" name="id" value="<?php echo $parameters["user"]->getID(); ?>" />
<?php endif; ?>
<fieldset>

<!-- Form Name -->
<legend>
<?php 
	// The title of the form should be "Sign Up"
	// if it's a new user, and the name of the user if we're updating
	echo $parameters["page_title"];
?>
</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="username">Username</label>
  <div class="controls">
    <input id="username" name="username" type="text" placeholder="Username" class="input-xlarge" required="" value="<?php echo $parameters["user"]->getUsername(); ?>">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="email">E-mail address</label>
  <div class="controls">
    <input id="email" name="email" type="text" placeholder="E-mail address" class="input-xlarge" required="" value="<?php echo $parameters["user"]->getEmail(); ?>">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="first_name">First name</label>
  <div class="controls">
    <input id="first_name" name="first_name" type="text" placeholder="First name" class="input-xlarge" required="" value="<?php echo $parameters["user"]->getFirstName(); ?>">
    
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="last_name">Last name</label>
  <div class="controls">
    <input id="last_name" name="last_name" type="text" placeholder="Last name" class="input-xlarge" required="" value="<?php echo $parameters["user"]->getLastName(); ?>" >
    
  </div>
</div>

<!-- Password input-->
<div class="control-group">
  <label class="control-label" for="password">Password</label>
  <div class="controls">
    <input id="password" name="password" type="password" placeholder="Password" class="input-xlarge" required="">
    
  </div>
</div>

<!-- Password input-->
<div class="control-group">
  <label class="control-label" for="confirmpw">Confirm</label>
  <div class="controls">
    <input id="confirmpw" name="confirmpw" type="password" placeholder="Confirm password" class="input-xlarge" required="">
    
  </div>
</div>

<!-- Button -->
<div class="control-group">
  <label class="control-label" for="submit"></label>
  <div class="controls">
    <button id="submit" name="submit" class="btn btn-success">Save</button>
  </div>
</div>

</fieldset>
</form>
