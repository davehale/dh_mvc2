<?php
namespace dh_mvc2\routers;

interface I_Router {
	

	public function setRouter_url($url=NULL);
	public function getRoute();
	public function resolve_route($url=NULL);
	public function request_dispatch();
	

}
