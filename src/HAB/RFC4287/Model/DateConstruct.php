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

use DateTimeInterface;
use DateTime;

/**
 * Atom date construct.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2016 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
class DateConstruct implements VisitableInterface
{
    /**
     * Datetime instance.
     *
     * @var DateTimeInterface
     */
    private $datetime;

    /**
     * Constructor.
     *
     * @param  DateTimeInterface $datetime
     * @return void
     */
    public function __construct (DateTimeInterface $datetime)
    {
        $this->datetime = $datetime;
    }

    /**
     * Format the datetime object.
     *
     * @param  string $format
     * @return string
     */
    public function format ($format)
    {
        return $this->datetime->format($format);
    }

    /**
     * {@inheritDoc}
     */
    public function accept (VisitorInterface $visitor, $qname)
    {
        $visitor->visitDateConstruct($this, $qname);
    }
}