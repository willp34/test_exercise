<?php 
session_start();

/* Template Name: Client Listing */ 

$user =wp_get_current_user();
$feed = file_get_contents(ABSPATH . 'fixtures/jobs.xml');
$mrb_job_xml = simplexml_load_string($feed);
if(!isset($_POST['job'])||''==$_POST['job'])
							{
							}
							else{
								$job_id = $_POST['job'];
								$_SESSION["job_selected"] = $job_id;
							}

?>
<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="container">	
				<?php
				    
					while ( have_posts() ) :
						the_post();

						get_template_part( 'template-parts/content', 'page' );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
				?>	
				<a href=" " class="form-process">ajax click me</a>
			</div>
			
			<?php  if( $user->roles[0]=="administrator"){
				?>
			<div class="container">	
			<?php 
			$job_description = $_SESSION["job_selected"];//$_POST['job'];
			?>
					<form   method="post" action="http://backend-code-test.test/client-review/">
								
							<div class="form-group">
								<label for="your-name" id="job">Job:</label>
								<select class="form-control" name="job" onchange="submit();">
								 <?php  
								
										if(empty($job_description)){
											
								 ?>
									<option  selected="selected">Choose a job</option>
									<?php
										}
										else{
											?>
												<option  >Choose a job</option>
											<?php
										}
									foreach ($mrb_job_xml->channel->item as $job): 
									
										if($job_description==$job->guid)
										{
											?>
											<option  selected="selected" value="<?php echo $job->guid;?>"><?php echo $job->title;?> </option>
											<?php
										}
										else{
										?>
											<option  value="<?php echo $job->guid;?>"><?php echo $job->title;?> </option>
									<?php
										}									
									endforeach;  ?>
								</select>
							</div>
								
							
						</form>
					<?php
					
							if(empty($_SESSION["job_selected"]))
							{
								echo "<p>Cant filter ".$_SESSION["job_selected"]."</p>";
							}
							else{
								$job_id = $_POST['job'];
								$_SESSION["job_selected"] = $job_id;
								//session_start();
								//$session_Id = session_id();
							
							}
								
								$args = array(
									'post_type' => 'mrb_job_application',
									'post_ststus' => 'publish',
									'meta_key' => 'job_id',
									'meta_value' => $_SESSION["job_selected"] ,
									'posts_per_page' =>5,
									'paged' => get_query_var('paged')?get_query_var('paged'):1
									);
									$job_applications = new WP_Query($args);
							
							if($job_applications->have_posts()){
										$count =$job_applications->post_count;
										?>
										<h1>There are <?php  echo "$count";?> jobs applications listed</h1>
										  <table class="table table-striped">
												<thead>
												  <tr>
													<th>Applicant Name</th>
													<th>Email</th>
													<th>Job Role</th>													
													<th>Cover Letter</th>
													<th>CV</th>
												  </tr>
												</thead>
												<tbody>
												  
												

										<?php
								while($job_applications->have_posts()):
									$job_applications->the_post();
									
									?>
											<tr>
														
														
														<td> <?php	echo get_post_meta(get_the_ID(), 'Name', true ); ?> </td>
														<td> <?php	echo get_post_meta(get_the_ID(), 'Email',  true ); ?></td>
														<td><?php	echo get_post_meta(get_the_ID(), 'job_id',  true ); ?>
														<?php	echo get_post_meta(get_the_ID(), 'job_title',  true );?></td>
														<td> <?php echo get_the_content();?></td>
														<td><a target="_blank" href="<?php	echo get_post_meta(get_the_ID(), 'cv_path',  true );?>">View Cv</a></td>
													</div>
											</tr>
									<?php
								endwhile;
								?>
										</tbody>
									</table>
								<?php 
								$big = 99999;
								echo Paginate_links(array(
											'base'=> str_replace($big,'%#%', esc_url(get_pagenum_link($big))),
											'format'=>'/paged/#%#',
											'current' => max(1,get_query_var('paged')),
											'total' => $job_applications->max_num_pages
								));
								
								wp_reset_postdata();
								
					?>
							

							<?php 
							}
							else{
								
								echo "<p>No jobs listed</p>";
							}?>
			</div>
		<?php  } 
		else{
			?>
			<div class="container">	
				<p>Please log in </p>
			</div>
		<?php }
		?>
		</main>
		
	</div>
	
	<?php

get_footer();

?>