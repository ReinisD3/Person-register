<?php

require_once 'vendor/autoload.php';


use App\PersonData;
use App\StorageConnections\CsvStorage;

if (!isset($_SESSION)) {
    session_start();
}

$storage = new CsvStorage('Data/data.csv');


if (isset($_GET['searchPersonCode'])) {
    if (strlen($_GET['searchPersonCode']) !== 12) {
        $errCodeSearch = 'Please enter your Person Code format : 123xxx-123xx';
    } else {
        $searchedPerson = $storage->getByPersonalCode($_GET['searchPersonCode']);

        if (isset($_POST['delete'])) {
            $storage->delete($searchedPerson);
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
        $storage->save(new PersonData(
            $_POST['name'],
            $_POST['surname'],
            $_POST['personCode'],
            $_POST['comment']
        ));

    }
}


require 'index.view.html';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['postdata'] = $_POST;
    unset($_POST);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}


