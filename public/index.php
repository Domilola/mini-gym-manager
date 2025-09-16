<?php
require __DIR__ . '/../config/env.php';
use Infra\Persistence\PdoConnection;
$pdo = PdoConnection::getInstance();
echo "✅ DB connected";
