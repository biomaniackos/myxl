<?php

namespace ACA\GravityForms\Editing\TableRows;

use ACP;

class Entry extends ACP\Editing\Ajax\TableRows {

	public function register() {
		add_action( 'load-forms_page_gf_entries', [ $this, 'handle_request' ] );
	}

}