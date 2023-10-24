<?php
require_once 'vendor/autoload.php';

use App\Person;
use App\Translator;

$person = new Person(readline("Enter a name: "), readline("Enter a surname: "));
$translator = new Translator();
$message = $translator->getTranslatedMessage($person->getName(), $person->getSurname());
echo $message;