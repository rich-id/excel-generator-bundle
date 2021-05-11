<?php declare(strict_types=1);

namespace RichId\ExcelGeneratorBundle\Builder\Partials;

use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Class AbstractBuilder
 *
 * @package    RichId\ExcelGeneratorBundle\Builder\Partials
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 Rich ID (https://www.rich-id.fr)
 */
abstract class AbstractBuilder
{
    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /**
     * @required
     */
    public function initAbstractBuilder(EventDispatcherInterface $eventDispatcher): void
    {
        $this->eventDispatcher  = $eventDispatcher;
    }
}
