<?php

namespace Datashaman\Tongs\Plugins;

use Datashaman\Tongs\Plugins\Plugin;
use Datashaman\Tongs\Tongs;
use Illuminate\Support\Collection;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\StringLoader;

class TwigPlugin extends Plugin
{
    protected $twig;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $options = $this->normalize($options);

        parent::__construct($options);

        $loader = new FilesystemLoader($options['templates']);

        $this->twig = new Environment($loader);
    }

    /**
     * Handle files passed down the pipeline, and call the next plugin in the pipeline.
     *
     * @param array $files
     * @param callable $next
     *
     * @return array
     */
    public function handle(array $files, callable $next): array
    {
        foreach ($files as &$file) {
            $locals = array_merge(
                $this->tongs()->metadata(),
                $file
            );

            $file['contents'] = $this->twig
                ->createTemplate($file['contents'])
                ->render($locals);
        }

        return $next($files);
    }

    /**
     * Normalize options to a consistent internal form, converting
     * strings to arrays or whatever else is needed.
     *
     * @param array $options
     *
     * @return array
     */
    protected function normalize(array $options): array
    {
        $defaults = [
            'templates' => [
                'templates',
            ],
        ];

        return array_merge($defaults, $options);
    }
}
