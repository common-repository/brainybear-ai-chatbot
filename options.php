<?php 
if( !defined( 'ABSPATH' ) ) exit;

function brainybearAI_parse_json_from_url($url) {
    // Use wp_remote_get to fetch the data
    $response = wp_remote_get($url);

    // Check if the request was successful
    if (is_wp_error($response)) {
        // Handle error gracefully
        return null;
    }

    $body = wp_remote_retrieve_body($response); // Retrieves the response body.
    if (!empty($body)) {
        return json_decode($body);
    }

    // If there was no response body or json could not be parsed, return null
    return null;
}

    
if(isset($_POST['submit_option'])){
	
	$footer_script = sanitize_text_field($_POST['footer_script']);



		$nonce=$_POST['insert_script_wpnonce'];
		if(wp_verify_nonce( $nonce, 'insert_script_option_nonce' ))
		{
		 
			$json = brainybearAI_parse_json_from_url('https://api.brainybear.ai/user/wp-api?key='.$footer_script);
			$obj = $json;

			if(!is_null($obj)) {



	 
			$first_assistant = $obj->assistants;	
			$hashedAssistants = md5($first_assistant);


			if ($footer_script == $hashedAssistants) {
				update_option('brainybearAI_info',$footer_script);
				update_option('brainybearAI_domain',$first_assistant);
				$successmsg= brainybearAI_success_option_msg('API Key Updated.');
			} else {
				$errormsg= brainybearAI_failure_option_msg('Invalid API key: '.$footer_script);
			}
		} else {
			$errormsg= brainybearAI_failure_option_msg('Verification of API key failed.');
		}
			
		}
		else
		{
			 $errormsg= brainybearAI_failure_option_msg('Unable to update data!');
	    }
	
}


if(isset($_POST['submit_option_remove'])){
	

		$nonce=$_POST['insert_script_wpnonce'];
		if(wp_verify_nonce( $nonce, 'insert_script_option_nonce' ))
		{
		  
	
				update_option('brainybearAI_info','');
				update_option('brainybearAI_domain','');
				$successmsg= brainybearAI_success_option_msg('API Key Removed.');
		
	
			
		}
		else
		{
			 $errormsg= brainybearAI_failure_option_msg('Unable to update data!');
	    }
	
}



$footer_script = brainybearAI_get_option_footer_script();
$footer_domain = brainybearAI_get_option_footer_domain();
?>


<div class="brainybear_header">
<div class="logo"></div>
<h2>Settings</h2>
<div class="brainybear_clear"></div>
</div>
<div class="brainybear_clear"></div>
    <?php
    if ( isset( $successmsg ) ) {
        ?>
        <div class="ishf_updated fade"><p><?php echo esc_html($successmsg); ?></p></div>
        <?php
    }
    if ( isset( $errormsg ) ) {
        ?>
        <div class="error fade"><p><?php echo esc_html($errormsg); ?></p></div>
        <?php
    }
    ?>
		
	<div class='brainybear_inner'>

<?php
            if(isset($footer_script) && $footer_script!='') {
				$json = brainybearAI_parse_json_from_url('https://api.brainybear.ai/user/wp-api?key='.$footer_script);
				$obj = $json;
				$assistantsArray = explode(',', $obj->assistants);

				$first_assistant = $obj->assistants;	
				$hashedAssistants = md5($first_assistant);
 
				$plan = $obj->plan;
				$active = ($footer_script == $hashedAssistants)?true:false;
			}

?>


<?php if(!isset($active) || !$active) { ?>

<p>Thank you for using Brainybear. Please paste your Brainybear API key here to activate your tracking. </p>
<p>
Don't have an API key?</p>
 
<p>
<a class="bbear-secondary-border" target="_blank" href="https://app.brainybear.ai/signup?utm_source=wpplugin">Sign-up an account and get your API key for free</a>
</p>


		<h4 class="heading-h4">Paste your API key below</h4>

<?php }  else { ?>

      <p>Thank you for using Brainybear. <br/><a href="https://app.brainybear.ai/login?utm_source=wpplugin" target="_blank">Log in</a> to Brainybear for more features such as training and customizing your AI chatbot.</p>

      <h4 class="heading-h4">Your Plan</h4>


 
      <table class="bbear-protocols" cellspacing="0" cellpadding="0"><tbody>
      	<tr><td class="bold">Plan</td><td><?php echo $obj->plan==0?'Free':($obj->plan==1?'Basic':($obj->plan==2?'Growth':($obj->plan==3?'Business':($obj->plan==4?'Business':''))));?> </td></tr>
      	<tr><td class="bold">Monthly message credits remaining</td><td><?php echo esc_html($obj->credits);?> </td></tr>      	
      </tbody></table>

<a class="bbear-primary" href="https://app.brainybear.ai/login?utm_source=wpplugin" target="_blank">Upgrade</a>
 
      <h4 class="heading-h4">Your API key</h4>

<?php }  ?>
		<form method="post">
			
			
			<p><label>Your API key:</label></p>
			<p>
				<input type="text" name="footer_script" value="<?php  echo esc_html($footer_script); ?>" >
			</p>
				<div class="brainybear_clear"></div>
				<!--The uxsniff tracking script will be printed before the end of the <code>&lt;body&gt;</code> tag.-->
			
			<input type="hidden" name="insert_script_wpnonce" value="<?php $nonce= wp_create_nonce('insert_script_option_nonce'); echo esc_html($nonce); ?>">


<?php if(!isset($active) || !$active) { ?>
			<input type="submit" class="bbear-primary " name="submit_option" value="Update">
<?php } else {  ?>	
			<input type="submit" class="bbear-primary " name="submit_option_remove" value="Remove Key">
<?php }  ?>
		</form>
		
		
	</div>
	

