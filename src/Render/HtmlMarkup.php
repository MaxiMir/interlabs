<?php

    namespace App\Render;

    require '../../vendor/twig/twig/lib/Twig/Autoloader.php';

    use \Twig_Autoloader;
    use \Twig_Loader_Filesystem;
    use \Twig_Environment;

    class HtmlMarkup implements HtmlMarkupInterface
    {
        public static function generate($tmpl, $data)
        {
            $data['SITE_DIR'] = SITE_DIR;

            try {
                Twig_Autoloader::register();
                $loader = new Twig_Loader_Filesystem(realpath($_SERVER['DOCUMENT_ROOT'] . '/testovoeZadanie1/src/views'));
                $twig = new Twig_Environment($loader);
                $template = $twig->loadTemplate($tmpl);
                return $template->render($data);
            } catch (\Exception $e) {
                die ('ERROR: ' . $e->getMessage());
            }
        }
    }