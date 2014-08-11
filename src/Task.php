<?php


namespace Estimate;

class Task
{
    /** @var  string */
    protected $name;

    /** @var  int */
    protected $optimisticEstimate;
    /** @var  int */
    protected $pessimisticEstimate;
    /** @var  int */
    protected $nominalEstimate;

    /**
     * @param string $name
     * @param int    $optimisticEstimate
     * @param int    $pessimisticEstimate
     * @param int    $nominalEstimate
     */
    public function  __construct($name, $optimisticEstimate, $pessimisticEstimate, $nominalEstimate)
    {
        $this->name                = $name;
        $this->optimisticEstimate  = $optimisticEstimate;
        $this->pessimisticEstimate = $pessimisticEstimate;
        $this->nominalEstimate     = $nominalEstimate;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getOptimisticEstimate()
    {
        return $this->optimisticEstimate;
    }

    /**
     * @return int
     */
    public function getPessimisticEstimate()
    {
        return $this->pessimisticEstimate;
    }

    /**
     * @return int
     */
    public function getNominalEstimate()
    {
        return $this->nominalEstimate;
    }
} 