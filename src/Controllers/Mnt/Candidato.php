<?php

 namespace Controllers\Mnt;

// ---------------------------------------------------------------
// Sección de imports
// ---------------------------------------------------------------
use Controllers\PublicController;
use Views\Renderer;
use Utilities\Validators;
use Dao\Mnt\Candidatos;


class Candidato extends PublicController
{
    private $viewData = array();
    private $arrModeDesc = array();

    /**
     * Runs the controller
     *
     * @return void
     */
    public function run():void
    {
        // code
        $this->init();
        // Cuando es método GET (se llama desde la lista)
        if (!$this->isPostBack()) {
            $this->procesarGet();
        }
        // Cuando es método POST (click en el botón)
        if ($this->isPostBack()) {
            $this->procesarPost();
        }
        // Ejecutar Siempre
        $this->processView();
        Renderer::render('mnt/candidato', $this->viewData);
    }

    private function init()
    {
        $this->viewData = array();
        $this->viewData["mode"] = "";
        $this->viewData["mode_desc"] = "";
        $this->viewData["crsf_token"] = "";
        $this->viewData["idCandidato"] = "";
        $this->viewData["nombreCand"] = "";
        $this->viewData["error_nombreCand"] = array();
        $this->viewData["identidadCand"] = "";
        $this->viewData["error_identidadCand"] = array();
        $this->viewData["edadCand"] = "";
        $this->viewData["error_edadCand"] = array();
        $this->viewData["btnEnviarText"] = "Guardar";
        $this->viewData["readonly"] = false;
        $this->viewData["showBtn"] = true;

        $this->arrModeDesc = array(
            "INS"=>"Nuevo Producto",
            "UPD"=>"Editando %s %s",
            "DSP"=>"Detalle de %s %s",
            "DEL"=>"Eliminado %s %s"
        );

    }

    private function procesarGet()
    {
        if (isset($_GET["mode"])) {
            $this->viewData["mode"] = $_GET["mode"];
            if (!isset($this->arrModeDesc[$this->viewData["mode"]])) {
                error_log('Error: (Candidato) Mode solicitado no existe.');
                \Utilities\Site::redirectToWithMsg(
                    "index.php?page=mnt_candidatos",
                    "No se puede procesar su solicitud!"
                );
            }
        }
        if ($this->viewData["mode"] !== "INS" && isset($_GET["id"])) {
            $this->viewData["idCandidato"] = intval($_GET["id"]);
            $tmpCandidato = Candidatos::getById($this->viewData["idCandidato"]);
            error_log(json_encode($tmpCandidato));
            \Utilities\ArrUtils::mergeFullArrayTo($tmpCandidato, $this->viewData);
        }
    }
    private function procesarPost()
    {
        // Validar la entrada de Datos
        //  Todos valor puede y sera usando en contra del sistema
        $hasErrors = false;
        \Utilities\ArrUtils::mergeArrayTo($_POST, $this->viewData);
        if (isset($_SESSION[$this->name . "crsf_token"])
            && $_SESSION[$this->name . "crsf_token"] !== $this->viewData["crsf_token"]
        ) {
            \Utilities\Site::redirectToWithMsg(
                "index.php?page=mnt_candidatos",
                "ERROR: Algo inesperado sucedió con la petición Intente de nuevo."
            );
        }

        if (Validators::IsEmpty($this->viewData["identidadCand"])) {
            $this->viewData["error_identidadCand"][]
                = "La identidad es requerida";
            $hasErrors = true;
        }
        if (Validators::IsEmpty($this->viewData["nombreCand"])) {
            $this->viewData["error_nombreCand"][]
                = "El nombre del candidato es requerido";
            $hasErrors = true;
        }
        if (Validators::IsEmpty($this->viewData["edadCand"])) {
            $this->viewData["error_edadCand"][]
                = "La edada es requerida";
            $hasErrors = true;
        }
        error_log(json_encode($this->viewData));
        // Ahora procedemos con las modificaciones al registro
        if (!$hasErrors) {
            $result = null;
            switch($this->viewData["mode"]) {
            case 'INS':
                $result = Candidatos::insert(
                    $this->viewData["identidadCand"],
                    $this->viewData["nombreCand"],
                    $this->viewData["edadCand"],
                );
                if ($result) {
                        \Utilities\Site::redirectToWithMsg(
                            "index.php?page=mnt_candidatos",
                            "Candidato Guardado Satisfactoriamente!"
                        );
                }
                break;
            case 'UPD':
                $result = Candidatos::update(
                    $this->viewData["identidadCand"],
                    $this->viewData["nombreCand"],
                    $this->viewData["edadCand"],
                    intval($this->viewData["idCandidato"])
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        "index.php?page=mnt_candidatos",
                        "Candidato Actualizado Satisfactoriamente"
                    );
                }
                break;
            case 'DEL':
                $result = Candidatos::delete(
                    intval($this->viewData["idCandidato"])
                );
                if ($result) {
                    \Utilities\Site::redirectToWithMsg(
                        "index.php?page=mnt_candidatos",
                        "Candidato Eliminado Satisfactoriamente"
                    );
                }
                break;
            }
        }
    }

    private function processView()
    {
        if ($this->viewData["mode"] === "INS") {
            $this->viewData["mode_desc"]  = $this->arrModeDesc["INS"];
            $this->viewData["btnEnviarText"] = "Guardar Nuevo";
        } else {
            $this->viewData["mode_desc"]  = sprintf(
                $this->arrModeDesc[$this->viewData["mode"]],
                $this->viewData["identidadCand"],
                $this->viewData["nombreCand"],
                $this->viewData["edadCand"]
            );
            if ($this->viewData["mode"] === "DSP") {
                $this->viewData["readonly"] = true;
                $this->viewData["showBtn"] = false;
            }
            if ($this->viewData["mode"] === "DEL") {
                $this->viewData["readonly"] = true;
                $this->viewData["btnEnviarText"] = "Eliminar";
            }
            if ($this->viewData["mode"] === "UPD") {
                $this->viewData["btnEnviarText"] = "Actualizar";
            }
        }
        $this->viewData["crsf_token"] = md5(getdate()[0] . $this->name);
        $_SESSION[$this->name . "crsf_token"] = $this->viewData["crsf_token"];
    }
}