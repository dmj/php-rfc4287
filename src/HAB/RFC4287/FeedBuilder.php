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
 * Feed builder.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2016 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
class FeedBuilder extends Builder
{
    /**
     * Entry builder instance.
     *
     * @var EntryBuilder
     */
    private $entries;

    /**
     * {@inheritDoc}
     */
    public function init ()
    {
        $this->container = new Model\Feed();
    }

    /**
     * Add entry or return entry builder.
     *
     * @param  Entry $entry
     * @return static|EntryBuilder
     */
    public function entry (Model\Entry $entry = null)
    {
        if ($entry) {
            if (!isset($this->container['entry'])) {
                $this->container['entry'] = new Model\VisitableAggregate();
            }
            $this->container['entry']->append($entry);
            if ($entry['updated'] > $this->container['updated']) {
                $this->container['updated'] = clone($entry['updated']);
            }
            return $this;
        }
        if (!$this->entries) {
            $this->entries = new EntryBuilder($this);
        }
        return $this->entries;
    }

    /**
     * Add generator.
     *
     * @param  string $name
     * @param  string $version
     * @param  string $uri
     * @return self
     */
    public function generator ($name, $version = null, $uri = null)
    {
        $this->container['generator'] = new Model\Generator($name, $version, $uri);
        return $this;
    }

    /**
     * Add icon.
     *
     * @param  string $uri
     * @return static
     */
    public function icon ($uri)
    {
        $this->container['icon'] = new Model\Literal($uri);
        return $this;
    }

    /**
     * Add logo.
     *
     * @param  string $uri
     * @return static
     */
    public function logo ($uri)
    {
        $this->container['logo'] = new Model\Literal($uri);
        return $this;
    }

    /**
     * Add subtitle.
     *
     * @param  mixed  $subtitle
     * @param  string $type
     * @return self
     */
    public function subtitle ($subtitle, $type = 'text')
    {
        $text = $this->makeTextConstruct($subtitle, $type);
        $this->container['subtitle'] = $text;
        return $this;
    }

    /**
     * Return current feed.
     *
     * @return Feed
     */
    public function getFeed ()
    {
        if (!$this->container['updated']) {
            $this->updated('now');
        }
        $this->container->sort();
        return $this->container;
    }
}