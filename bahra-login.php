<?php 
/* Template Name:Login Page */
global $user_ID;
if (!$user_ID){

if($_POST){
$username=$wpdb->escape($_POST['username']);
$password=$wpdb->escape($_POST['password']);
$login_array=array();
$login_array['user_login']=$username;
$login_array['user_password']=$password;

$verify_user=$wp_signon($login_array,true);
if(!is_wp_error($verify_user)){
echo "<script>window.location='".site_url()."'</script>";
}else{
echo "<p>Invalid Credentiols<p/>";
}

}else{
//user in logged out state
get_header(); 
?>
<form>
  <div class="container">
  <label for="username">Username</label>
        <input type="text" placeholder="Enter Username" id="username" name="username" required/>
        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" id="password" name="password" required/>

    <button type="submit">Login</button>
    <label>
    <input type="checkbox" checked="checked" name="remember"/> Remember meee
    </label>
    </div>	
    <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="cancelbtn">Cancel</button>
    <span class="psw">Forgot <a href="#">password?</a></span>
  </div>
</form>
  <?php 
  
  get_footer();
}
}else{
 get_header();?>


<section class="page-wrap">
<div class="container">
	
			
			<h1><?php the_title();?></h1>

			<?php get_template_part('includes/section','content');?>

			<?php get_search_form();?>




</div>
</section>


<?php get_footer();

}