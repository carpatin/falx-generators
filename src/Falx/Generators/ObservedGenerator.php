<?php
namespace Falx\Generators;

use BadMethodCallException;
use InvalidArgumentException;
use Generator;
use Exception;

/**
 * Observed generator
 * An implementation of observer pattern using generators.
 * There is an observed generator and multiple observer generators allowed.\
 *
 * @author Dan Homorodean
 */
class ObservedGenerator
{
    /**
     * @var Generator
     */
    private $observed;

    /**
     * @var array
     */
    private $observers;

    /**
     * ObservedGenerator constructor.
     *
     * @param callable $observed
     * @param callable[] ...$observers
     */
    public function __construct(callable $observed, callable ...$observers)
    {
        if (count($observers) == 0) {
            throw new BadMethodCallException('No observer passed to constructor');
        }

        $this->observed = $observed();
        if (!$this->observed instanceof Generator) {
            throw new InvalidArgumentException('Observed is not a generator');
        }

        $this->observers = [];
        foreach ($observers as $i => $observer) {
            $observer = $observer();
            if (!$observer instanceof Generator) {
                throw new InvalidArgumentException(sprintf('Observer %d is not a generator', $i));
            }
            $this->observers[] = $observer;
        }
    }
    
    /**
     * Iterates observed generator.
     *
     * @return Generator|void
     */
    public function iterate()
    {

        foreach ($this->observed as $data) {
            foreach ($this->observers as $observer) {
                $observer->send($data);
            }
            yield $data;
        }
        foreach ($this->observers as $observer) {
            $observer->send(null);
        }
        return;
    }

    /**
     * @param int $offset
     * @return Generator
     * @throws Exception
     */
    public function getObserver($offset)
    {

        if (!array_key_exists($offset, $this->observers)) {
            throw new Exception(sprintf('No observer exists with offset %d', $offset));
        }
        return $this->observers[$offset];
    }
}



