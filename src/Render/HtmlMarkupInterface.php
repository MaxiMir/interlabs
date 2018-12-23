<?php

    namespace App\Render;

    interface HtmlMarkupInterface
    {
        public static function generate($tmpl, $data);
    }
