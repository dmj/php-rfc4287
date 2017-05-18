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

namespace HAB\RFC4287\Serializer;

use HAB\RFC4287\Model;

use DateTime;
use XMLWriter;

/**
 * Serialize feed as XML.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2016 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
class XmlSerializer implements Model\VisitorInterface
{
    /**
     * XMLWriter instance.
     *
     * @var XMLWriter
     */
    private $writer;

    /**
     * Serialize feed as XML.
     *
     * @param  Model\Feed $feed
     * @return string
     */
    public function serialize (Model\Feed $feed)
    {
        $this->writer = new XMLWriter();
        $this->writer->openMemory();
        $this->writer->startDocument();

        $feed->accept($this, 'feed');

        $this->writer->endDocument();
        return $this->writer->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function visitFeed (Model\Feed $feed, $qname)
    {
        $this->writer->startElementNS(null, $qname, 'http://www.w3.org/2005/Atom');
        foreach ($feed as $qname => $element) {
            $element->accept($this, $qname);
        }
        $this->writer->endElement();
    }

    /**
     * {@inheritDoc}
     */
    public function visitEntry (Model\Entry $entry, $qname)
    {
        $this->writer->startElement($qname);
        foreach ($entry as $qname => $element) {
            $element->accept($this, $qname);
        }
        $this->writer->endElement();
    }

    /**
     * {@inheritDoc}
     */
    public function visitLink (Model\Link $link, $qname)
    {
        $this->writer->startElement($qname);
        if ($href = $link->getTarget()) {
            $this->writer->writeAttribute('href', $href);
        }
        if ($rel = $link->getRelation()) {
            $this->writer->writeAttribute('rel', $rel);
        }
        if ($hreflang = $link->getTargetLanguage()) {
            $this->writer->writeAttribute('hreflang', $hreflang);
        }
        if ($title = $link->getTitle()) {
            $this->writer->writeAttribute('title', $title);
        }
        if ($type = $link->getTargetType()) {
            $this->writer->writeAttribute('type', $type);
        }
        if ($length = $link->getTargetLength()) {
            $this->writer->writeAttribute('length', $length);
        }
        $this->writer->endElement();
    }

    /**
     * {@inheritDoc}
     */
    public function visitDateConstruct (Model\DateConstruct $datetime, $qname)
    {
        $this->writer->startElement($qname);
        $this->writer->text($datetime->format(DateTime::ATOM));
        $this->writer->endElement();
    }

    /**
     * {@inheritDoc}
     */
    public function visitPlainTextConstruct (Model\PlainTextConstruct $text, $qname)
    {
        $this->writer->startElement($qname);
        $this->writer->writeAttribute('type', $text->getType());
        $this->writer->text($text->getContent());
        $this->writer->endElement();
    }

    /**
     * {@inheritDoc}
     */
    public function visitXmlTextConstruct (Model\XmlTextConstruct $text, $qname)
    {
        $this->writer->startElement($qname);
        $this->writer->writeAttribute('type', $text->getType());
        $this->writer->writeRaw($text->getContent());
        $this->writer->endElement();
    }

    /**
     * {@inheritDoc}
     */
    public function visitPersonConstruct (Model\PersonConstruct $person, $qname)
    {
        $this->writer->startElement($qname);
        $this->writer->writeElement('name', $person->getName());
        if ($email = $person->getEmail()) {
            $this->writer->writeElement('email', $email);
        }
        if ($uri = $person->getUri()) {
            $this->writer->writeElement('uri', $uri);
        }
        $this->writer->endElement();
    }

    /**
     * {@inheritDoc}
     */
    public function visitLiteral (Model\Literal $literal, $qname)
    {
        $this->writer->startElement($qname);
        $this->writer->text($literal->getValue());
        $this->writer->endElement();
    }
    /**
     * {@inheritDoc}
     */
    public function visitCategory (Model\Category $category, $qname)
    {
        $this->writer->startElement($qname);
        $this->writer->writeAttribute('term', $category->getTerm());
        if ($scheme = $category->getScheme()) {
            $this->writer->writeAttribute('scheme', $scheme);
        }
        if ($label = $category->getLabel()) {
            $this->writer->writeAttribute('label', $label);
        }
        $this->writer->endElement();
    }

    /**
* {@inheritDoc}
*/
    public function visitGenerator (Model\Generator $generator, $qname)
    {
        $this->writer->startElement($qname);
        if ($version = $generator->getVersion()) {
            $this->writer->writeAttribute('version', $version);
        }
        if ($uri = $generator->getUri()) {
            $this->writer->writeAttribute('uri', $uri);
        }
        $this->writer->text($generator->getName());
        $this->writer->endElement();
    }

    /**
     * {@inheritDoc}
     */
    public function visitOutOfLineContent (Model\OutOfLineContent $content, $qname)
    {
        $this->writer->startElement($qname);
        $this->writer->writeAttribute('type', $content->getType());
        $this->writer->writeAttribute('src', $content->getSource());
        $this->writer->endElement();
    }
}