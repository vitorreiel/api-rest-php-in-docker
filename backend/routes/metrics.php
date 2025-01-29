<?php
require '../vendor/autoload.php';

use Prometheus\CollectorRegistry;
use Prometheus\Storage\APC;
use Prometheus\RenderTextFormat;

// Inicializa o Prometheus com persistência
$adapter = new APC();
$registry = new CollectorRegistry($adapter);

// Renderiza e retorna as métricas para o Prometheus
$renderer = new RenderTextFormat();
header('Content-Type: ' . RenderTextFormat::MIME_TYPE);
echo $renderer->render($registry->getMetricFamilySamples());
?>