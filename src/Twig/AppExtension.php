<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return array(
            new TwigFilter('orderByDate', array($this, 'dateFilter')),
        );
    }

    public function dateFilter($date)
    {
        for ($i = 0; $i < sizeof($date); $i++) {
            for ($j = 0; $j < sizeof($date); $j++) {
                if (strtotime($date[$i]->getFormatedDate()) > strtotime($date[$j]->getFormatedDate())) {
                    $tmp = $date[$i];
                    $date[$i] = $date[$j];
                    $date[$j] = $tmp;
                }
            }
        }

        return $date;
    }
}
