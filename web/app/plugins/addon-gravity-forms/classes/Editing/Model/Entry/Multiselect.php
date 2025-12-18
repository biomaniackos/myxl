<?php

namespace ACA\GravityForms\Editing\Model\Entry;

use ACA\GravityForms\Column;
use ACA\GravityForms\Editing;
use ACA\GravityForms\Field\Field;
use GF_Field_MultiSelect;

class Multiselect extends Editing\Model\Entry {

	/**
	 * @var array
	 */
	private $choices;

	public function __construct( Column\Entry $column, $field_id, Field $field, array $choices ) {
		parent::__construct( $column, $field_id, $field );

		$this->choices = $choices;
	}

	public function get_view_settings() {
		$settings = parent::get_view_settings();

		$settings['type'] = 'select2_dropdown';
		$settings['multiple'] = true;
		$settings['options'] = $this->choices;

		return $settings;
	}

	public function get_edit_value( $id ) {
		return ( new GF_Field_MultiSelect )->to_array( $this->column->get_entry_value( $id ) );
	}

	public function save( $id, $value ) {
		return parent::save( $id, json_encode( $value ) );
	}

}