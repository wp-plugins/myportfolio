<?php 


//list terms in a given taxonomy (useful as a widget for twentyten)
$taxonomy = 'category';
// Get the categories for post and product post types
$tax_terms = get_terms('category', array(
 	'post_type' => array('portfolio'),
 	'fields' => 'all'
));

//$tax_terms = get_terms('category', array('post_type' => array('portfolio'),'fields' => 'all'));
?>


					<div class="filters text-center">
							<ul class="nav nav-pills">
								<li class="active"><a href="#" data-filter="*">All</a></li>
									<?php
										foreach ($tax_terms as $tax_term) {
											
										echo '<li>' . '<a href="#" data-filter=".' . sprintf( __( "%s" ), $tax_term->slug ) . '" ' . '>' . $tax_term->name.'</a></li>';
										}
										?>
								
							</ul>
						</div>





<ul>

</ul>
<?php
query_posts('post_type=portfolio&post_status=publish&posts_per_page=10&paged='. get_query_var('paged')); ?>

	<?php if( have_posts() ): ?>

			<div class="isotope-container row grid-space-20">
				<?php while( have_posts() ): the_post(); ?>
						<?php
					$terms = get_the_terms( $post->ID , 'category' );
					$cls=" ";
					foreach ( $terms as $term ) { ?>
					  <?php
						$cls  = $cls. " ".$term->slug;
						
						} ?>
						<div class="col-sm-6 col-md-3 isotope-item <?php echo $cls; ?>">
					
					
						<div class="image-box">
									<div class="overlay-container">
										<?php the_post_thumbnail(); ?>
										
										<a class="overlay" data-toggle="modal" data-target="#project-<?php echo get_the_ID(); ?>">
											<i class="fa fa-search-plus"></i>
											 
										</a>
									</div>
									<a class="btn btn-default btn-block" data-toggle="modal" data-target="#project-<?php echo get_the_ID(); ?>"><?php the_title(); ?></a>
						</div>
						
						<!-- Modal -->
								<div class="modal fade" id="project-<?php echo get_the_ID(); ?>" tabindex="-1" role="dialog" aria-labelledby="project-<?php echo get_the_ID(); ?>-label" aria-hidden="true">
									<div class="modal-dialog modal-lg">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
												<h4 class="modal-title" id="project-<?php echo get_the_ID(); ?>-label"><?php the_title(); ?></h4>
											</div>
											<div class="modal-body">
												
												<div class="row">												 
													<div class="col-md-12">
														<?php the_post_thumbnail( array(500,500) ); ?>
														<br/>
														<h3><?php the_title(); ?></h3>
														<p><?php the_content(); ?></p>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>
								<!-- Modal end -->
					
					</div>
					
					
					
				<?php endwhile; ?>
			</div>

	<?php else: ?>

		<div id="post-404" class="noposts">

		    <p><?php _e('None found.','example'); ?></p>

	    </div><!-- /#post-404 -->

	<?php endif; wp_reset_query(); ?>