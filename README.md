# Greek To Greeklish Converter

A PHP library for converting Greek text to Greeklish (Greek words written with Latin characters).

## Features

- Converts Greek text to Greeklish maintaining proper case (uppercase/lowercase)
- Handles special Greek diphthongs (αυ, ευ, μπ, etc.)
- Preserves non-Greek characters in the text
- Supports all Greek characters and accents
- Produces readable and linguistically appropriate transliterations

## Installation

Install the package via composer:

```bash
composer require pointergr/greek-to-greeklish
```

## Usage

### Basic Usage

```php
<?php

require_once 'vendor/autoload.php';

use Pointergr\GreekToGreeklish\GreekToGreeklish;

// Create a new instance
$converter = new GreekToGreeklish();

// Convert a Greek string to Greeklish
$greeklishText = $converter->convert('Καλημέρα Ελλάδα');

echo $greeklishText; // Outputs: "Kalimera Ellada"
```

### Examples

```php
$converter = new GreekToGreeklish();

// Single words
echo $converter->convert('Ελλάδα');      // Ellada
echo $converter->convert('Αθήνα');       // Athina
echo $converter->convert('Θεσσαλονίκη'); // Thessaloniki

// Phrases
echo $converter->convert('Καλημέρα, πώς είσαι;');  // Kalimera, pos eisai?

// Special diphthongs
echo $converter->convert('Αύριο');    // Avrio (αυ + vowel = av)
echo $converter->convert('Αυτός');    // Aftos (αυ + consonant = af)
echo $converter->convert('Εύκολο');   // Efkolo (ευ + consonant = ef)
echo $converter->convert('Ευάγγελος'); // Evangelos (ευ + vowel = ev)

// Mixed case
echo $converter->convert('ΕΛΛΑΔΑ');   // ELLADA
echo $converter->convert('Ελλάδα');   // Ellada
echo $converter->convert('ΕλΛάΔα');   // ElLaDa
```

## Testing

The library includes a comprehensive test suite with over 100 test cases that verify correct transliteration in various scenarios:

- Single words
- Special characters
- Different casing (uppercase, lowercase, mixed)
- Diphthongs
- Special letter combinations
- Complete sentences

To run the tests:

```bash
# Install dev dependencies
composer install --dev

# Run the tests
composer test
```

You can also run the tests directly with PHPUnit:

```bash
./vendor/bin/phpunit
```

This extensive testing ensures that the transliteration is reliable and consistent across all Greek language edge cases.

## Transliteration Rules

The converter follows specific rules for transliterating Greek to Latin characters:

1. **Simple character mapping:**
   - α → a, β → v, γ → g, δ → d, etc.

2. **Diphthongs:**
   - αι, αί → ai
   - ει, εί → ei
   - οι, οί → oi
   - ου, ού → ou
   - ντ → nt
   - μπ → mp (within word) or b (at beginning)
   - γγ → ng
   - γκ → gk

3. **Context-sensitive substitutions:**
   - αυ, ευ before vowels → av, ev
   - αυ, ευ before consonants → af, ef
   - μπ depending on position → mp or b

4. **Special cases for beginning of words:**
   - θ → th (with proper capitalization)
   - χ → ch (with proper capitalization)
   - ψ → ps (with proper capitalization)

## Requirements

- PHP 7.0 or higher
- mbstring PHP extension

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).