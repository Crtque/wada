<?php

	// ����� ��� ��� ������ ���������� � ����
	// ������� ���������� � ��������
	
	$db = mysqli_connect('localhost',
					'admin', 'yourpassword', 'main_db');
					
	// ������������� ��������� ���������� utf8
	mysqli_query($db, "SET NAMES utf8");

?>