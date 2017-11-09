<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Defines the custom post type(s).
 *
 * @package       OddsConverter
 * @subpackage    OddsConverter/admin
 * @author        Merxhan Emini <https://symphony-solutions.eu>
 */

if( ! class_exists( 'OddsConverter_Post_Types' ) ) {

	class OddsConverter_Post_Types {

		/**
		 * Register the "item" custom post type.
		 *
		 * @link https://developer.wordpress.org/reference/functions/register_post_type
		 */
		public function register_type_item() {

			$labels = array(
				'name'                  => _x( 'Items', 'Post Type General Name', 'oddsconverter' ),
				'singular_name'         => _x( 'Item', 'Post Type Singular Name', 'oddsconverter' ),
				'menu_name'             => __( 'Items', 'oddsconverter' ),
				'name_admin_bar'        => __( 'Item', 'oddsconverter' ),
				'archives'              => __( 'Item Archives', 'oddsconverter' ),
				'attributes'            => __( 'Item Attributes', 'oddsconverter' ),
				'parent_item_colon'     => __( 'Parent Item:', 'oddsconverter' ),
				'all_items'             => __( 'All Items', 'oddsconverter' ),
				'add_new_item'          => __( 'Add New Item', 'oddsconverter' ),
				'add_new'               => __( 'Add New', 'oddsconverter' ),
				'new_item'              => __( 'New Item', 'oddsconverter' ),
				'edit_item'             => __( 'Edit Item', 'oddsconverter' ),
				'update_item'           => __( 'Update Item', 'oddsconverter' ),
				'view_item'             => __( 'View Item', 'oddsconverter' ),
				'view_items'            => __( 'View Items', 'oddsconverter' ),
				'search_items'          => __( 'Search Item', 'oddsconverter' ),
				'not_found'             => __( 'Not found', 'oddsconverter' ),
				'not_found_in_trash'    => __( 'Not found in Trash', 'oddsconverter' ),
				'featured_image'        => __( 'Featured Image', 'oddsconverter' ),
				'set_featured_image'    => __( 'Set featured image', 'oddsconverter' ),
				'remove_featured_image' => __( 'Remove featured image', 'oddsconverter' ),
				'use_featured_image'    => __( 'Use as featured image', 'oddsconverter' ),
				'insert_into_item'      => __( 'Insert into item', 'oddsconverter' ),
				'uploaded_to_this_item' => __( 'Uploaded to this item', 'oddsconverter' ),
				'items_list'            => __( 'Items list', 'oddsconverter' ),
				'items_list_navigation' => __( 'Items list navigation', 'oddsconverter' ),
				'filter_items_list'     => __( 'Filter items list', 'oddsconverter' )
			);

			$supports = array(
				'title',
				'editor',
				'author',
				'thumbnail',
				'excerpt',
				'custom-fields',
				'comments',
				'revisions',
				'post-formats',
			);

			$args = array(
				'labels'                => $labels,
				'description'           => __( 'Item Description', 'oddsconverter' ),
				'public'                => true,
				'hierarchical'          => false,
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'show_in_nav_menus'     => true,
				'show_in_admin_bar'     => true,
				'show_in_rest'          => false,
				'menu_position'         => 5,
				'menu_icon'             => 'dashicons-tag',
				'capability_type'       => 'post',
				'supports'              => $supports,
				'taxonomies'            => array(),
				'has_archive'           => 'items',
				'can_export'            => true,
				'rewrite'               => array(
					'slug'       => 'item',
					'with_front' => false,
					'pages'      => true,
				),
			);

			register_post_type( 'item', $args );

		}

		/**
		 * Register the "item_category" taxonomy.
		 *
		 * @link https://developer.wordpress.org/reference/functions/register_taxonomy
		 */
		public function register_taxonomy_item_category() {

			$labels = array(
				'name'                       => _x( 'Categories', 'Taxonomy General Name', 'oddsconverter' ),
				'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'oddsconverter' ),
				'menu_name'                  => __( 'Categories', 'oddsconverter' ),
				'all_items'                  => __( 'All Categories', 'oddsconverter' ),
				'edit_item'                  => __( 'Edit Category', 'oddsconverter' ),
				'view_item'                  => __( 'View Tag' ),
				'update_item'                => __( 'Update Category', 'oddsconverter' ),
				'add_new_item'               => __( 'Add New Category', 'oddsconverter' ),
				'new_item_name'              => __( 'New Category Name', 'oddsconverter' ),
				'parent_item'                => __( 'Parent Category', 'oddsconverter' ),
				'parent_item_colon'          => __( 'Parent Category:', 'oddsconverter' ),
				'search_items'               => __( 'Search Categories', 'oddsconverter' ),
				'popular_items'              => __( 'Popular Categories', 'oddsconverter' ),
				'separate_items_with_commas' => __( 'Separate Categories with commas', 'oddsconverter' ),
				'add_or_remove_items'        => __( 'Add or remove Categories', 'oddsconverter' ),
				'choose_from_most_used'      => __( 'Choose from the most used Categories', 'oddsconverter' ),
				'not_found'                  => __( 'No Categories found.', 'oddsconverter' )
			);

			$args = array(
				'labels'             => $labels,
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'show_in_nav_menus'  => true,
				'show_in_rest'       => false,
				'show_tagcloud'      => true,
				'show_in_quick_edit' => true,
				'show_admin_column'  => false,
				'description'        => __( 'Category Description', 'oddsconverter' ),
				'hierarchical'       => true,
				'query_var'          => 'item_category',
				'rewrite'            => array(
					'slug'       => 'item-category',
					'with_front' => true
				)
			);

			register_taxonomy( 'item_category', array( 'item' ), $args );

		}

	}

}
