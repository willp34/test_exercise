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


$job =array_values($job); 

$job = $job[0];
?>

<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="container">		
               <?php  if(!empty($job)){?>			
				<h1>Title: <?php echo $job->title ?></h1>
				<h3>Job Type: <?php echo $job->content->Vacancy->JobTypes ?></h3>
				<h4>Location: <?php echo $job->content->Vacancy->Location ?></h4>
				<h5>Salary: <?php echo $job->content->Vacancy->Salary ?></h5>
				<h5>Closing Date: <?php echo date("jS M Y", strtotime($job->content->Vacancy->ClosingDate));?></h5>
				<p><?php echo $job->content->Vacancy->ClosingDate ?></p>
				<p><?php echo $job->content->Vacancy->Description ?></p>
				<?php if(!empty($job->content->Vacancy->BenefitInfoList)){ ?>
				<p>Benefit List:<?php echo  $job->content->Vacancy->BenefitInfoList ?></p>
				
				<?php } ?>
				
				<p><strong>Industries:</strong> <?php echo $job->content->Vacancy->Industries ?></p>
				<p><a href="<?php echo  $job->content->Vacancy->ApplicationUrl ?>" target="_blank">Link to full details:</a></p>
				
				<h2>Apply for this Job:</h2>
				<div class="row">
    				<div class="col-6">
						<form   enctype="multipart/form-data" method="post" action="<?php echo admin_url( 'admin-post.php' ) ?>" class="form-process">
								
							<input type="hidden" name="action" value="mrb_job_upload" class="action">
			  				<input type="hidden" name="job_id" value="<?php echo $job_id; ?>" class="job-id">
							
			  				<input type="hidden" name="job_title" value="<?php echo $job->title; ?>" class="job-title">
								
							<div class="form-group">
								<label for="your-name" id="your-name">Name</label>
								<input class="form-control" name="your-name" type="text" class="your-name">
							</div>
								
							<div class="form-group">
								<label for="your-email" id="your-email">Email</label>
								<input class="form-control" name="your-email" type="email" class="your-email">
							</div>
								
							<div class="form-group">
								<label for="your-cv" id="your-cv">CV (PDF only)</label>
								<input class="form-control-file" name="your-cv" type="file">
							</div> 
								<div class="form-group">
									<label for="your-coverletter">Cover Letter</label>
									<textarea class="form-control" id="your-coverletter" class="your-coverletter" rows="7"></textarea>
								</div>
									<div class="form-group"  style="display:none">
								<label for="your-email" id="your-email">Verify</label>
								<input class="form-control" name="verify" type="text" class="your-email" placeholder="If you are human leave blank">
							</div>
							<button type="submit" class="btn btn-primary">
								Submit
							</button>
						</form>
				</div>
				<div class="col-6">
						<div class="message"></div>
				</div>
			</div>
			<?php
			   }
		    else
			{
				?>
					<p>Job does not exist</p>
				<?php
			}
			?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();
