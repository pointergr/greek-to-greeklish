<?php

namespace Pointergr\GreekToGreeklish\Tests;

use PHPUnit\Framework\TestCase;
use Pointergr\GreekToGreeklish\GreekToGreeklish;

class GreekToGreeklishTest extends TestCase
{
    private $converter;

    protected function setUp(): void
    {
        $this->converter = new GreekToGreeklish();
    }

    /**
     * @dataProvider provideBasicGreekWords
     */
    public function testBasicGreekWords($greek, $expected)
    {
        $this->assertEquals($expected, $this->converter->convert($greek));
    }

    /**
     * @dataProvider provideSpecialDiphthongs
     */
    public function testSpecialDiphthongs($greek, $expected)
    {
        $this->assertEquals($expected, $this->converter->convert($greek));
    }

    /**
     * @dataProvider provideCaseSensitiveWords
     */
    public function testCaseSensitiveConversion($greek, $expected)
    {
        $this->assertEquals($expected, $this->converter->convert($greek));
    }

    /**
     * @dataProvider provideInitialSpecialCharacters
     */
    public function testInitialSpecialCharacters($greek, $expected)
    {
        $this->assertEquals($expected, $this->converter->convert($greek));
    }

    /**
     * @dataProvider provideMixedSentences
     */
    public function testMixedSentences($greek, $expected)
    {
        $this->assertEquals($expected, $this->converter->convert($greek));
    }

    /**
     * Πίνακας με όλα τα test cases από το αρχικό αρχείο
     */
    public function provideAllTestCases()
    {
        return [
            ['Ελληνικά', 'Ellinika'],
            ['Άυλος', 'Aylos'],
            ['Πτολεμαΐδα', 'Ptolemaida'],
            ['Θωμάς', 'Thomas'],
            ['ΘΩΜΑΣ', 'THOMAS'],
            ['Άνθρωπος', 'Anthropos'],
            ['Ευριπίδης', 'Evripidis'],
            ['ΑΘΗΝΑ', 'ATHINA'],
            ['Καλημέρα', 'Kalimera'],
            ['Αυτοκίνητο', 'Aftokinito'],
            ['Εύα', 'Eva'],
            ['Μπάλα', 'Bala'],
            ['Γυναίκα', 'Gynaika'],
            ['Γεια σας', 'Geia sas'],
            ['Αίμα', 'Aima'],
            ['Είμαι', 'Eimai'],
            ['Οίκος', 'Oikos'],
            ['Ούτε', 'Oute'],
            ['Καϊμάκι', 'Kaimaki'],
            ['Προϊόντα', 'Proionta'],
            ['Αυγό', 'Avgo'],
            ['Αύριο', 'Avrio'],
            ['Αυτός', 'Aftos'],
            ['Ευχή', 'Efchi'],
            ['Εύχομαι', 'Efchomai'],
            ['Ευάγγελος', 'Evangelos'],
            ['Ηύρα', 'Ivra'],
            ['Έμπορος', 'Emporos'],
            ['Λάμπα', 'Lampa'],
            ['Κόμπρα', 'Kompra'],
            ['Σαμπουάν', 'Sampouan'],
            ['Αμπέλι', 'Ampeli'],
            ['Ντομάτα', 'Ntomata'],
            ['Πάντα', 'Panta'],
            ['Σπρίντερ', 'Sprinter'],
            ['Αντέχω', 'Antecho'],
            ['Πέντε', 'Pente'],
            ['Άγγελος', 'Angelos'],
            ['Αγκαλιά', 'Agkalia'],
            ['Έγχορδο', 'Enchordo'],
            ['Λάρυγξ', 'Larynx'],
            ['Σφίγγα', 'Sfinga'],
            ['Φεγγάρι', 'Fengari'],
            ['Θέατρο', 'Theatro'],
            ['Χαρά', 'Chara'],
            ['Ψάρι', 'Psari'],
            ['Ψυχή', 'Psychi'],
            ['Χθες', 'Chthes'],
            ['Ψηλός', 'Psilos'],
            ['ΕΛΛΑΔΑ', 'ELLADA'],
            ['ΑθΗνΑ', 'AthInA'],
            ['ΘΕΑ', 'THEA'],
            ['ΨΑΡΙ', 'PSARI'],
            ['ΕΥΧΑΡΙΣΤΩ', 'EFCHARISTO'],
            ['Τσάι', 'Tsai'],
            ['Τζάμι', 'Tzami'],
            ['ΤΣΑΝΤΑ', 'TSANTA'],
            ['ΤΖΑΤΖΙΚΙ', 'TZATZIKI'],
            ['Τσίπουρα', 'Tsipoura'],
            ['Τζίτζικας', 'Tzitzikas'],
            ['Καΐκι', 'Kaiki'],
            ['Προϊόν', 'Proion'],
            ['Πλαϊνός', 'Plainos'],
            ['Κορυφαΐος', 'Koryfaios'],
            ['Μαΐου', 'Maiou'],
            ['Ρομαϊκός', 'Romaikos'],
            ['Μπάμπης', 'Bampis'],
            ['Τσιτσιπάς', 'Tsitsipas'],
            ['Αντιπροσωπεία', 'Antiprosopeia'],
            ['Παμπλουκιανός', 'Pamploukianos'],
            ['ΜΑΪΝΤΑΝΟΣ', 'MAINTANOS'],
            ['ΑΫΠΝΙΑ', 'AYPNIA'],
            ['Παϊδάκια', 'Paidakia'],
            ['Γαλανομάτης', 'Galanomatis'],
            ['Υπεραξία', 'Yperaxia'],
            ['Άγχος', 'Anchos'],
            ['ΕΓΚΥΚΛΟΠΑΙΔΕΙΑ', 'EGKYKLOPAIDEIA'],
            ['Συγχαρητήρια', 'Syncharitiria'],
            ['Τζαμπατζής', 'Tzampatzis']
        ];
    }
    
