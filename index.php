<?php

require_once 'vendor/autoload.php';

use App\DataOperations;
use App\PersonData;

if (!isset($_SESSION)) {
    session_start();
}

$allRecords = DataOperations::loadData('data.csv');


if (isset($_GET['searchPersonCode'])) {
    if (strlen($_GET['searchPersonCode']) !== 12) {
        $errCodeSearch = 'Please enter your Person Code format : 123xxx-123xx';
    } else {
        $match = DataOperations::searchByPersonCode($_GET['searchPersonCode'], $allRecords);
        if (isset($_POST['delete'])) {
            $allRecords = DataOperations::deleteRecord($match, $allRecords);
            DataOperations::savePeopleData($allRecords, 'data.csv');
        }

    }

}

if (isset($_POST['submit'])) {
    if (empty($_POST['name'])) {
        $errName = 'Please enter your name';
    }
    if (empty($_POST['surname'])) {
        $errSurName = 'Please enter your surname';
    }
    if (strlen($_POST['personCode']) !== 12) {
        $errCode = 'Please enter your Person Code format : 123xxx-123xx';
    } else {
        $allRecords [] = new PersonData($_POST['name'], $_POST['surname'], $_POST['personCode'], $_POST['comment']);
        DataOperations::savePeopleData($allRecords, 'data.csv');
    }
}


require 'index.view.html';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['postdata'] = $_POST;
    unset($_POST);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}


