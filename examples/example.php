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

// Run tests to verify conversions
echo "Running tests...\n";
$testResults = $converter->runTests();
echo "Passed: {$testResults['passedTests']} of {$testResults['totalTests']} tests ({$testResults['successRate']}%)\n";