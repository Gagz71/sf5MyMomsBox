<?php


namespace App\AppBundle\Subscription;


use App\Entity\SubscriptionPlan;

class SubscriptionHelper
{
    /**
     * @varSubscriptionPlan[]
     */
    private $plans = [];

    public function __construct()
    {

        $this->plans[] = new SubscriptionPlan(
            'prod_IW5utBb3frLVT3',
            'My Mom\'s Box Mensuelle',
            'price_1Hv3ioLrKb2GsnXLxBdgERHd'
        );

        $this->plans[] = new SubscriptionPlan(
            'prod_IW5vXccwAjecQO',
            'My Mom\'s Box Trimestrielle',
            'price_1Hv3jgLrKb2GsnXLLGjs3UmJ'
        );

        $this->plans[] = new SubscriptionPlan(
            'prod_IW5wpyak9nbdnk',
            'My Mom\'s Box Semestrielle',
            'price_1Hv3kKLrKb2GsnXLcsV4Qi8Z'
        );

        $this->plans[] = new SubscriptionPlan(
            'prod_IVOhb2xNfZ5kVj',
            'My Mom\'s Box Annuelle',
            'price_1HuNu9LrKb2GsnXLXpa322We'
        );
    }

    /**
     * @param $planId
     * @return SubscriptionPlan|null
     */
    public function findPlan($planId)
    {
        foreach ($this->plans as $plan){
            if ($plan->getPlanId() == $planId){
                return $plan;
            }
        }
    }

}