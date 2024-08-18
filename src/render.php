<?php

/**
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
?>
<?php
// Block content.
$terms = get_terms(
	array(
		'taxonomy'   => 'solution-category',
		'hide_empty' => false,
	)
);

// echo "<pre>";
// print_r($terms);
// exit;
$args = array(
	'post_type' => 'solution',
	'posts_per_page' => -1, // Fetch all posts
);
$query = new WP_Query($args);

// Start output buffering
ob_start();

if (is_array($terms) && count($terms) > 0) {
	echo '<ul class="solution-categories">';
	echo '<li class="solution-category">';
	echo '<a class="solution-category-anchor" data-solution-category="all" href="#">All</a>';
	echo '</li>';
	foreach ($terms as $term) {
		echo '<li class="solution-category">';
		echo '<a class="solution-category-anchor" data-solution-category="' . $term->name . '" href="#">' . $term->name . '</a>';
		echo '</li>';
	}
	echo '</ul>';
}

if ($query->have_posts()) {
	echo '<div class="cards">';

	while ($query->have_posts()) {
		$query->the_post();
		$fields = get_fields(get_the_ID());
		$solutionCategories = get_the_terms(get_the_ID(), 'solution-category');

		$dataSolutionCategories = '';
		if (is_array($solutionCategories)) {
			foreach ($solutionCategories as $key => $value) {
				$dataSolutionCategories .= $value->name . ', ';
			}
		}

		// echo '<li itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">';
		// echo '<a href="' . get_permalink() . '" itemprop="url">';
		// echo '<span itemprop="headline">' . get_the_title() . '</span>';
		// echo '</a>';
		// echo '<p itemprop="description">' . $fields['sub_title'] . '</p>';
		// echo '<p itemprop="description">' . $fields['description'] . '</p>';
		// echo '<img src="' . $fields['icon_1']['url'] . '" />';
		// echo '</li>';

		$description = $fields['description'];
		$description = strlen($description) > 300 ? substr($description, 0, 100) . '...' : $description;
		// echo '<li class="solution-list-item">';
		// echo '<div class="card solution" data-solution_categories="' . $dataSolutionCategories . '">';
		// // echo '<img src="' . $fields['icon_1']['url'] . '" alt="Product Image" class="product-image">';
		// echo '<div class="card-content">';
		// echo '<span>';
		// echo '<h2 class="product-title">' . $fields['title'] . '</h2>';
		// echo    '<ul class="product-details">';
		// echo        '<li>' . $description . '</li>';
		// echo   		'<li><a class="solution-details-link" href="#">Learn More</a></li>';
		// echo    '</ul>';
		// echo  '</span>';

		// // echo '<button class="add-to-cart">&rarr;</button>';
		// echo '</div>';
		// echo '</div>';
		// echo '</li>';
		$primaryCategory = 'General';
		if (is_array($solutionCategories)) {
			$primaryCategory = $solutionCategories[0]->name;
		}

		echo '<div class="cards-inner solution" data-solution_categories="' . $dataSolutionCategories . '">';
		echo '<div class"card-content">';
		echo '<h4>' . $fields['title'] . '</h4>';
		echo '<small>' . $primaryCategory . '</small>';
		echo '<p>' . $description . '</p>';
		echo '<div>';
		echo '<br><a class="solution-details-link" href="#">Learn More</a>';
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}

	echo '</div>';
} else {
	echo '<p>No posts found.</p>';
}

// Reset post data
wp_reset_postdata();
?>


<style>
	.container h3 {
		padding: 0 0 30px 30px;
	}

	/* Cards */
	.cards {
		display: grid;
		grid-template-columns: 1fr;
		gap: 40px;
		margin-top: 30px;
		padding: 0 30px 50px;
	}

	.cards .cards-inner {
		display: flex;
		flex-direction: column;
		align-items: flex-start;
		justify-content: space-between;
		padding: 20px;
		border-radius: 5px;
		transition: box-shadow 0.4s;
		border: 1px solid #000;
	}

	.cards .cards-inner:hover {
		box-shadow: 0 5px 20px rgba(1, 45, 128, 0.5);
	}

	.cards .cards-inner div {
		margin-bottom: 10px;
		/* Add margin between elements */
	}

	.cards .cards-inner div {
		display: flex;
		flex-direction: column;
		width: 100%;
	}

	.cards .cards-inner h4 {
		margin: 0 0 10px 0;
		flex: 1;
		min-height: 65px !important;
		max-height: 75px !important;
		/* Ensure margin around the title */
	}

	.cards .cards-inner div i {
		margin-right: 20px;
		font-size: 24px;
	}

	.cards .cards-inner div p {
		margin-top: 20px;
		line-height: 1.6;
		font-size: 14px;
	}

	.cards .cards-inner p {
		margin: 0;
		/* Ensure no extra margin around the paragraph */
	}

	/* .is-layout-constrained> :where(:not(.alignleft):not(.alignright):not(.alignfull)) {
		max-width: 100% !important;
		margin-left: auto !important;
		margin-right: auto !important;
	} */

	.solution-details-link {
		padding: 5px 6px;
		border-radius: 5px;
		text-decoration: none;
		background-color: #000;
		color: #fff;
		font-size: 14px;
		text-align: center;
	}

	.solution-details-link:hover {
		background-color: #fff;
		color: #000;
		border: 1px solid #000;
	}

	.card-content {
		display: flex;
		flex-direction: column;
		justify-content: space-between;
	}

	.solution-categories {
		list-style: none;
		display: flex;
		justify-content: center;
		padding: 0;
		margin: 5px 10px;
		margin-bottom: 5%;
		margin-top: 5%;
	}

	.solution-categories li {
		margin-right: 10px;
		border: 1.5px solid #000;
		padding: 5px 10px;
		border-radius: 5px;

	}

	.solution-categories li a {
		text-decoration: none;
		color: #000;
	}

	@media (min-width: 600px) {
		main h1 {
			max-width: 500px;
			margin: auto;
		}

		.cards {
			grid-template-columns: repeat(2, 1fr);
		}
	}

	@media (min-width: 912px) {
		.cards {
			grid-template-columns: repeat(3, 1fr);
		}
	}

	@media (min-width: 1200px) {
		.container {
			max-width: 1100px;
			margin: auto;
		}
	}
</style>