<?php
require_once(__DIR__ . '/../yii2/framework/requirements/YiiRequirementChecker.php');

$flavour = isset($_GET['flavour']) ? $_GET['flavour'] : 'min';

$result = (new YiiRequirementChecker())
    ->checkYii()
    ->check(__DIR__ . "/../requirements-$flavour.php")
    ->getResult();

foreach ($result['requirements'] as $requirement) {
    if ($requirement['error']) {
        echo "MISSING: $requirement[name]";
        exit;
    }
}
echo 'OK';
