<?php
/**
 * Header floating (mix-blend difference) con wordmark e nav.
 *
 * @package stifanopassarelli
 */

?>
<header class="sp-header">
	<a href="<?php echo esc_url( stifanopassarelli_home_anchor( 'hero' ) ); ?>" class="sp-header__logo" data-cursor-label="<?php esc_attr_e( 'Su', 'stifanopassarelli' ); ?>">
		<img src="<?php echo esc_url( stifanopassarelli_asset_url( 'logo/stifano-passarelli.svg' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
	</a>
	<nav class="sp-nav" aria-label="<?php esc_attr_e( 'Menu principale', 'stifanopassarelli' ); ?>">
		<?php foreach ( stifanopassarelli_nav_items() as $stifanopassarelli_item ) : ?>
			<a href="<?php echo esc_url( $stifanopassarelli_item['href'] ); ?>"><?php echo esc_html( $stifanopassarelli_item['label'] ); ?></a>
		<?php endforeach; ?>
	</nav>
	<button class="sp-burger" type="button" aria-label="<?php esc_attr_e( 'Menu', 'stifanopassarelli' ); ?>"><?php esc_html_e( 'Menu', 'stifanopassarelli' ); ?></button>
</header>