    /**
     * Εκτέλεση όλων των test cases από το αρχικό αρχείο
     * 
     * @dataProvider provideAllTestCases
     */
    public function testAllOriginalCases($greek, $expected)
    {
        $this->assertEquals($expected, $this->converter->convert($greek));
    }

    public function provideBasicGreekWords()
    {
        return [
            ['Ελληνικά', 'Ellinika'],
            ['Πτολεμαΐδα', 'Ptolemaida'],
            ['Καλημέρα', 'Kalimera'],
            ['Γυναίκα', 'Gynaika'],
            ['Γεια σας', 'Geia sas'],
            ['Είμαι', 'Eimai'],
            ['Οίκος', 'Oikos'],
            ['Ούτε', 'Oute'],
        ];
    }

    public function provideSpecialDiphthongs()
    {
        return [
            ['Άυλος', 'Aylos'],
            ['Αυγό', 'Avgo'],
            ['Αύριο', 'Avrio'],
            ['Αυτός', 'Aftos'],
            ['Ευχή', 'Efchi'],
            ['Εύχομαι', 'Efchomai'],
            ['Ευάγγελος', 'Evangelos'],
            ['Μπάλα', 'Bala'],
            ['Έμπορος', 'Emporos'],
            ['Λάμπα', 'Lampa'],
            ['Μπάμπης', 'Bampis'],
        ];
    }

    public function provideCaseSensitiveWords()
    {
        return [
            ['ΘΩΜΑΣ', 'THOMAS'],
            ['Θωμάς', 'Thomas'],
            ['ΑΘΗΝΑ', 'ATHINA'],
            ['Αθήνα', 'Athina'],
            ['ΕΛΛΑΔΑ', 'ELLADA'],
            ['ΑθΗνΑ', 'AthInA'],
            ['ΘΕΑ', 'THEA'],
            ['ΨΑΡΙ', 'PSARI'],
            ['ΕΥΧΑΡΙΣΤΩ', 'EFCHARISTO'],
        ];
    }

    public function provideInitialSpecialCharacters()
    {
        return [
            ['Θέατρο', 'Theatro'],
            ['Χαρά', 'Chara'],
            ['Ψάρι', 'Psari'],
            ['Ψυχή', 'Psychi'],
            ['Χθες', 'Chthes'],
            ['Ψηλός', 'Psilos'],
        ];
    }

    public function provideMixedSentences()
    {
        return [
            ['Καλημέρα, πώς είσαι;', 'Kalimera, pos eisai;'],
            ['Η Ελλάδα είναι όμορφη χώρα.', 'I Ellada einai omorfi chora.'],
            ['ΑΘΗΝΑ - ΘΕΣΣΑΛΟΝΙΚΗ', 'ATHINA - THESSALONIKI'],
            ['Το αυτοκίνητο είναι μπλε.', 'To aftokinito einai ble.'],
            ['Χθες ήταν Ψυχρή μέρα!', 'Chthes itan PSychri mera!'],
        ];
    }
}