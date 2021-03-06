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

use PHPUnit_Framework_TestCase as TestCase;

/**
 * Unit tests for the FeedBuilder class.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2016 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
class FeedBuilderTest extends TestCase
{
    public function testAddLink ()
    {
        $builder = new FeedBuilder();
        $builder
            ->link('http://example.com/self', 'self')
            ->link('http://example.com/via', 'via');
        $feed = $builder->getFeed();
        $this->assertCount(2, $feed['link']);
    }

    public function testUpdateUpdatedFromEntry ()
    {
        $builder = new FeedBuilder();
        $builder
            ->updated('2000-01-01T00:00:00Z')
            ->entry()
            ->updated('2001-01-01T00:00:00Z')
            ->add();

        $this->assertEquals('2001-01-01', $builder->get('updated')->format('Y-m-d'));
    }

    public function testCreateUpdated ()
    {
        $builder = new FeedBuilder();
        $this->assertNull($builder->get('updated'));
        $feed = $builder->getFeed();
        $this->assertNotNull($feed['updated']);
    }
}