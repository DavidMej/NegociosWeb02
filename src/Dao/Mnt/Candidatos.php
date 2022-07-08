<?php

    namespace Dao\Mnt;

    use Dao\Table;

    class Candidatos extends Table 
    {

        /*
            `idCandidato` int NOT NULL AUTO_INCREMENT,
            `identidadCand` varchar(13) DEFAULT NULL,
            `nombreCand` varchar(150) DEFAULT NULL,
            `edadCand` int DEFAULT NULL,

        */

        /**
         * Obtiene todos los registros de Scores
         *
         * @return array
         */

        public static function getAll(){
            $sqlstr = "SELECT * from candidatos;";
            return self::obtenerRegistros($sqlstr, array());
        }

        public static function getById(int $candidatoId){
            $sqlstr = "SELECT * from `candidatos` where idCandidato=:candidatoId;";
            $sqlParams = array("candidatoId" => $candidatoId);
            return self::obtenerUnRegistro($sqlstr, $sqlParams);
        }

        /**
         * Insert into Candidatos
         *
         * @param [type] $idCandidato  description
         * @param [type] $nombreCand description
         * @param [type] $identidadCan    description
         * @param [type] $edadCand    description
         *
         * @return void
        */

        public static function insert(
            $identidadCand,
            $nombreCand,
            $edadCand
        ) {
            $sqlstr = "INSERT INTO `candidatos`
            (`identidadCand`,
            `nombreCand`,
            `edadCand`)
            VALUES
            (:identidadCand,
            :nombreCand,
            :edadCand);";
    
            $sqlParams = [
                "identidadCand" => $identidadCand ,
                "nombreCand" => $nombreCand ,
                "edadCand" => $edadCand 
            ];
            return self::executeNonQuery($sqlstr, $sqlParams);
        }

        /**
     * Update Candidatos
     *
     * @param [type] $scoreid  description
     * @param [type] $identidadCand description
     * @param [type] $nombreCand    description
     * @param [type] $edadCand    descriptio     *
     * @return void
     */
    public static function update(
        $identidadCand,
        $nombreCand,
        $edadCand,
        $idCandidato
    ) {
        $sqlstr = "UPDATE `candidatos`
        SET
        `idCandidato` = :idCandidato,
        `identidadCand` = :identidadCand,
        `nombreCand` = :nombreCand,
        `edadCand` = :edadCand
        WHERE `idCandidato` = :idCandidato;
        ";
        $sqlParams = array(
            "identidadCand" => $identidadCand ,
            "nombreCand" => $nombreCand ,
            "edadCand" => $edadCand ,
            "idCandidato" => $idCandidato
        );
        return self::executeNonQuery($sqlstr, $sqlParams);
    }

    /**
     * Undocumented function
     *
     * @param [type] $idCandidato description
     *
     * @return void
     */
    public static function delete($idCandidato)
    {
        $sqlstr = "DELETE from `candidatos` where idCandidato = :idCandidato;";
        $sqlParams = array(
            "idCandidato" => $idCandidato
        );
        return self::executeNonQuery($sqlstr, $sqlParams);
    }

    }

?>