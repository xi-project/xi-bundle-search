<?php

namespace Xi\Bundle\SearchBundle\Event\Subscriber;

use Knp\Component\Pager\Event\ItemsEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Knp\Component\Pager\Event\Subscriber\Paginate\ElasticaQuerySubscriber as BaseSubscriber;

/**
 * Elastica query pagination.
 * Return the Elastica_ResultSet instead of it's results
 */
class ElasticaQuerySubscriber extends BaseSubscriber
{
    /**
     * @param  ItemsEvent $event
     */
    public function items(ItemsEvent $event)
    {
        if (is_array($event->target) && 2 === count($event->target) && isset($event->target[0], $event->target[1]) &&
            $event->target[0] instanceof \Elastica_Searchable && $event->target[1] instanceof \Elastica_Query) {
                list($searchable, $query) = $event->target;

                $query->setFrom($event->getOffset());
                $query->setLimit($event->getLimit());
                $results = $searchable->search($query);

                $event->count = $results->getTotalHits();
                if ($results->hasFacets()) {
                    $event->setCustomPaginationParameter('facets', $results->getFacets());
                }
                $event->items = $results;
                $event->stopPropagation();
        }
    }
}
