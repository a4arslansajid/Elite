
<div class="gird column col-3">
	<div class="inner-div">
		
			<div class="img-div">
			<?php if(has_post_thumbnail()):?>
				<picture><img src="<?php the_post_thumbnail_url();?>"></picture>
			<?php endif;?>
		</div>
		<div style="display: inline;" class="text-div">
			<h4><?php the_title(); ?></h4>
			<?php the_excerpt();?>
			
		</div>
		
	</div>
	<div class="locations_btn">
			<div class="learn_more_locations">
				<a href="<?php the_permalink();?>">Learn More</a>
			</div>
			<div class="register_now_btn">
				<a href="<?php the_field('register_button_url'); ?>">Book Now</a>
			</div>
		</div>
</div>
