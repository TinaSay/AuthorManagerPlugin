<?php

/**
 * Class Meta_Values for getting author values from database to provide a public access
 */
class Meta_Values {
	/**
	 * @var mixed for public access
	 */
	public $firstname;
	public $lastname;
	public $bio;
	public $fbUrl;
	public $linkedInUrl;
	public $linkedUser;

	/**
	 * Meta_Values constructor.
	 *
	 * @param $post_id
	 */
	public function __construct( $post_id ) {
		$this->firstname   = get_post_meta( $post_id, '_author_name_meta_key', true );
		$this->lastname    = get_post_meta( $post_id, '_author_lastname_meta_key', true );
		$this->bio         = get_post_meta( $post_id, '_author_bio_meta_key', true );
		$this->fbUrl       = get_post_meta( $post_id, '_author_fb_meta_key', true );
		$this->linkedInUrl = get_post_meta( $post_id, '_author_linkedin_meta_key', true );
		$this->linkedUser  = get_post_meta( $post_id, '_linked_user_meta_key', true );
	}

}
