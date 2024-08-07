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
	foreach ($terms as $term) {
		echo '<li class="solution-category">';
		echo '<a class="solution-category-anchor" data-solution-category="' . $term->name . '" href="#">' . $term->name . '</a>';
		echo '</li>';
	}
	echo '</ul>';
}

if ($query->have_posts()) {


	echo '<ul class="product-grid" itemscope itemtype="https://schema.org/Blog">';
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
		$description = strlen($description) > 100 ? substr($description, 0, 100) . '...' : $description;
		echo '<li class="solution-list-item">';
		echo '<div class="card solution" data-solution_categories="' . $dataSolutionCategories . '">';
		// echo '<img src="' . $fields['icon_1']['url'] . '" alt="Product Image" class="product-image">';
		echo '<div class="card-content">';
		echo '<span>';
		echo '<h2 class="product-title">' . $fields['title'] . '</h2>';
		echo    '<ul class="product-details">';
		echo        '<li>' . $description . '</li>';
		echo   		'<li><a class="solution-details-link" href="#">Learn More</a></li>';
		echo    '</ul>';
		echo  '</span>';

		// echo '<button class="add-to-cart">&rarr;</button>';
		echo '</div>';
		echo '</div>';
		echo '</li>';
	}
	echo '</ul>';
} else {
	echo '<p>No posts found.</p>';
}

// Reset post data
wp_reset_postdata();
?>


<style>
	.product-grid {
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
		gap: 16px;
		/* Adjust the gap between grid items as needed */
		list-style: none;
		padding: 0;
		margin: 0;
		margin-top: 5%;
	}

	.card {
		background-color: #fff;
		border-radius: 10px;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		overflow: hidden;
		display: flex;
		/* width: 300px; */
		border: 1px solid #ddd;
	}

	.product-image {
		width: 100px;
		height: auto;
		margin: 10px;
	}

	.card-content {
		padding: 10px;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
	}

	.product-title {
		font-size: 1rem;
		font-family: inherit;
		margin: 0 0 10px 0;
		text-align: center;
		color: #333;
	}

	.product-details {
		list-style: none;
		padding: 0;
		margin: 0 0 10px 0;
		color: #777;
	}

	.product-details li {
		margin-top: 10%;
		font-size: 14px;
		line-height: 1rem;
		text-align: center;
	}

	.add-to-cart {
		background-color: black;
		color: white;
		border: none;
		border-radius: 50%;
		width: 30px;
		height: 30px;
		display: flex;
		justify-content: center;
		align-items: center;
		font-size: 20px;
		cursor: pointer;
		margin-left: auto;
	}

	.solution-categories {
		list-style: none;
		display: flex;
		justify-content: center;
		padding: 0;
		margin: 5px 10px;
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

	.solution-list-item {
		width: 20vw;
	}

	.solution-details-link {
		margin-right: 10px;
		border: 1.5px solid #000;
		padding: 10px 15px;
		border-radius: 5px;
		text-decoration: none;
		background-color: #000;
		color: #fff;
	}

	@media (max-width: 768px) {
		.solution-list-item {
			width: 50vw;
		}
	}

	@media (max-width: 480px) {
		.solution-list-item {
			width: 100vw;
		}
	}
</style>