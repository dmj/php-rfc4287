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
 * Category.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2016 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
class Category implements VisitableInterface
{
    /**
     * Term.
     *
     * @var string
     */
    private $term;

    /**
     * Scheme.
     *
     * @var string
     */
    private $scheme;

    /**
     * Label.
     *
     * @var string
     */
    private $label;

    /**
     * Constructor.
     *
     * @param  string             $term
     * @param  string             $scheme
     * @param  string             $label
     * @return void
     */
    public function __construct ($term, $scheme = null, $label = null)
    {
        $this->term = $term;
        $this->scheme = $scheme;
        $this->label = $label;
    }

    /**
     * Return term.
     *
     * @return string
     */
    public function getTerm ()
    {
        return $this->term;
    }

    /**
     * Return scheme.
     *
     * @return string|null
     */
    public function getScheme ()
    {
        return $this->scheme;
    }

    /**
     * Return label.
     *
     * @return string|null
     */
    public function getLabel ()
    {
        return $this->label;
    }

    /**
     * {@inheritDoc}
     */
    public function accept (VisitorInterface $visitor, $qname)
    {
        $visitor->visitCategory($this, $qname);
    }

}