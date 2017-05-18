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

use PHPUnit_Framework_TestCase as TestCase;

/**
 * Unit tests for the Feed class.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2016 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
class FeedTest extends TestCase
{
    public function testProperlySortFeed ()
    {
        $feed = new Feed();
        $element = $this->getMockForAbstractClass(VisitableInterface::class);
        $feed['entry'] = clone($element);
        $feed['title'] = clone($element);

        foreach ($feed as $qname => $element) {
            $this->assertEquals($qname, 'entry', '<atom:entry> is the first element');
            break;
        }

        $feed->sort();

        foreach ($feed as $qname => $element) {
            $this->assertEquals($qname, 'title', '<atom:entry> is the last element');
            break;
        }

    }
}