<?php


namespace app\validation;

use app\models\admin;
use Respect\Validation\Validator as val;

class event_settings extends validation {

	public function __construct() {

		// start fresh
		$this->errors = null;
	}



	public function __invoke( $post ) {

		$str = val::stringType()
		          ->length( 1, 255 );

		$int = val::intVal();

		$w_h = val::optional(val::intVal());

		$checkb = val::equals( "on" );

		$logo_pos = val::in( [ 'left', 'centre', 'right' ] )->setName( "Logo position" );

		$logo_size = val::in( [ 'small', 'medium', 'large' ] )->setName( "Logo size" );

		$theme = val::in( [ 'light', 'dark' ] );

		$web_fonts = val::in( [ 'Arial', 'Helvetica', 'Times New Roman', 'Courier New', 'Verdana', 'Georgia' ] );


		try {

			// title
			$title = $str->setName( "Page title" )->notEmpty();
			$this->validate( $title, $post[ 'page_title' ], 'page_title' );

			// position
			$this->validate( $logo_pos, $post[ 'logo_position' ], "logo_position" );

			// logo size
			$this->validate( $logo_size, $post[ 'logo_size' ], "logo_size" );

			// hide columns
			if( isset($post['hide_first_name']) ) $this->validate( $checkb->setName("Hide First Name"), $post['hide_first_name'], 'hide_first_name');
			if( isset($post['hide_last_name']) ) $this->validate( $checkb->setName("Hide Last Name"), $post['hide_last_name'], 'hide_last_name');
			if( isset($post['hide_job_title']) ) $this->validate( $checkb->setName("Hide Job Title"), $post['hide_job_title'], 'hide_job_title');
			if( isset($post['hide_company']) ) $this->validate( $checkb->setName("Hide Company"), $post['hide_company'], 'hide_company');
			if( isset($post['hide_table_no']) ) $this->validate( $checkb->setName("Hide Table Number"), $post['hide_table_no'], 'hide_table_no');


			// rename columns

			$this->validate( val::optional( $str ), $post[ 'rename_first_name' ], "rename_first_name" );
			$this->validate( val::optional( $str ), $post[ 'rename_last_name' ], "rename_last_name" );
			$this->validate( val::optional( $str ), $post[ 'rename_company' ], "rename_company" );
			$this->validate( val::optional( $str ), $post[ 'rename_table_no' ], "rename_table_no" );
			$this->validate( val::optional( $str ), $post[ 'rename_job_title' ], "rename_job_title" );

			//font
			$font = $web_fonts->setName( "Web fonts" );
			$this->validate( $font, $post[ 'font' ], "font" );

			// theme
			$t = $theme->setName( "Theme" );
			$this->validate( $t, $post[ 'theme' ], "theme" );

		} catch( \Exception $e ) {
			$this->errors["general"] = "There is a problem with the form data, please report this to the Digital department. ";
		}


		if( $this->errors ) {
			return false;
		} else {
			return true;
		}

	}


}