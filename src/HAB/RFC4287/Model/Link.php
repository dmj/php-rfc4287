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

namespace HAB\RFC4287\Model;

/**
 * Atom Link.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2016 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
class Link implements VisitableInterface
{
    /**
     * Link target.
     *
     * @var string
     */
    private $target;

    /**
     * Link relation.
     *
     * @var string
     */
    private $relation;

    /**
     * Link title.
     *
     * @var string
     */
    private $title;

    /**
     * Link target language.
     *
     * @var string
     */
    private $language;

    /**
     * Link target type.
     *
     * @var string
     */
    private $type;

    /**
     * Link target size.
     *
     * @var string
     */
    private $length;

    /**
     * Constructor.
     *
     * @param  string $target
     * @param  string $relation
     * @param  string
     * @return void
     */
    public function __construct ($target, $relation, $title = null, $type = null, $language = null, $length)
    {
        $this->target = $target;
        $this->relation = $relation;
        $this->title = $title;
        $this->language = $language;
        $this->type = $type;
        $this->length = $length;
    }

    /**
     * Return target.
     *
     * @return string
     */
    public function getTarget ()
    {
        return $this->target;
    }

    /**
     * Return relation.
     *
     * @return string
     */
    public function getRelation ()
    {
        return $this->relation;
    }

    /**
     * Return title.
     *
     * @return string|null
     */
    public function getTitle ()
    {
        return $this->title;
    }

    /**
     * Return target language.
     *
     * @return string|null
     */
    public function getTargetLanguage ()
    {
        return $this->language;
    }

    /**
     * Return type.
     *
     * @return string|null
     */
    public function getTargetType ()
    {
        return $this->type;
    }

    /**
     * Return length.
     *
     * @return string|null
     */
    public function getTargetLength ()
    {
        return $this->length;
    }

    /**
     * {@inheritDoc}
     */
    public function accept (VisitorInterface $visitor, $qname)
    {
        $visitor->visitLink($this, $qname);
    }

}