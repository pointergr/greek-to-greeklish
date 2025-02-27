<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Pointergr\GreekToGreeklish\GreekToGreeklish;

// Create a new instance
$converter = new GreekToGreeklish();

// Convert a single word
$greek = "Ελλάδα";
$greeklish = $converter->convert($greek);
echo "Original: $greek\n";
echo "Greeklish: $greeklish\n\n";

// Convert a phrase
$greek = "Καλημέρα, πώς είσαι;";
$greeklish = $converter->convert($greek);
echo "Original: $greek\n";
echo "Greeklish: $greeklish\n\n";

// Convert with special characters
$greek = "Αύριο θα πάμε στην Αθήνα";
$greeklish = $converter->convert($greek);
echo "Original: $greek\n";
echo "Greeklish: $greeklish\n\n";

// Convert different cases
$greek = "ΕΛΛΑΔΑ";
$greeklish = $converter->convert($greek);
echo "Original: $greek\n";
echo "Greeklish: $greeklish\n\n";

// Convert special diphthongs
$examples = [
    "Αυτοκίνητο" => "Converts 'αυ' before consonant",
    "Ευάγγελος" => "Converts 'ευ' before vowel",
    "Μπάλα" => "Converts 'μπ' at beginning",
    "Έμπορος" => "Converts 'μπ' within word",
    "Άγγελος" => "Converts 'γγ' to 'ng'",
    "Τσάντα" => "Converts 'τσ' to 'ts'"
];

echo "Special diphthong examples:\n";
foreach ($examples as $word => $desc) {
    $greeklish = $converter->convert($word);
    echo "$word -> $greeklish ($desc)\n";
}