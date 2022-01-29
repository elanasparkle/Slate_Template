<?php

/**
 * SA Template Name: My Custom Template
 *
 */

do_action( 'pre_si_invoice_view' ); ?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<?php si_head(); ?>
		<meta name="robots" content="noindex, nofollow" />
	</head>

	<body id="invoice" <?php body_class( 'web_view si_slate_theme' ); ?>>

		<div id="outer_doc_wrap">

			<?php si_display_messages(); ?>

			<?php do_action( 'si_invoice_outer_doc_wrap' ) ?>

			<?php if ( si_get_invoice_balance() ) : ?>
				<?php do_action( 'si_payments_pane' ); ?>
			<?php endif ?>

			<div id="doc_header_wrap" class="sticky_header">

				<?php do_action( 'si_doc_header_start' ) ?>

				<header id="header_title">

					<span class="header_id"><?php the_title() ?></span>

					<div id="doc_actions">

						<?php do_action( 'si_doc_actions_pre' ) ?>

						<?php if ( si_get_invoice_balance() && 'write-off' !== si_get_invoice_status() ) : ?>

							<?php
								$payment_string = ( si_has_invoice_deposit( get_the_id(), true ) ) ? __( 'Pay Deposit', 'sprout-invoices' ) : __( 'Pay Invoice', 'sprout-invoices' );
								?>
							<?php do_action( 'si_invoice_payment_button', get_the_ID(), $payment_string ) ?>

						<?php endif ?>

						<?php do_action( 'si_doc_actions' ) ?>

					</div><!-- #doc_actions -->

				</header><!-- #header_title -->

				<?php do_action( 'si_doc_header_end' ) ?>

			</div><!-- #doc_header_wrap -->

			<div id="document_wrap">

				<div id="doc">

					<section id="header_wrap" class="clearfix">

						<div id="vcards">

							<?php do_action( 'si_document_vcards_pre' ) ?>

							<?php if ( si_get_invoice_client_id() ) : ?>
								<div id="sent_to_invoice">
									<b><?php echo esc_html( get_the_title( si_get_invoice_client_id() ) ) ?></b>
									<?php do_action( 'si_document_client_addy' ) ?>
									<?php si_client_address( si_get_invoice_client_id() ) ?>
								</div><!-- #sent_to_invoice -->
							<?php endif ?>

							<div id="sent_from_invoice">

								<div id="inner_logo">
									<?php if ( get_theme_mod( 'si_logo' ) ) : ?>
										<img src="<?php echo esc_url( get_theme_mod( 'si_logo', si_doc_header_logo_url() ) ); ?>" alt="document logo" >
									<?php else : ?>
										<img src="<?php echo esc_url( si_doc_header_logo_url() ) ?>" alt="document logo" >
									<?php endif; ?>
								</div>

							</div><!-- #sent_from_invoice -->

							<div id="sent_from_company">
								<b><?php si_company_name() ?></b>
								<?php si_doc_address() ?>
							</div>

							<?php do_action( 'si_document_vcards' ) ?>

						</div><!-- #vcards -->

						<div class="doc_details clearfix">

							<?php do_action( 'si_document_details_pre' ) ?>

							<dl class="date">
								<dt><span class="dt_heading"><span class="dashicons dashicons-calendar-alt"></span><?php esc_html_e( 'Date', 'sprout-invoices' ) ?></span></dt>
								<dd><?php si_invoice_issue_date() ?></dd>
							</dl>

							<?php if ( si_get_invoice_id() ) : ?>
								<dl class="invoice_number">
									<dt><span class="dt_heading"><span class="dashicons dashicons-tag"></span><?php esc_html_e( 'Invoice Number', 'sprout-invoices' ) ?></span></dt>
									<dd><?php si_invoice_id() ?></dd>
								</dl>
							<?php endif ?>

							<?php if ( si_get_invoice_po_number() ) : ?>
								<dl class="invoice_po_number">
									<dt><span class="dt_heading"><span class="dashicons dashicons-clipboard"></span><?php esc_html_e( 'PO Number', 'sprout-invoices' ) ?></span></dt>
									<dd><?php si_invoice_po_number() ?></dd>
								</dl>
							<?php endif ?>

							<?php if ( si_get_invoice_due_date() ) : ?>
								<dl class="date">
									<dt><span class="dt_heading"><span class="dashicons dashicons-flag"></span><?php esc_html_e( 'Invoice Due', 'sprout-invoices' ) ?></span></dt>
									<dd><?php si_invoice_due_date() ?></dd>
								</dl>
							<?php endif ?>

							<?php do_action( 'si_document_details_totals' ) ?>

							<?php if ( si_has_invoice_deposit( get_the_id(), true ) ) : ?>
								<dl class="doc_total_with_deposit doc_total doc_balance">
									<dt><span class="dt_heading"><span class="dashicons dashicons-money"></span><?php esc_html_e( 'Invoice Total', 'sprout-invoices' ) ?></span></dt>
									<dd><?php sa_formatted_money( si_get_invoice_total() ) ?></dd>
								</dl>

								<dl class="doc_total doc_balance">
									<dt><span class="dt_heading"><span class="dashicons dashicons-warning"></span><?php esc_html_e( 'Payment Due', 'sprout-invoices' ) ?></span></dt>
									<dd><?php sa_formatted_money( si_get_invoice_deposit( get_the_id(), true ) ) ?></dd>
								</dl>
							<?php else : ?>
								<dl class="doc_total doc_balance">
									<dt><span class="dt_heading"><span class="dashicons dashicons-money"></span><?php esc_html_e( 'Invoice Total', 'sprout-invoices' ) ?></span></dt>
									<dd><?php sa_formatted_money( si_get_invoice_total() ) ?></dd>
								</dl>
							<?php endif ?>

							<dl class="doc_total doc_balance">
								<dt><span class="dt_heading"><span class="dashicons dashicons-chart-pie"></span><?php esc_html_e( 'Balance', 'sprout-invoices' ) ?></span></dt>
								<dd><?php sa_formatted_money( si_get_invoice_balance() ) ?></dd>
							</dl>

							<?php do_action( 'si_document_details' ) ?>
						</div><!-- #doc_details -->

					</section>

					<section id="doc_line_items_wrap" class="clearfix">

						<div id="doc_line_items" class="clearfix">

							<?php do_action( 'si_doc_line_items', get_the_id() ) ?>

							<div id="header_status" class="clearfix">
								<?php if ( 'write-off' === si_get_invoice_status() ) : ?>
									<span id="status" class="void"><span class="inner_status"><?php esc_html_e( 'Void', 'sprout-invoices' ) ?></span></span>
								<?php elseif ( ! si_get_invoice_balance() ) : ?>
									<span id="status" class="paid"><span class="inner_status"><?php esc_html_e( 'Paid', 'sprout-invoices' ) ?></span></span>
								<?php else : ?>
									<span id="status" class="void"><span class="inner_status"><?php esc_html_e( 'Payment Pending', 'sprout-invoices' ) ?></span></span>
								<?php endif ?>
							</div><!-- #header_status -->

						</div><!-- #doc_line_items -->

					</section>

					<section id="doc_notes">
						<?php if ( strlen( si_get_invoice_notes() ) > 1 ) : ?>
						<?php do_action( 'si_document_notes' ) ?>
						<div id="doc_notes">
							<h2><?php esc_html_e( 'Notes', 'sprout-invoices' ) ?></h2>
							<?php si_invoice_notes() ?>
						</div><!-- #doc_notes -->

						<?php endif ?>

						<?php if ( strlen( si_get_invoice_terms() ) > 1 ) : ?>
						<?php do_action( 'si_document_terms' ) ?>
						<div id="doc_terms">
							<h2><?php esc_html_e( 'Terms', 'sprout-invoices' ) ?></h2>
							<?php si_invoice_terms() ?>
						</div><!-- #doc_terms -->

						<?php endif ?>

					</section>

					<?php do_action( 'si_doc_wrap_end' ) ?>

				</div><!-- #doc -->

				<div id="footer_wrap">
					<?php do_action( 'si_document_footer' ) ?>
					<aside>
						<ul class="doc_footer_items">
							<?php if ( si_get_company_email() ) : ?>
								<li class="doc_footer_item">
									<?php echo wp_kses( make_clickable( si_get_company_email() ), kses_si_front_end_line_item() ); ?>
								</li>
							<?php endif ?>
						</ul>
					</aside>
				</div><!-- #footer_wrap -->

			</div><!-- #document_wrap -->

		</div><!-- #outer_doc_wrap -->


		<div id="footer_credit">
			<?php do_action( 'si_document_footer_credit' ) ?>
			<!--<p><?php esc_html_e( 'Powered by Sprout Invoices', 'sprout-invoices' ) ?></p>-->
		</div><!-- #footer_messaging -->

	</body>
	<?php do_action( 'si_document_footer' ) ?>
	<?php si_footer() ?>
	<!-- Template Version 9.2.2 -->
</html>
<?php do_action( 'invoice_viewed' ) ?>
