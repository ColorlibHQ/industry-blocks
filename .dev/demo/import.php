<?php
/**
 * The Industry demo: everything colorlibhub.com/industry-blocks/ shows that
 * the theme itself does not build.
 *
 * The theme's own activation builds the six starter pages and the menu
 * (inc/front-page-setup.php). This adds what a real contractor's site would
 * have on top: the site title and tagline, an author for the byline, six blog
 * posts with categories, tags, featured photographs and a comment, and it
 * removes WordPress's "Hello world!" and "Sample Page".
 *
 * Run it with the theme active, from WP-CLI, as the user PHP runs as:
 *
 *     sudo -u www-data wp --path=/var/www/colorlibhub.com/public \
 *       --url=https://colorlibhub.com/industry-blocks/ \
 *       eval "require '/path/to/demo/import.php';"
 *
 * `wp eval` + `require`, not `wp eval-file`: eval-file runs the file inside a
 * function, where a top-level variable is not a global. Everything below lives
 * in functions anyway, so either works, but require is the tested path.
 *
 * Safe to run twice. Posts are found by slug with get_posts() — never
 * get_page_by_path(), which also matches attachments — and a photograph is
 * uploaded only once, found again by the `_industry_demo_file` meta it is
 * given. The photographs sit in media/ beside this file and are sideloaded from there;
 * none of them ships in the theme zip.
 *
 * The Playground blueprint (.dev/blueprint.json) runs this same file.
 *
 * @package Industry
 */

defined( 'ABSPATH' ) || exit;

require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

