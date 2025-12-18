<?php

namespace ACA\GravityForms\Field\Type;

use ACA\GravityForms;

class Number extends Input implements GravityForms\Field\Number {

	private function get_range( $key ) {
		return $this->gf_field->offsetExists( $key ) && $this->gf_field->offsetGet( $key )
			? $this->gf_field->offsetGet( $key )
			: '';
	}

	public function get_range_min() {
		return $this->get_range( 'rangeMin' );
	}

	public function get_range_max() {
		return $this->get_range( 'rangeMax' );
	}

	public function get_step() {
		return 'any';
	}

}