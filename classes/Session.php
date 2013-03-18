<?php

namespace dh_mvc2\classes;

class Session {
	private $user_name = NULL;
	private $user_id = NULL;
	private $forward_url = NULL;
	private $form_action_url = NULL;
	private $authorised = FALSE;
	
	/**
	 *
	 * @return the $authorised
	 */
	public function getAuthorised() {
		return $this->authorised;
	}
	
	/**
	 *
	 * @param boolean $authorised        	
	 */
	public function setAuthorised($authorised) {
		$this->authorised = $authorised;
	}
	
	/**
	 *
	 * @return the $back_url
	 */
	public function getForward_url() {
		return $this->forward_url;
	}
	
	/**
	 *
	 * @return the $form_action_url
	 */
	public function getForm_action_url() {
		return $this->form_action_url;
	}
	
	/**
	 *
	 * @param field_type $back_url        	
	 */
	public function setForward_url($forward_url) {
		if (! isset ( $this->forward_url )) {
			$this->forward_url = $forward_url;
		}
	}
	
	/**
	 *
	 * @param field_type $form_action_url        	
	 */
	public function setForm_action_url($form_action_url) {
		$this->form_action_url = $form_action_url;
	}
	
	/**
	 *
	 * @return the $user_name
	 */
	public function getUser_name() {
		return $this->user_name;
	}
	
	/**
	 *
	 * @return the $user_id
	 */
	public function getUser_id() {
		return $this->user_id;
	}
	
	/**
	 *
	 * @param field_type $user_name        	
	 */
	public function setUser_name($user_name) {
		$this->user_name = $user_name;
	}
	
	/**
	 *
	 * @param field_type $user_id        	
	 */
	public function setUser_id($user_id) {
		$this->user_id = $user_id;
	}
}

?>