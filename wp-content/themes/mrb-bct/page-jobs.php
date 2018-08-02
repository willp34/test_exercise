<?php 
/* Template Name: Jobs Listing */ 

$feed = file_get_contents(ABSPATH . 'fixtures/jobs.xml');
$mrb_job_xml = simplexml_load_string($feed);



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
			</div>

			<div class="container">			
				<ul class="jobs-list">
				<?php foreach ($mrb_job_xml->channel->item as $job): ?>

					<?php 
					// echo "<pre>";
					// var_dump($job);
					// echo "</pre>"; 
					?>
					<li class="jobs-list-item" id="job-<?php echo $job->guid;?>">
						<h2><a href="/jobs/<?php echo $job->guid; ?>"><?php echo $job->title;?></a></h2>
						<p><?php echo substr($job->content->Vacancy->Description, 0, 100); ?>...</p>
						<p><a href="/jobs/<?php echo $job->guid; ?>">View Full Job</a></p>
					</li>
				<?php endforeach; ?>
				</ul>

				<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">Next</a></li>
  </ul>
</nav>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
