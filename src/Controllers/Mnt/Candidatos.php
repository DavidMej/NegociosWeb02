<?php

 namespace Controllers\Mnt;

// ---------------------------------------------------------------
// Sección de imports
// ---------------------------------------------------------------
use Controllers\PublicController;
use Dao\Mnt\Candidatos as DaoCandidatos;
use Views\Renderer;


class Candidatos extends PublicController
{
    /**
     * Runs the controller
     *
     * @return void
     */
    public function run():void
    {
        // code
        $viewData = array();
        $viewData["Candidatos"] = DaoCandidatos::getAll();
        error_log(json_encode($viewData));
      
        Renderer::render('mnt/Candidatos', $viewData);
    }
}

?>