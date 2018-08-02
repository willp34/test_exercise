<?php

namespace MrB;


/**
 * PLUGIN CORE.
 *
 * Plugin base file. Controls initialisation of Plugin.
 */

class Core 
{
    
    /**
     * @var string
     */
    public static $plugin_slug;


    public static $job_single_page_id = 13;

    public static $job_upload_action = 'mrb_job_upload';


    /**
     * Static initialisation method. 
     */
    public static function initialise()
    {
        $self = new self();

        $self->start();
    }
    

    /**
     * Plugin initialisation logic. Called once when WordPress
     * is loaded and initialised. Add actions/filters here.
     */
    private function start()
	{ // URL Rewrites
        add_action('init', array($this, 'single_job_rewrite' ));
	
        // Custom Post Type
        add_action('init', array($this, 'register_application_post_type' ));

        // Form handler endpoints
        // https://codex.wordpress.org/Plugin_API/Action_Reference/admin_post_(action)
        add_action('admin_post_mrb_job_upload', array($this, 'handle_application_upload' ));
        add_action( 'admin_post_nopriv_mrb_job_upload', array($this, 'handle_application_upload' ) );
    }

	
    /**
     * Registers the Job Application Post Type with WordPress
     * https://codex.wordpress.org/Function_Reference/register_post_type
     */
    function register_application_post_type() {
        register_post_type('mrb_job_application',
           array(
               'labels'      => array(
                   'name'          => __('Job Applications'),
                   'singular_name' => __('Job Application'),
               ),
               'public'      => false, // hide from frontend
               'show_ui' => true, // force available within Admin Dashboard
               'menu_icon' => 'dashicons-media-document'
           )
        );
    }


    /**
     * Adds Custom Rewrite Rules ("routes") to match the url
     * for a Single Job (eg: /jobs/123456/). Translates a "pretty"
     * url to a url that WordPress can interpret.
     */
    function single_job_rewrite() {

        // https://codex.wordpress.org/Rewrite_API/add_rewrite_tag
        add_rewrite_tag('%job_id%', '([\d]+)');

        // Sets the "Page" to be the "Job Single" page created within
        // WP Admin. Also sets the "job_id" query param to match the
        // pattern matched from the url via regex.
        // https://codex.wordpress.org/Rewrite_API/add_rewrite_rule
        add_rewrite_rule('^jobs/([\d]+)', 'index.php?page_id=' . self::$job_single_page_id . '&job_id=$matches[1]', 'top');
    }

    /**
     * Handles the upload of the Job Application
     * see add_action calls for `admin_post_*` which handle
     * any forms posted with the `mrb_job_upload` action
     * https://codex.wordpress.org/Plugin_API/Action_Reference/admin_post_(action)
     */
    function handle_application_upload() {
			if(empty($_POST["verify"])){
				if(!empty($_POST["your-email"])&&!empty($_POST["your-name"])){
					$args_newApplicant = array(
										'post_type' => 'mrb_job_application',
										'post_ststus' => 'publish',
										'meta_query' => array(
											'relation' => 'AND',
											
											array(
											'key' => 'job_id',
											'value' => $_POST["job_id"] ,
											'compare'  => '='
											), array(
											'key' => 'Email',
											'value' => $_POST["your-email"] ,
											'compare'  => '='
											)
										)
										);
										$new_applicant = new \WP_Query($args_newApplicant);
										global $wpdb;
										if($new_applicant->have_posts()){
											 ?>
										   <div class="alert alert-danger">
														<p> youve already applied for this role</p>
											</div>
											<?php
										}
										else
										{
												// Insert post into job application post meta data
											  $post_id = wp_insert_post(array (
											   'post_type' => 'mrb_job_application',
											   'post_title' => "Job application made for ".$_POST["job_title"] ." by ". $_POST["your-name"],
											   'post_content' => $_POST["your-name"],
											   'post_status' => 'publish',
											   'comment_status' => 'closed',   // if you prefer
											));
										} 
				 
					
						?>
						<div class="alert alert-success">
							<p>New post addded</p>
						</div>
					<?php
				
				}
				else{
					?>
				<div class="alert alert-danger">
					<p>Please add email with your name</p>
				</div>
					<?php
				}
			
			
		if ($post_id) {
			   // insert post meta
			   add_post_meta($post_id, 'Name',  $_POST["your-name"] );
			   add_post_meta($post_id, 'Email',  $_POST["your-email"] );
			   add_post_meta($post_id, 'job_id',  $_POST["job_id"] );
			   add_post_meta($post_id, 'job_title',  $_POST["job_title"] );
			   
			   /// file info
					$destination= WP_CONTENT_DIR."/job-application-cvs";
					$file_name =$_FILES['your-cv']['name'];
					$extensions = explode(".",$file_name);
					$n = count($extensions)-1;
					
					$extension = $extensions[1];
					$newname = $extensions[0].'_'.time().'_'.date('d-m-y').'.'.$extension;
					$filepath = $destination.'/'.$newname;
					$filename ='http://backend-code-test.test/wp-content/job-application-cvs/'.$newname;
					
					
					
					
			   //end file info
			   if($extension =="pdf"){
				   if(move_uploaded_file($_FILES['your-cv']['tmp_name'],$filepath)){
						add_post_meta($post_id, 'cv_path',$filename );
					    ?>
					   <div class="alert alert-success">
									<p> file uploaded </p>
						</div>
						<?php
				   }
				   else{
					   ?>
					   <div class="alert alert-danger">
									<p>upload error: file is not uploaded </p>
						</div>
						<?php
				   }
			   }
			   else{
				   ?>
				   <div class="alert alert-danger">
						<p>you can only upload pdfs </p>
				   </div>
				   <?php
			   }			   
			
			
		}
		else{
				?>
			<div class="alert alert-danger">
				<p>File not uploded</p>
				</div>
				<?php
			}
        // For this request ONLY we can change the wp_upload_dir 
        // to a custom path
        // https://codex.wordpress.org/Plugin_API/Filter_Reference/upload_dir
        add_filter( 'upload_dir', function($param) use ($job_id) {
            $mydir = '/job-application-cvs/' . $job_id;
            
            $param['path'] = 'SOMEWHERE';
            $param['url']  = 'OVER_THE_RAINBOW';
           return $param;
        } );
    
        
        // https://codex.wordpress.org/Function_Reference/wp_handle_upload
        $movedfile = wp_handle_upload( $file, array(
            'test_form' => false // When there is no form being handled, use 'test_form' => false to bypass default checks
        ) );
			}
			else{
					?>
			<div class="alert alert-danger">
				<p>you are a bot</p>
				</div>
				<?php
			}
		die();
    }



function my_js_files(){
	

		wp_enqueue_script('try',plugins_url('/js/ajax-process.js',__FILE__),array('jquery'));
		wp_localize_script('try','mrb_ajax_process_object', array(
			'ajax_url'=> admin_url('admin-ajax.php'), 
			'we_value' =>123
		));
	}
	


    /**
     * @return void
     */
    public static function activate()
    {
        flush_rewrite_rules();
    }

    /**
     * @return void
     */
    public static function deactivate()
    {
        flush_rewrite_rules();
    }

    
}
