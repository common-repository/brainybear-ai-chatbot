<?php  
if( !defined( 'ABSPATH' ) ) exit;
function brainybearAI_get_option_footer_script()
{
	return $footer_script=  wp_unslash(get_option('brainybearAI_info'));
}

function brainybearAI_get_option_footer_domain()
{
	return $footer_domain=  wp_unslash(get_option('brainybearAI_domain'));
}

function  brainybearAI_failure_option_msg($msg)
{
	
	echo  '<div class="notice notice-error ishf-error-msg is-dismissible"><p>' . esc_html($msg) . '</p></div>';	
	
}
function  brainybearAI_success_option_msg($msg)
{
	
	
	echo ' <div class="notice notice-success ishf-success-msg is-dismissible"><p>'. esc_html($msg) . '</p></div>';			
	
}


function enqueue_brainybearAI_dummy_script() {
    // Ensure jQuery is enqueued as it is always available in WordPress
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'enqueue_brainybearAI_dummy_script');

function brainybearAI_add_inline_script() {
    $bbid = get_option('brainybearAI_info'); // Fetching the option value
    if (empty($bbid)) { // Check if it's not empty
        return; // Exit if no ID is available
    }

    $bbid = esc_js($bbid); // Escaping for JavaScript to ensure JS safety

    $inline_script = <<<EOD
    (function(b,r,a,i,n,y){
        b.ux=b.ux||function(){(b.ux.q=b.ux.q||[]).push(arguments)};
        n=r.getElementsByTagName('head')[0]; y=r.createElement('script'); y.async=1; y.src=a+i;
        n.appendChild(y);
    })(window,document,'https://api.brainybear.ai/cdn/js/bear','.js?id={$bbid}');
EOD;

    // Attach the inline script to the 'jquery' handle
    wp_add_inline_script('jquery', $inline_script);
}
add_action('wp_enqueue_scripts', 'brainybearAI_add_inline_script');


?>
