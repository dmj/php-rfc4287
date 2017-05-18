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
 * Person construct.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2016 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
class PersonConstruct implements VisitableInterface
{
    /**
     * Name.
     *
     * @var string
     */
    private $name;

    /**
     * Email address.
     *
     * @var string
     */
    private $email;

    /**
     * Uri.
     *
     * @var string
     */
    private $uri;

    /**
     * Construct.
     *
     * @param  string $name
     * @param  string $email
     * @param  string $uri
     * @return void
     */
    public function __construct ($name = null, $email = null, $uri = null)
    {
        $this->email = $email;
        $this->name = $name;
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
     * Return email.
     *
     * @return string
     */
    public function getEmail ()
    {
        return $this->email;
    }

    /**
     * Return uri.
     *
     * @return string
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
        $visitor->visitPersonConstruct($this, $qname);
    }
}