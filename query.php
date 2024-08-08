<?php
// query.php

include 'db_config.php';

// SQL query to fetch all appointments
$sql_appointments = "SELECT id, user_id, mechanic_id, appointment_date, service_type, status FROM appointments";
$result_appointments = $conn->query($sql_appointments);

// SQL query to fetch all services
$sql_services = "SELECT id, user_id, mechanic_id, service_date, service_description FROM services";
$result_services = $conn->query($sql_services);

$conn->close();