<?php
require 'config/database.php';

// Очистить все сессии и перенаправить на домашнюю страницу
session_destroy();
header('location: ' . ROOT_URL);
die();