<?php
session_start();
require_once "db.php";

$stmt = db_query("SELECT quiz_duration_in_minutes FROM quiz WHERE quiz_id={$_GET['quiz_id']}");
$_SESSION["quiz_duration"] = $stmt->fetchColumn();
date_default_timezone_set('Europe/London');
$date = date("H:i:s");
$_SESSION["end_time"]=date("H:i:s", strtotime($date . "+{$_SESSION['quiz_duration']} minutes"));
?>