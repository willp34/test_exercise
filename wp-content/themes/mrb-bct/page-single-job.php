<?php 
/* Template Name: Single Job */ 


$feed = file_get_contents(ABSPATH . '/fixtures/jobs.xml');
$mrb_job_xml = simplexml_load_string($feed);

$channel = (array) $mrb_job_xml->channel;

$job_id = get_query_var( 'job_id' );

$job = array_filter($channel['item'], function($job_item) use ($job_id) {
	$the_job = (array) $job_item;
	return $job_item && $job_item->guid == $job_id;
});

$job = $job[0];

?>

<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="container">				
				<h1><?php echo $job->title ?></h1>
				<p><?php echo $job->content->Vacancy->ClosingDate ?></p>
				<p><?php echo $job->content->Vacancy->Description ?></p>
				
				
				<h2>Apply for this Job:</h2>
				<div class="row">
    				<div class="col-6">
						<form method="post" action="<?php echo admin_url( 'admin-post.php' ) ?>">
								
							<input type="hidden" name="action" value="mrb_job_upload">
			  				<input type="hidden" name="job_id" value="<?php echo $job_id; ?>">
								
							<div class="form-group">
								<label for="your-name" id="your-name">Name</label>
								<input class="form-control" name="your-name" type="text">
							</div>
								
							<div class="form-group">
								<label for="your-email" id="your-email">Email</label>
								<input class="form-control" name="your-email" type="email">
							</div>
								
							<div class="form-group">
								<label for="your-cv" id="your-cv">CV (PDF only)</label>
								<input class="form-control-file" name="your-cv" type="file">
							</div>

							<button type="submit" class="btn btn-primary">
								Submit
							</button>
						</form>
				</div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();
