<?php

	header("Content-type: text/html; charset=utf-8");
	include_once 'config.php';

	$employeeDao = new EmployeeDao();
	$logout = $employeeDao->logout();

	/*if(){
		header('location')
	}*/