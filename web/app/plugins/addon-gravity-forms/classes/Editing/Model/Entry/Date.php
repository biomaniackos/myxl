<?php

namespace ACA\GravityForms\Editing\Model\Entry;

use ACA\GravityForms\Editing;

class Date extends Editing\Model\Entry {

	public function get_edit_value( $id ) {
		$value = $this->get_column()->get_raw_value( $id );

		return $value ?: false;
	}

	public function get_view_settings() {
		return wp_parse_args( [
			'type' => 'date',
		], parent::get_view_settings() );
	}

}