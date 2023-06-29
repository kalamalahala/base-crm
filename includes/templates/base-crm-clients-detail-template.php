<?php
	use BaseCRM\ServerSide\GFAPIHandler;

	$form_data = new GFAPIHandler();
	/*
	 * Pass 'lead_id' via GET parameter to this page
	 * Grab all matching entries from form 114 using
	 * GFAPIHandler::getMatchingEntries(), passing
	 * the lead_id as the parameter
	 *
	 * If there are no matching entries, display a message
	 *
	 * If there are matching entries, display a table with
	 * a raw data dump for now
	 */

	$lead_id = ((int)$_GET['lead_id']) ?: false;
	if (!$lead_id) {
		echo '<h1>No Lead ID Provided</h1>';
		exit;
	}