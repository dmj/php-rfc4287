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

use DOMDocument;
use SimpleXMLElement;

use DateTimeInterface;
use DateTimeImmutable;

/**
 * Abstract base class of FeedBuilder and EntryBuilder.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2016 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
abstract class Builder
{
    /**
     * Current container.
     *
     * @var Model\Container
     */
    protected $container;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct ()
    {
        $this->init();
    }

    /**
     * Initialize builder.
     *
     * @return void
     */
    abstract public function init ();

    /**
     * Set container property.
     *
     * @param  string                   $name
     * @param  Model\VisitableInterface $value
     * @return static
     */
    public function set ($name, Model\VisitableInterface $value)
    {
        $this->container[$name] = $value;
        return $this;
    }

    /**
     * Return container property.
     *
     * @param  string $name
     * @return Model\VisitableInterface|null
     */
    public function get ($name)
    {
        if (isset($this->container[$name])) {
            return $this->container[$name];
        }
    }

    /**
     * Add a link.
     *
     * @param  string $target
     * @param  string $relation
     * @param  string $title
     * @param  string $type
     * @param  string $hreflang
     * @param  string $length
     * @return static
     */
    public function link ($target, $relation, $title = null, $type = null, $hreflang = null, $length = null)
    {
        if (!isset($this->container['link'])) {
            $this->container['link'] = new Model\VisitableAggregate();
        }
        $this->container['link']->append(new Model\Link($target, $relation, $title, $type, $hreflang, $length));
        return $this;
    }

    /**
     * Add updated timestamp.
     *
     * @param  string|DateTimeInterface $datetime
     * @return static
     */
    public function updated ($datetime)
    {
        if (!$datetime instanceof DateTimeInterface) {
            $datetime = new DateTimeImmutable($datetime);
        }
        $this->container['updated'] = new Model\DateConstruct($datetime);
        return $this;
    }

    /**
     * Add title.
     *
     * @param  mixed  $content
     * @param  string $type
     * @return static
     */
    public function title ($content, $type = 'text')
    {
        $title = $this->makeTextConstruct($content, $type);
        $this->container['title'] = $title;
        return $this;
    }

    /**
     * Add id.
     *
     * @param  string $id
     * @return static
     */
    public function id ($id)
    {
        $this->container['id'] = new Model\Literal($id);
        return $this;
    }

    /**
     * Add category.
     *
     * @param  string $term
     * @param  string $scheme
     * @param  string $label
     * @return static
     */
    public function category ($term, $scheme = null, $label = null)
    {
        if (!isset($this->container['category'])) {
            $this->container['category'] = new Model\VisitableAggregate();
        }
        $this->container['category']->append(new Model\Category($term, $scheme, $label));
        return $this;
    }

    /**
     * Add author.
     *
     * @param  string $name
     * @param  string $email
     * @param  string $url
     * @return static
     */
    public function author ($name, $email = null, $url = null)
    {
        $author = new Model\PersonConstruct($name, $email, $url);
        if (!isset($this->container['author'])) {
            $this->container['author'] = new Model\VisitableAggregate();
        }
        $this->container['author']->append($author);
        return $this;
    }

    /**
     * Add contributor.
     *
     * @param  string $name
     * @param  string $email
     * @param  string $url
     * @return static
     */
    public function contributor ($name, $email = null, $url = null)
    {
        $contributor = new Model\PersonConstruct($name, $email, $url);
        if (!isset($this->container['contributor'])) {
            $this->container['contributor'] = new Model\VisitableAggregate();
        }
        $this->container['contributor']->append($contributor);
        return $this;
    }

    /**
     * Add rights.
     *
     * @param  mixed  $rights
     * @param  string $type
     * @return static
     */
    public function rights ($rights, $type = 'text')
    {
        $text = $this->makeTextConstruct($rights, $type);
        $this->container['rights'] = $text;
        return $this;
    }

    /**
     * Return text construct.
     *
     * @param  mixed  $content
     * @param  string $type
     * @param  array  $attributes
     * @return Model\TextConstruct
     */
    public function makeTextConstruct ($content, $type)
    {
        if ($type === 'xhtml' or preg_match('@^[^/]+/(xml|[^+]+\+xml)$@u', $type)) {
            $text = new Model\XmlTextConstruct($content, $type);
        } else {
            $text = new Model\PlainTextConstruct($content, $type);
        }
        return $text;
    }

}