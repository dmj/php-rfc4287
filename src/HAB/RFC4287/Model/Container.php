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

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use InvalidArgumentException;

/**
 * Atom container.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2016 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
abstract class Container implements ArrayAccess, IteratorAggregate
{
    /**
     * Feed data.
     *
     * @var array
     */
    protected $data;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct ()
    {
        $this->data = array();
    }

    /**
     * {@inheritDoc}
     */
    public function offsetGet ($index)
    {
        if (array_key_exists($index, $this->data)) {
            return $this->data[$index];
        }
    }

    /**
     * {@inheritDoc}
     */
    public function offsetSet ($index, $value)
    {
        if (!$value instanceof VisitableInterface) {
            throw new InvalidArgumentException(sprintf('Feed element must implement %s', VisitableInterface::class));
        }
        $this->data[$index] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function offsetExists ($index)
    {
        return array_key_exists($index, $this->data);
    }

    /**
     * {@inheritDoc}
     */
    public function offsetUnset ($index)
    {
        unset($this->data[$index]);
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator ()
    {
        return new ArrayIterator($this->data);
    }
}