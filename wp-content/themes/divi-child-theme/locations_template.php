<?php
/*Template Name: Locations Template*/

get_header();

$args=[
	'post_type'=>'location',
	'posts_per_page'=>-1,

];

$locations=new WP_Query($args);?>


<main class="">

	<div class="locations-container">
		<div class="dropdown-filter">
			<div class="js-filter">
				<?php $terms =get_terms(['taxonomy'=>'location_type']); 
				if($terms):?>
				<select name="select_country" id="select_country">
					<option value="">Select Emirate</option>
					<option value="1">Abu Dhabi</option>
					<option value="2">Dubai</option>
				</select>
					<select id="cat" name="cat">
						<option value="">Select Service</option>
						<?php foreach ($terms as $term): ?>
							<option class="<?php echo $term->slug; ?>"><?php echo $term->name ?></option>
						<?php endforeach; ?>
					</select>
				<?php endif;?>
				<div>
				
			</div>
			</div>
			
		</div>


		<?php if($locations->have_posts()) : ?>
			<div class="js-locations row">
				<?php while ($locations-> have_posts()) : $locations->the_post();
					get_template_part('template-parts/loop','locations');
				endwhile;
				?>
			</div>
		<?php endif;?>
	</div>
</main>
<style type="text/css">

/*css of locations template*/

.locations-container {
	width: 80% !important;
	margin: 0 auto !important;
	padding-top: 50px;
	padding-bottom: 50px;

}
.learn_more_locations a,.register_now_btn a {
    background: #000;
    color: #fff;
    border-radius: 3px;
    padding: 7px 10px;
}
.js-locations.row{
	display: flex;
	flex-wrap: wrap;
	
}


@media screen and (min-device-width: 300px) and (max-device-width: 768px) { 
  .locations_btn{
	margin-right:0px !important;	
}
}
.locations_btn a:hover {
    opacity: 0.8;
}
.locations_btn {
    margin-right: 30px;
}

.locations_btn {
    margin-top: 25px;
}
.learn_more_locations {
    margin-right: 10px;
}
.locations_btn{
	display: flex;
	width: 100%;
	justify-content: end;
}

.js-locations.row .column.col-3{
	
	flex-basis: 31%;
	
	
	display: flex;
	flex-direction: column;
	padding: 18px 10px;
}
@media screen and (min-device-width: 300px) and (max-device-width: 768px) { 
	.js-locations.row .column.col-3{

		flex-basis: 100% !important;
	}
	.register_now_btn {
    margin-left: 10px;
}
	.js-filter {
    display: inline !important;
    justify-content: end;
}
.locations-container {
    width: 90% !important;
}
.locations-container {
    width: 96% !important;
}
select#select_country, select#cat {
    width: 85% !important;
    /* text-align: center; */
    justify-content: center;
    margin: 10px auto;
}
.locations-container {
    justify-content: center !important;
    text-align: center;
}
}
	.js-filter {
    display: flex;
    justify-content: center;
}
select#cat,select#select_country {
    width: 300px;
    font-size: 15px;
    margin-right: 10px;
	margin-bottom: 25px;
    padding: 7px 13px;
    border-radius: 4px;
}
	.inner-div{
		display: flex;
		width: 100%;
	}
	.img-div{
		width: 30%;
		text-align: center;
	}
	.img-div img {
    width: 70px !important;
    object-fit: cover;
}
.column.col-3 {
    align-items: center;
}
.column.col-3 {
    justify-content: center;
    
}
.text-div{
	width: 70%;
}
.text-div h4 {
    padding-bottom: 0px;
}
.text-div p {
    font-size: 14px;
}
.inner-div {
    vertical-align: middle;
    display: flex;
    align-items: center;
}
.column.col-3 {
    background: #f8f8f8;
    margin: 6px;
}
.gird,.gird .inner-div{
	width: 100%;
}
.text-div h4 {
    line-height: 1.4em;
}

</style>
<?php
get_footer();
?>