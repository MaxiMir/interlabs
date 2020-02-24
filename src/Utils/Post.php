<?php

    namespace App\Utils;

    class Post implements PostInterface
    {
        public static function checkForPresenceData($sourceArr, $names) {
            $processedData = [];

            $cleanItem = function ($value) {
                if (!is_array($value)) {
                    return htmlspecialchars(trim($value));
                }

                return array_map(function($item) {
                    return htmlspecialchars(trim($item));
                }, $value);
            };

            $isEmptyElem = function ($value) {
                return is_array($value) ? in_array('', $value) : empty($value);
            };

            foreach ($names as $name) {
                if (!array_key_exists($name, $sourceArr)) {
                    return false;
                }

                $processedValue = $cleanItem($sourceArr[$name]);
                if ($isEmptyElem($processedValue)) {
                    return false;
                } else {
                    $processedData[] = $processedValue;
                }
            }
            return $processedData;
        }
    }
