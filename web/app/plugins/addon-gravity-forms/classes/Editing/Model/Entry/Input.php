<?php

namespace ACA\GravityForms\Editing\Model\Entry;

use ACA\GravityForms\Column;
use ACA\GravityForms\Editing;
use ACA\GravityForms\Field\Field;

class Input extends Editing\Model\Entry {

	/**
	 * @var string
	 */
	private $input_type;

	public function __construct( Column\Entry $column, $field_id, Field $field, $input_type ) {
		parent::__construct( $column, $field_id, $field );

		$this->input_type = (string) $input_type;
	}

	public function get_view_settings() {
		return array_merge( parent::get_view_settings(), [
			'type' => $this->input_type,
		] );
	}

}