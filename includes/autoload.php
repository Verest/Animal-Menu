<?php

// Exit if called directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Auto-loads classes namespaced to AnimalMenu.
 *
 * @param $namespacePath
 */
class AnimalMenuAutoLoader
{
    public function __invoke($namespacePath)
    {
        if (strpos($namespacePath, 'AnimalMenu') === false) {
            return;
        }

        $filePath = $this->getFilePath($namespacePath);
        if (is_readable($filePath)) {
            include_once $filePath;
        } else {
            wp_die("$filePath does not exist.");
        }
    }

    private function getFilePath($namespacePath)
    {
        $namespacePath = str_replace('AnimalMenu\\', '', $namespacePath);
        $pathParts = explode('\\', $namespacePath);

        list($path, $className) = $this->parsePathParts($pathParts);

        return dirname(__FILE__, 2) . $path . $className;
    }

    private function parsePathParts($pathParts)
    {
        $path = DIRECTORY_SEPARATOR;
        $className = '';

        foreach ($pathParts as $key => $pathPart) {
            $isEndOfArray = ( $key + 1 === count($pathParts) );

            if ($isEndOfArray) {
                $className = $pathPart . '.php';
            } else {
                $path .= strtolower($pathPart) . DIRECTORY_SEPARATOR;
            }
        }

        return [$path, $className];
    }
}

spl_autoload_register(new AnimalMenuAutoLoader());