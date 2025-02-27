<?php

namespace Pointergr\GreekToGreeklish;

/**
 * Class GreekToGreeklish
 * 
 * A class for converting Greek text to Greeklish (Greek words written with Latin characters)
 * 
 * @package Pointergr\GreekToGreeklish
 */
class GreekToGreeklish
{
    /**
     * Βοηθητική συνάρτηση για μετατροπή string σε array 
     * 
     * @param string $str Το string προς διαίρεση
     * @param int $len Το μήκος κάθε τμήματος
     * @return array Πίνακας με τα τμήματα του string
     */
    private function mb_str_split_custom($str, $len = 1) {
        $arr = array();
        $strLen = mb_strlen($str, 'UTF-8');
        for ($i = 0; $i < $strLen; $i += $len) {
            $arr[] = mb_substr($str, $i, $len, 'UTF-8');
        }
        return $arr;
    }

    /**
     * Μετατρέπει ελληνικό κείμενο σε greeklish (λατινικούς χαρακτήρες)
     * 
     * @param string $text Το ελληνικό κείμενο προς μετατροπή
     * @return string Το κείμενο σε greeklish
     */
    public function convert($text) {
        // Δημιουργία sets
        $grCapsStr = 'ΑΆΒΓΔΕΈΖΗΉΘΙΊΪΚΛΜΝΞΟΌΠΡΣΤΥΎΫΦΧΨΩΏ';
        $viSetStr = 'αάβγδεέζηλιμνορυω';
        
        $grCaps = array_flip($this->mb_str_split_custom($grCapsStr));
        $viSet = array_flip($this->mb_str_split_custom($viSetStr));
        
        // Αντικαταστάσεις διφθόγγων
        $diphthongs = array(
            'αι' => 'ai', 'αί' => 'ai', 'οι' => 'oi', 'οί' => 'oi',
            'ου' => 'ou', 'ού' => 'ou', 'ει' => 'ei', 'εί' => 'ei',
            'ντ' => 'nt', 'τσ' => 'ts', 'τς' => 'ts',
            'τζ' => 'tz', 'γγ' => 'ng', 'γκ' => 'gk',
            'θ' => 'th', 'χ' => 'ch', 'ψ' => 'ps',
            'γχ' => 'nch', 'γξ' => 'nx'
        );
        
        // Ειδικοί δίφθογγοι με συνθήκες
        $special = array(
            'αυ' => array('type' => 'fivi'),
            'αύ' => array('type' => 'fivi'),
            'ευ' => array('type' => 'fivi'),
            'εύ' => array('type' => 'fivi'),
            'ηυ' => array('type' => 'fivi'),
            'ηύ' => array('type' => 'fivi'),
            'μπ' => array('type' => 'bi')
        );
        
        // Αντιστοίχιση μεμονωμένων γραμμάτων
        $grLetters = 'αάβγδεέζηήθιίϊΐκλμνξοόπρσςτυύϋΰφχψωώ';
        $engLetters = 'aavgdeezii.iiiiklmnxooprsstyyyyf..oo';
        
        $singleLetters = array();
        for ($i = 0; $i < mb_strlen($grLetters, 'UTF-8'); $i++) {
            $grLetter = mb_substr($grLetters, $i, 1, 'UTF-8');
            $engLetter = mb_substr($engLetters, $i, 1, 'UTF-8');
            $singleLetters[$grLetter] = $engLetter;
        }
        
        // Δημιουργία patterns για αντικατάσταση
        $patterns = array();
        
        // Προσθήκη ειδικών διφθόγγων
        foreach ($special as $pattern => $info) {
            $patterns[] = $pattern;
        }
        
        // Προσθήκη απλών διφθόγγων
        foreach ($diphthongs as $pattern => $replacement) {
            $patterns[] = $pattern;
        }
        
        // Ταξινόμηση patterns με βάση το μήκος (μεγαλύτερα πρώτα)
        usort($patterns, function($a, $b) {
            return mb_strlen($b, 'UTF-8') - mb_strlen($a, 'UTF-8');
        });
        
        // Μετατροπή του κειμένου
        $result = '';
        $length = mb_strlen($text, 'UTF-8');
        $i = 0;
        
        while ($i < $length) {
            $found = false;
            
            // Έλεγχος για διφθόγγους στην αρχή της λέξης: θ, χ, ψ
            if ($i == 0 && $i + 1 <= $length) {
                $currentChar = mb_substr($text, $i, 1, 'UTF-8');
                $currentCharLower = mb_strtolower($currentChar, 'UTF-8');
                
                if (in_array($currentCharLower, ['θ', 'χ', 'ψ'])) {
                    $nextChar = ($i + 1 < $length) ? mb_substr($text, $i + 1, 1, 'UTF-8') : '';
                    $nextCharLower = mb_strtolower($nextChar, 'UTF-8');
                    
                    // Έλεγχος αν ο επόμενος χαρακτήρας είναι ελληνικό γράμμα
                    $nextCharIsGreek = isset($singleLetters[$nextCharLower]);
                    
                    if ($nextCharIsGreek) {
                        // Ελέγχουμε αν ο επόμενος χαρακτήρας είναι κεφαλαίος
                        $nextIsUpper = ($nextChar === mb_strtoupper($nextChar, 'UTF-8') && 
                                        $nextChar !== mb_strtolower($nextChar, 'UTF-8'));
                        
                        // Επιλογή αντικατάστασης ανάλογα με τον επόμενο χαρακτήρα
                        if ($currentCharLower === 'θ') {
                            $replacement = $nextIsUpper ? 'TH' : 'Th';
                        } else if ($currentCharLower === 'χ') {
                            $replacement = $nextIsUpper ? 'CH' : 'Ch';
                        } else if ($currentCharLower === 'ψ') {
                            $replacement = $nextIsUpper ? 'PS' : 'Ps';
                        }
                        
                        $result .= $replacement;
                        $i++;
                        $found = true;
                    }
                }
            }
            
            // Έλεγχος για διφθόγγους και ειδικούς διφθόγγους
            if (!$found) {
                foreach ($patterns as $pattern) {
                    $patternLen = mb_strlen($pattern, 'UTF-8');
                    
                    if ($i + $patternLen <= $length) {
                        $textSubstr = mb_substr($text, $i, $patternLen, 'UTF-8');
                        $textSubstrLower = mb_strtolower($textSubstr, 'UTF-8');
                        $patternLower = mb_strtolower($pattern, 'UTF-8');
                        
                        if ($textSubstrLower === $patternLower) {
                            // Έλεγχος για ειδικούς διφθόγγους
                            if (isset($special[$patternLower])) {
                                if ($special[$patternLower]['type'] === 'fivi') {
                                    $firstChar = mb_substr($patternLower, 0, 1, 'UTF-8');
                                    $firstRepl = $singleLetters[$firstChar];
                                    
                                    $nextChar = ($i + $patternLen < $length) ? mb_substr($text, $i + $patternLen, 1, 'UTF-8') : '';
                                    $nextCharLower = mb_strtolower($nextChar, 'UTF-8');
                                    
                                    $secondChar = isset($viSet[$nextCharLower]) ? 'v' : 'f';
                                    $replacement = $firstRepl . $secondChar;
                                    
                                    // Διόρθωση περίπτωσης
                                    if ($textSubstr === mb_strtoupper($textSubstr, 'UTF-8')) {
                                        $replacement = mb_strtoupper($replacement, 'UTF-8');
                                    } else if (mb_strtoupper(mb_substr($textSubstr, 0, 1, 'UTF-8')) === mb_substr($textSubstr, 0, 1, 'UTF-8')) {
                                        $replacement = mb_strtoupper(mb_substr($replacement, 0, 1, 'UTF-8')) . mb_substr($replacement, 1);
                                    }
                                    
                                    $result .= $replacement;
                                } else if ($special[$patternLower]['type'] === 'bi') {
                                    $prevChar = ($i > 0) ? mb_substr($text, $i - 1, 1, 'UTF-8') : '';
                                    $prevCharLower = mb_strtolower($prevChar, 'UTF-8');
                                    
                                    $nextChar = ($i + $patternLen < $length) ? mb_substr($text, $i + $patternLen, 1, 'UTF-8') : '';
                                    $nextCharLower = mb_strtolower($nextChar, 'UTF-8');
                                    
                                    $hasPrevGreek = isset($singleLetters[$prevCharLower]);
                                    $hasNextGreek = isset($singleLetters[$nextCharLower]);
                                    
                                    $biRepl = ($hasPrevGreek && $hasNextGreek) ? 'mp' : 'b';
                                    
                                    // Διόρθωση περίπτωσης
                                    if ($textSubstr === mb_strtoupper($textSubstr, 'UTF-8')) {
                                        $biRepl = mb_strtoupper($biRepl, 'UTF-8');
                                    } else if (mb_strtoupper(mb_substr($textSubstr, 0, 1, 'UTF-8')) === mb_substr($textSubstr, 0, 1, 'UTF-8')) {
                                        $biRepl = mb_strtoupper(mb_substr($biRepl, 0, 1, 'UTF-8')) . mb_substr($biRepl, 1);
                                    }
                                    
                                    $result .= $biRepl;
                                }
                            } else {
                                // Απλοί δίφθογγοι
                                $diphthongRepl = $diphthongs[$patternLower];
                                
                                // Διόρθωση περίπτωσης
                                if ($textSubstr === mb_strtoupper($textSubstr, 'UTF-8')) {
                                    $diphthongRepl = mb_strtoupper($diphthongRepl, 'UTF-8');
                                } else if (mb_strtoupper(mb_substr($textSubstr, 0, 1, 'UTF-8')) === mb_substr($textSubstr, 0, 1, 'UTF-8')) {
                                    $diphthongRepl = mb_strtoupper(mb_substr($diphthongRepl, 0, 1, 'UTF-8')) . mb_substr($diphthongRepl, 1);
                                }
                                
                                $result .= $diphthongRepl;
                            }
                            
                            $i += $patternLen;
                            $found = true;
                            break;
                        }
                    }
                }
            }
            
            // Αν δεν βρέθηκε δίφθογγος, έλεγχος για μεμονωμένο γράμμα
            if (!$found) {
                $char = mb_substr($text, $i, 1, 'UTF-8');
                $charLower = mb_strtolower($char, 'UTF-8');
                
                if (isset($singleLetters[$charLower])) {
                    $replacement = $singleLetters[$charLower];
                    
                    // Διόρθωση περίπτωσης
                    if ($char === mb_strtoupper($char, 'UTF-8') && $char !== mb_strtolower($char, 'UTF-8')) {
                        $replacement = mb_strtoupper($replacement, 'UTF-8');
                    }
                    
                    $result .= $replacement;
                } else {
                    $result .= $char;
                }
                
                $i++;
            }
        }
        
        return $result;
    }

}