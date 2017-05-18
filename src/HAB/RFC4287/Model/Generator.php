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
 * Generator.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2016 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
class Generator implements VisitableInterface
{
    /**
     * URI.
     *
     * @var string
     */
    private $uri;

    /**
     * Version.
     *
     * @var string
     */
    private $version;

    /**
     * Name.
     *
     * @var string
     */
    private $name;

    /**
     * Constructor.
     *
     * @param  string $name
     * @param  string $version
     * @param  string $uri
     * @return void
     */
    public function __construct ($name, $version = null, $uri = null)
    {
        $this->name = $name;
        $this->version = $version;
        $this->uri = $uri;
    }

    /**
     * Return name.
     *
     * @return string
     */
    public function getName ()
    {
        return $this->name;
    }
    /**
     * Return version.
     *
     * @return string|null
     */
    public function getVersion ()
    {
        return $this->version;
    }
    /**
     * Return uri.
     *
     * @return string|null
     */
    public function getUri ()
    {
        return $this->uri;
    }

    /**
     * {@inheritDoc}
     */
     public function accept (VisitorInterface $visitor, $qname)
     {
         $visitor->visitGenerator($this, $qname);
     }

}