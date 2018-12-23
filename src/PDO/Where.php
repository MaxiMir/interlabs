<?php

    namespace App\PDO;

    trait Where
    {
        private $where;
        private $inValues;
        private $bSeparator = 'AND';

        private function buildWhere()
        {
            if (empty($this->where)) {
                return '';
            } else {
                $params = $this->where;
                $inData = array_reduce(array_keys($params), function($acc, $key) use ($params) {
                    $value = $params[$key];
                    if (!is_array($value)) {
                        $acc['partsSql'][] = "{$key} = ?";
                        $acc['inValues'][] = $value;
                    } else {
                        $in = implode(', ', array_fill(0, count($value), '?'));
                        $acc['partsSql'][] = "{$key} IN ({$in})";
                        $acc['inValues'] = array_merge($acc['inValues'], $value);
                    }
                    return $acc;
                }, ['partsSql' => [], 'inValues' => []]);

                $this->inValues = $inData['inValues'];
                $inSql = implode(" {$this->bSeparator} ", $inData['partsSql']);
                return "WHERE {$inSql}";
            }
        }
    }