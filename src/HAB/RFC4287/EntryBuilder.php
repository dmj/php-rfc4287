<?php

/**
 * This file is part of HAB RFC4287.
 *
 * HAB RFC4287 is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * HAB RFC4287 is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with HAB RFC4287.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2016 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */

namespace HAB\RFC4287;

/**
 * Entry builder.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2016 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
class EntryBuilder extends Builder
{
    /**
     * Feed builder.
     *
     * @var FeedBuilder
     */
    private $feed;

    /**
     * Constructor.
     *
     * @param  FeedBuilder $feed
     * @return void
     */
    public function __construct (FeedBuilder $feed)
    {
        parent::__construct();
        $this->feed = $feed;
    }

    /**
     * {@inheritDoc}
     */
    public function init ()
    {
        $this->container = new Model\Entry();
    }

    /**
     * Add content.
     *
     * @param  mixed  $content
     * @param  string $type
     * @param  string $source
     * @return self
     */
    public function content ($content, $type = 'text', $source = null)
    {
        if ($source) {
            $text = new Model\OutOfLineContent($source, $type);
        } else {
            $text = $this->makeTextConstruct($content, $type);
        }
        $this->container['content'] = $text;
        return $this;
    }

    /**
     * Add source.
     *
     * @param  Model\Feed $source
     * @return static
     */
    public function source (Model\Feed $source)
    {
        $this->container['source'] = $source;
        return $this;
    }

    /**
     * Add summary.
     *
     * @param  mixed  $summary
     * @param  string $type
     * @return self
     */
    public function summary ($summary, $type = 'text')
    {
        $text = $this->makeTextConstruct($summary, $type);
        $this->container['summary'] = $text;
        return $this;
    }

    /**
     * Add current entry to feed.
     *
     * @return FeedBuilder
     */
    public function add ()
    {
        $this->feed->entry($this->container);
        $this->init();
        return $this->feed;
    }

}