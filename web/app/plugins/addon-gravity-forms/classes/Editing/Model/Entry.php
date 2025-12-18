<?php

namespace ACA\GravityForms\Editing\Model;

use ACA\GravityForms\Column;
use ACA\GravityForms\Field\Field;
use ACP;
use GFAPI;

/**
 * @property Column\Entry $column
 */
class Entry extends ACP\Editing\Model {

	/**
	 * @var string
	 */
	protected $field_id;

	/**
	 * @var Field
	 */
	protected $field;

	public function __construct( Column\Entry $column, $field_id, Field $field ) {
		parent::__construct( $column );

		$this->field_id = (string) $field_id;
		$this->field = $field;
	}

	public function get_view_settings() {
		$data = parent::get_view_settings();

		if ( $this->field->is_required() ) {
			$data['required'] = true;
		} else {
			$data['clear_button'] = true;
		}

		return $data;
	}

	public function save( $id, $value ) {
		GFAPI::update_entry_field( $id, $this->field_id, $value );
	}

}