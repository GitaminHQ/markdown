<?php

/*
 * This file is part of Markdown.
 *
 * Copyright (C) 2015-2016 The Gitamin Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GitaminHQ\Markdown\Compilers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\Compiler;
use Illuminate\View\Compilers\CompilerInterface;
use League\CommonMark\Converter;

class MarkdownCompiler extends Compiler implements CompilerInterface
{
    /**
     * The markdown instance.
     *
     * @var \League\CommonMark\Converter
     */
    protected $markdown;

    /**
     * Create a new instance.
     *
     * @param \League\CommonMark\Converter      $markdown
     * @param \Illuminate\Filesystem\Filesystem $files
     * @param string                            $cachePath
     *
     * @return void
     */
    public function __construct(Converter $markdown, Filesystem $files, $cachePath)
    {
        parent::__construct($files, $cachePath);

        $this->markdown = $markdown;
    }

    /**
     * Compile the view at the given path.
     *
     * @param string $path
     *
     * @return void
     */
    public function compile($path)
    {
        $contents = $this->markdown->convertToHtml($this->files->get($path));

        $this->files->put($this->getCompiledPath($path), $contents);
    }

    /**
     * Return the filesystem instance.
     *
     * @return \Illuminate\Filesystem\Filesystem
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Return the markdown instance.
     *
     * @return \League\CommonMark\Converter
     */
    public function getMarkdown()
    {
        return $this->markdown;
    }
}