if ( ! function_exists( 'industry_demo_log' ) ) {

	/**
	 * Print a line, through WP-CLI when there is one.
	 *
	 * @param string $line Message.
	 */
	function industry_demo_log( $line ) {
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			WP_CLI::log( $line );
		} else {
			echo esc_html( $line ) . "\n";
		}
	}

	/**
	 * The posts. Plain lines: `## ` is a heading, `> words — who` a quote.
	 *
	 * @return array[]
	 */
	function industry_demo_posts() {
		return array(
			array(
				'slug'     => 'bank-holiday-press-rebuild',
				'title'    => 'A press rebuild in seventy-two hours',
				'category' => 'Case studies',
				'tags'     => array( 'hydraulics', 'breakdowns' ),
				'image'    => 'post-rotor.jpg',
				'alt'      => 'An engineer in an orange hard hat and hi-vis vest pointing along a huge machined shaft in a workshop',
				'days'     => 4,
				'excerpt'  => 'A cracked cylinder on a 1,200-tonne press, a bank-holiday weekend and a line that had to run on Tuesday. How the job was planned and done.',
				'body'     => array(
					'At four on a Friday afternoon a supplier of pressed steel panels rang our breakdown line: the main cylinder on their 1,200-tonne press had cracked, and the line fed a car plant that expected parts on Tuesday morning.',
					'## Friday: find out what is actually broken',
					'Two engineers were on site by seven. By midnight the cylinder was out, the crack was measured and photographed, and our fabrication shop had the drawings. A new cylinder would take eleven weeks; a repair would take two days if the shop started at dawn.',
					'> We did not need a meeting. We needed someone to tell us what was going to happen and when, and they did that every four hours. — Fannie Rowe, plant manager',
					'## Saturday and Sunday: machine, weld, test',
					'The shop machined out the damaged section, welded in a new sleeve and pressure-tested it to one and a half times working pressure. On site, the crew replaced every seal and hose they had disturbed rather than reusing them.',
					'## Monday: run it in',
					'The press ran its first trial stroke at two on Monday afternoon and full production at six. A new cylinder is on order, and the repaired one will come out at the planned summer shutdown.',
				),
				'comment'  => array( 'Daniel Osei', 'Useful write-up. We keep a spare seal kit for every press now after a similar weekend last year.' ),
			),
			array(
				'slug'     => 'safety-walk-before-shutdown',
				'title'    => 'The safety walk we do before every shutdown',
				'category' => 'Safety',
				'tags'     => array( 'shutdowns', 'planning' ),
				'image'    => 'post-safety-walk.jpg',
				'alt'      => 'Three engineers in blue overalls and white hard hats walking and talking along a steel mill aisle',
				'days'     => 9,
				'excerpt'  => 'An hour on foot, a clipboard and the plant\'s own operators. Why the most useful part of a shutdown happens a week before it starts.',
				'body'     => array(
					'Every planned shutdown we run starts with the same hour: our site manager, the plant\'s shift leader and one of its operators walk the whole area that will be worked on, a week before the first isolation.',
					'## What the walk finds',
					'Access that is fine on a drawing and impossible with scaffold in the way. A drain that was never on the plans. The valve everyone knows sticks. None of it is dramatic, and all of it would cost a day if we found it with the crew standing there.',
					'## Who has to be there',
					'The operator matters most. They know which guard is awkward to remove and which alarm goes off when it should not, and they will tell a site manager things they would never put in an email.',
					'Everything we find goes into the method statement before it is signed, and every operative reads it at the first briefing.',
				),
			),
			array(
				'slug'     => 'pipe-spools-shop-or-site',
				'title'    => 'Pipe spools: build them in the shop or on site?',
				'category' => 'Engineering',
				'tags'     => array( 'process piping', 'fabrication' ),
				'image'    => 'post-pipe-spool.jpg',
				'alt'      => 'An engineer in a hard hat standing beside the open end of a large steel pipe section in a fabrication hall',
				'days'     => 15,
				'excerpt'  => 'Prefabrication saves time on site, but not always. The four questions we ask before deciding where a spool gets welded.',
				'body'     => array(
					'Most of the process pipework we install is welded in our own shop and arrives on site as spools: lengths with their flanges, bends and branches already in place. It is faster, the welds are easier to inspect, and nobody is welding next to a running line.',
					'## When site welding still wins',
					'Some jobs are better built in place. We ask four questions: can we survey the route accurately; will the spool fit through the doors; is there room to lift it into position; and will the plant move before we install it? Two "no"s and we weld on site.',
					'> A spool that is five millimetres out is scrap. Survey twice, fabricate once. — our fabrication manager',
					'On a typical plant-room job the answer is a mix: long straight runs prefabricated, and the final closing pieces measured and welded on site.',
				),
			),
			array(
				'slug'     => 'steel-frame-in-six-weeks',
				'title'    => 'Standing up a steel frame in six weeks',
				'category' => 'Case studies',
				'tags'     => array( 'steelwork', 'design and build' ),
				'image'    => 'post-steel-frame.jpg',
				'alt'      => 'Rows of steel columns and beams of a new building frame, a load swinging from a crane, in black and white',
				'days'     => 22,
				'excerpt'  => 'How the frame for a harbourside logistics hub went from bare slab to roof sheeting in forty-two working days.',
				'body'     => array(
					'The logistics hub on the harbour is the largest single frame we have erected: 1,100 tonnes of steel over a 14,000 square metre slab, with two tower cranes and a crew of thirty.',
					'## Sequence is everything',
					'We erected from the gable nearest the quay and worked inland, so each bay was braced before the next went up and the cladding crew could follow two bays behind. The cranes never waited for steel, because the shop delivered in erection order.',
					'## Weather days',
					'We lost four days to wind, which we had allowed for. The roof sheeting started on day thirty-nine and the building was watertight a week after the frame was signed off.',
				),
			),
			array(
				'slug'     => 'rooftop-solar-on-an-old-factory',
				'title'    => 'Can an old factory roof take solar panels?',
				'category' => 'Engineering',
				'tags'     => array( 'renewables', 'surveys' ),
				'image'    => 'post-solar-roof.jpg',
				'alt'      => 'Two installers in orange hi-vis and white hard hats kneeling on a roof covered in solar panels, trees behind',
				'days'     => 30,
				'excerpt'  => 'Usually yes, often with some help. What a structural survey looks at before a single panel goes up.',
				'body'     => array(
					'Most manufacturers we work with now ask about rooftop solar. The panels are the easy part. The question is whether a roof built in the 1970s can carry them, and the wind trying to lift them off.',
					'## What we survey',
					'The purlins and their fixings, the condition of the sheeting, the frame\'s original design loads, and the route for cables down to the switchroom. We also look for fragile rooflights, which decide how the installers can move about safely.',
					'## The usual answer',
					'On most portal-frame buildings the frame is fine and the sheeting needs work: either over-cladding or a new roof under the panels. It is far cheaper to do that first than to lift an array off in five years.',
				),
			),
			array(
				'slug'     => 'apprentices-in-the-fab-shop',
				'title'    => 'Six new apprentices in the fabrication shop',
				'category' => 'Company news',
				'tags'     => array( 'apprentices', 'welding' ),
				'image'    => 'post-welding.jpg',
				'alt'      => 'A welder in a mask grinding a steel section on a bench, a shower of sparks lighting the workshop',
				'days'     => 38,
				'excerpt'  => 'Four welders and two pipefitters start their four-year apprenticeships with us this autumn.',
				'body'     => array(
					'This autumn six apprentices joined the fabrication shop: four welder-fabricators and two pipefitters, all starting the same four-year programme our shop manager began himself in 1998.',
					'Each is paired with a senior tradesperson for the first year, spends one day a week at college, and will have worked on site with our installation crews before the end of the second.',
					'We take on apprentices every September. If you know someone who would like to build things for a living, the careers page has the details and our shop manager will happily show anyone round.',
				),
			),
		);
	}

	/**
	 * Turn the plain lines into block markup.
	 *
	 * @param string[] $lines Paragraphs, `## ` headings and `> ` quotes.
	 * @return string
	 */
	function industry_demo_blocks( $lines ) {
		$out = array();
		foreach ( $lines as $line ) {
			if ( 0 === strpos( $line, '## ' ) ) {
				$out[] = "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">" . esc_html( substr( $line, 3 ) ) . "</h2>\n<!-- /wp:heading -->";
			} elseif ( 0 === strpos( $line, '> ' ) ) {
				list( $words, $who ) = array_map( 'trim', explode( '—', substr( $line, 2 ) ) );
				$out[]               = "<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><!-- wp:paragraph -->\n<p>" . esc_html( $words ) . "</p>\n<!-- /wp:paragraph --><cite>" . esc_html( $who ) . "</cite></blockquote>\n<!-- /wp:quote -->";
			} else {
				$out[] = "<!-- wp:paragraph -->\n<p>" . esc_html( $line ) . "</p>\n<!-- /wp:paragraph -->";
			}
		}
		return implode( "\n\n", $out );
	}

	/**
	 * The ID of a post of this type with this slug, in any status, or 0.
	 *
	 * @param string $slug Slug.
	 * @param string $type Post type.
	 * @return int
	 */
	function industry_demo_find( $slug, $type ) {
		$ids = get_posts(
			array(
				'name'             => $slug,
				'post_type'        => $type,
				'post_status'      => array( 'publish', 'draft', 'pending', 'private', 'future' ),
				'posts_per_page'   => 1,
				'fields'           => 'ids',
				'suppress_filters' => true,
			)
		);
		return $ids ? (int) $ids[0] : 0;
	}

	/**
	 * An attachment for one of the photographs next to this file, uploaded once.
	 *
	 * @param string $file    File name in this directory.
	 * @param int    $post_id Post to attach a new upload to.
	 * @param string $title   Attachment title.
	 * @param string $alt     Alt text.
	 * @return int Attachment ID, or 0.
	 */
	function industry_demo_media( $file, $post_id, $title, $alt ) {
		$found = get_posts(
			array(
				'post_type'      => 'attachment',
				'post_status'    => 'inherit',
				'meta_key'       => '_industry_demo_file', // phpcs:ignore WordPress.DB.SlowDBQuery -- a one-off import.
				'meta_value'     => $file, // phpcs:ignore WordPress.DB.SlowDBQuery
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);
		if ( $found ) {
			update_post_meta( $found[0], '_wp_attachment_image_alt', $alt );
			return (int) $found[0];
		}

		$source = __DIR__ . '/media/' . $file;
		if ( ! is_readable( $source ) ) {
			industry_demo_log( "  missing photograph: $file" );
			return 0;
		}

		// media_handle_sideload() moves the file it is given, so hand it a copy.
		$tmp = wp_tempnam( $file );
		copy( $source, $tmp );
		$id = media_handle_sideload(
			array(
				'name'     => $file,
				'tmp_name' => $tmp,
			),
			$post_id,
			$title
		);
		if ( is_wp_error( $id ) ) {
			industry_demo_log( '  upload failed: ' . $file . ' — ' . $id->get_error_message() );
			if ( file_exists( $tmp ) ) {
				wp_delete_file( $tmp );
			}
			return 0;
		}

		update_post_meta( $id, '_wp_attachment_image_alt', $alt );
		update_post_meta( $id, '_industry_demo_file', $file );
		return (int) $id;
	}

	/**
	 * A category by name, created when missing.
	 *
	 * @param string $name Category name.
	 * @return int Term ID, or 0.
	 */
	function industry_demo_category( $name ) {
		$term = term_exists( $name, 'category' );
		if ( ! $term ) {
			$term = wp_insert_term( $name, 'category' );
		}
		return is_array( $term ) ? (int) $term['term_id'] : 0;
	}

	/**
	 * The demo's author, created once and found again by login.
	 *
	 * @return int User ID.
	 */
	function industry_demo_author() {
		$user = get_user_by( 'login', 'industry-helen' );
		if ( $user ) {
			return (int) $user->ID;
		}
		$id = wp_insert_user(
			wp_slash(
				array(
					'user_login'   => 'industry-helen',
					'user_pass'    => wp_generate_password( 32 ),
					'user_email'   => 'helen.carver@industry.invalid',
					'display_name' => 'Helen Carver',
					'first_name'   => 'Helen',
					'last_name'    => 'Carver',
					'nickname'     => 'Helen Carver',
					'description'  => 'Helen is a chartered mechanical engineer and runs our planned-maintenance team.',
					'role'         => 'author',
				)
			)
		);
		if ( is_wp_error( $id ) ) {
			industry_demo_log( 'author failed: ' . $id->get_error_message() . ' — using the first administrator' );
			$admins = get_users(
				array(
					'role'    => 'administrator',
					'number'  => 1,
					'orderby' => 'ID',
					'fields'  => 'ids',
				)
			);
			return $admins ? (int) $admins[0] : 1;
		}
		// On a multisite, the user must belong to this site to be listed.
		if ( is_multisite() ) {
			add_user_to_blog( get_current_blog_id(), $id, 'author' );
		}
		industry_demo_log( 'created author Helen Carver' );
		return (int) $id;
	}

	/**
	 * Run the import.
	 */
	function industry_demo_import() {
		if ( ! function_exists( 'industry_create_front_page' ) ) {
			industry_demo_log( 'Industry is not the active theme on ' . home_url( '/' ) . ' — activate it first. Nothing imported.' );
			return;
		}

		// Site identity. The header prints the site title beside the logo mark.
		update_option( 'blogname', 'Industry' );
		update_option( 'blogdescription', 'Industrial engineering and construction' );

		// The starter pages and menu are the theme's own job. Its function is
		// one-shot and checks every slug, so calling it again only fills in what
		// activation did not get to (for example when it ran before patterns
		// were registered).
		industry_create_front_page();
		industry_demo_log( 'starter pages: ' . get_option( INDUSTRY_SETUP_FLAG ) );

		// WordPress's own sample content.
		foreach ( array( array( 'hello-world', 'post' ), array( 'sample-page', 'page' ) ) as $sample ) {
			$id = industry_demo_find( $sample[0], $sample[1] );
			if ( $id ) {
				wp_delete_post( $id, true );
				industry_demo_log( "removed {$sample[1]} {$sample[0]}" );
			}
		}

		// The blog cards print a byline with an avatar, so the posts get an
		// author of their own. Created, never borrowed: renaming user 1 would
		// rename whoever that is — on colorlibhub, the network's super admin.
		$author = industry_demo_author();

		// Activation from WP-CLI runs with no user, so the starter pages are
		// saved with author 0. Give them the same author as the posts — in the
		// table, not through wp_update_post(): that re-saves the content through
		// kses, which strips the contact page's map <iframe> when there is no user.
		global $wpdb;
		foreach ( array_keys( industry_starter_pages() ) as $slug ) {
			$page = industry_demo_find( $slug, 'page' );
			if ( $page && ! (int) get_post_field( 'post_author', $page ) ) {
				$wpdb->update( $wpdb->posts, array( 'post_author' => $author ), array( 'ID' => $page ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery
				clean_post_cache( $page );
			}
		}

		foreach ( industry_demo_posts() as $post ) {
			$id = industry_demo_find( $post['slug'], 'post' );

			if ( ! $id ) {
				$id = wp_insert_post(
					wp_slash(
						array(
							'post_title'    => $post['title'],
							'post_name'     => $post['slug'],
							'post_excerpt'  => $post['excerpt'],
							'post_content'  => industry_demo_blocks( $post['body'] ),
							'post_status'   => 'publish',
							'post_author'   => $author,
							'post_date'     => wp_date( 'Y-m-d H:i:s', time() - $post['days'] * DAY_IN_SECONDS ),
							'post_category' => array( industry_demo_category( $post['category'] ) ),
							'tags_input'    => $post['tags'],
						)
					),
					true
				);
				if ( is_wp_error( $id ) ) {
					industry_demo_log( 'post failed: ' . $post['slug'] . ' — ' . $id->get_error_message() );
					continue;
				}
				industry_demo_log( 'created post ' . $post['slug'] );
			} else {
				industry_demo_log( 'kept post ' . $post['slug'] );
			}

			if ( ! has_post_thumbnail( $id ) ) {
				$media = industry_demo_media( $post['image'], $id, $post['title'], $post['alt'] );
				if ( $media ) {
					set_post_thumbnail( $id, $media );
				}
			}

			if ( ! empty( $post['comment'] ) ) {
				list( $who, $words ) = $post['comment'];
				$has                 = get_comments(
					array(
						'post_id'      => $id,
						'search'       => $words,
						'count'        => true,
					)
				);
				if ( ! $has ) {
					wp_insert_comment(
						wp_slash(
							array(
								'comment_post_ID'  => $id,
								'comment_author'   => $who,
								'comment_content'  => $words,
								'comment_approved' => 1,
								'comment_date'     => wp_date( 'Y-m-d H:i:s', time() - ( $post['days'] - 1 ) * DAY_IN_SECONDS ),
							)
						)
					);
				}
			}
		}

		$count = wp_count_posts( 'post' );
		industry_demo_log( sprintf( 'done: %d published posts, %d pages', $count->publish, wp_count_posts( 'page' )->publish ) );
	}
}

industry_demo_import();
