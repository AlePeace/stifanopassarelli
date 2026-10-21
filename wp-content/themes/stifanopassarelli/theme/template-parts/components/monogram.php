<?php
/**
 * Il pittogramma: la O (Emanuele) che racchiude la e a tre tessere (Carla).
 * SVG ufficiali della grafica (assets/logo/), viewBox 0 0 214 252.
 *
 * Args:
 * - `parts`: 'all' (default), 'o' o 'e'.
 * - `class`: classi dell'<svg>.
 *
 * @package stifanopassarelli
 */

$stifanopassarelli_parts = isset( $args['parts'] ) ? $args['parts'] : 'all';
$stifanopassarelli_class = isset( $args['class'] ) ? $args['class'] : '';
?>
<svg<?php echo $stifanopassarelli_class ? ' class="' . esc_attr( $stifanopassarelli_class ) . '"' : ''; ?> viewBox="0 0 214 252" fill="none" aria-hidden="true">
	<?php if ( 'o' !== $stifanopassarelli_parts ) : ?>
		<path fill="currentColor" d="M118.669 55.3227L72.6776 90.2766L77.3101 95.3958L134.062 66.3175L118.669 55.3227Z"/>
		<path fill="currentColor" d="M128.796 121.986L86.3513 123.199L86.1275 131.063L128.434 134.689L128.796 121.986Z"/>
		<path fill="currentColor" d="M76.7959 166.812L130.591 174.809L130.301 195.99L75.6532 171.213L76.7959 166.812Z"/>
	<?php endif; ?>
	<?php if ( 'e' !== $stifanopassarelli_parts ) : ?>
		<path fill="currentColor" d="M0 126.686C0 51.6689 43.9017 0.09198 106.924 0.09198C169.946 0.09198 213.5 48.9856 213.5 125.35C213.5 201.713 169.598 251.944 106.248 251.944C42.8971 251.944 0 203.046 0 126.686ZM192.052 126.016C192.052 58.3628 159.876 4.7782 106.253 4.7782C52.6287 4.7782 21.4486 56.3551 21.4486 126.016C21.4486 195.676 53.9666 247.253 106.919 247.253C159.872 247.253 192.047 195.676 192.047 126.016H192.052Z"/>
	<?php endif; ?>
</svg>
