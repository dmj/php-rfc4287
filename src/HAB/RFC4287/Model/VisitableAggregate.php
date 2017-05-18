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

use Countable;

/**
 * Aggregation of visible elements or data structures.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2016 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
class VisitableAggregate implements VisitableInterface, Countable
{
    /**
     * Aggregated elements or data structures.
     *
     * @var VisitableInterface[]
     */
    private $elements;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct ()
    {
        $this->elements = array();
    }

    /**
     * {@inheritDoc}
     */
    public function accept (VisitorInterface $visitor, $localname)
    {
        foreach ($this->elements as $element) {
            $element->accept($visitor, $localname);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function count ()
    {
        return count($this->elements);
    }

    /**
     * Append element or data structure.
     *
     * @param  VisitableInterface $element
     * @return self
     */
    public function append (VisitableInterface $element)
    {
        $this->elements []= $element;
    }
}