<?php

namespace Mindbird\Contao\SisBundle\Table;

use Mindbird\Contao\SisBundle\SisLeadueModel;

class League
{
    public function optionsCallbackTeam($dc)
    {
        var_dump($dc);

        $league = SisLeadueModel::findBy('id', $dc->activeRecord->id);
        $category = array();
        if ($league) {
            while ($league->next()) {
                $category[$league->id] = $league->title;
            }
        }
        return $category;
    }
}
