<?php

namespace ACA\GravityForms\Field\Type;

use ACA\GravityForms\Field\Field;

class Input extends Field {

	/**
	 * @return string
	 */
	public function get_input_type() {
		$type = $this->gf_field->offsetGet( 'type' );

		if( in_array( $type, ['post_excerpt','post_content']) ){
			$type = 'textarea';
		}

		if ( $type === 'website' ) {
			$type = 'url';
		}

		if ( ! $type ) {
			$type = 'text';
		}

		return $type;
	}

}