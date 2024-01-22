<?php
require_once __DIR__ . '../../../../infra/middlewares/middleware-user.php';
@require_once __DIR__ . '/../../../helpers/session.php';

$user = user();

include_once __DIR__ . '../../../../templates/header.php';

class Calendar {
	private $active_year, $active_month, $active_day;
	private $events = [];

	public function __construct($date = null) {
		$this->$active_year = $date != null ? date('Y', strtotime($date)) : date('Y');
		$this->$active_month = $date != null ? date('m', strtotime($date)) : date('m');
		$this->$active_day = $date != null ? date('d', strtotime($date)) : date('d');
	}

	public function add_event($txt, $date, $days = 1, $color = '') {
		
	}
}
?>

