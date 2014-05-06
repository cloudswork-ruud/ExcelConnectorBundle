<?php

namespace spec\Pim\Bundle\ExcelConnectorBundle\Excel\Reader;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExcelConnectorBundle\Excel\Reader\ContentCache;
use Prophecy\Argument;

class RowIteratorSpec extends ObjectBehavior
{
    function let(ContentCache $contentCache) {
        $this->beConstructedWith($contentCache, __DIR__ . '/../../fixtures/sheet.xml');
        $contentCache->get(Argument::type('string'))->will(
            function ($args) {
                return 'string_' . $args[0];
            }
        );
    }
    
    function it_is_initializable()
    {
        $this->shouldHaveType('Pim\Bundle\ExcelConnectorBundle\Excel\Reader\RowIterator');
    }

    function it_iterates_through_worksheets()
    {
        $values = [
            1 => ['string_0', 'string_1'],
            2 => ['string_2', 'string3', 'string4'],
            4 => ['string_5', '', 'string6'],
            6 => ['', '1578', '37235']
        ];

        $this->rewind();
        foreach ($values as $key => $row) {
            $this->valid()->shouldReturn(true);
            $this->current()->shouldReturn($row);
            $this->key()->shouldReturn($key);
            $this->next();
        }

        $this->valid->shouldReturn(false);
    }

    function it_can_be_rewinded()
    {
        $this->rewind();
        $this->valid()->shouldReturn(true);
        $this->current()->shouldReturn(['string_0', 'string_1']);
        $this->key()->shouldReturn(1);
        $this->next();
        $this->rewind();
        $this->valid()->shouldReturn(true);
        $this->current()->shouldReturn(['string_0', 'string_1']);
        $this->key()->shouldReturn(1);
    }
}