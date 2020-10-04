<?php

/**
 * Escape HTML for page output.
 * Adapted from WordPress core.
 *
 * @param string $html The HTML to be escaped.
 * @return string The escaped HTML.
 */
function esc_html( $html ) {
	return htmlspecialchars( $html, ENT_COMPAT, 'UTF-8' );
}

/**
 * Escape an HTML attribute.
 * Adapted from WordPress core.
 *
 * @param string $attribute The attribute to be escaped.
 * @return string The escaped attribute.
 */
function esc_attr( $attribute ) {
	return htmlspecialchars( $attribute, ENT_COMPAT, 'UTF-8' );
}

/**
 * Set variable as an absolute integer.
 * Adapted from WordPress core.
 *
 * @param int $var The variable to be set as an absolute integer.
 * @return int The absolute integer.
 */
function absint( $var ) {
	return abs( intval( $var ) );
}
