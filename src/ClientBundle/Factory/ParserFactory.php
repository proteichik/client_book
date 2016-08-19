<?php

namespace ClientBundle\Factory;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Yaml\Yaml;

class ParserFactory implements ParserFactoryInterface
{
    /**
     * @param $path
     * @return array|mixed
     */
    public function parse($path)
    {
        $file = new File($path);
        $ext = $file->getExtension();

        $config = array();
        switch ($ext)
        {
            case 'yml':
                $config = Yaml::parse(file_get_contents($path));
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Parser for format %s not found', $ext));
        }

        return $config;
    }
}