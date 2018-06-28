<?php
/**
 * Created by PhpStorm.
 * User: jennifer
 * Date: 28/06/2018
 * Time: 16:23
 */

namespace AppBundle\Service;

class JaugeProfil {
    public function indicativeJaugeProfil($genre, $nom, $prenom, $codePostal, $ville, $email, $pays, $tel, $dateNaissance)
    {
        $jaugeProfil = 0;

        if(isset($genre)){
            $jaugeProfil = $jaugeProfil + 5;
        }
        if(isset($nom)){
            $jaugeProfil = $jaugeProfil + 10;
        }
        if(isset($prenom)){
            $jaugeProfil = $jaugeProfil + 10;
        }
        if(isset($codePostal)){
            $jaugeProfil = $jaugeProfil + 10;
        }
        if(isset($ville)){
            $jaugeProfil = $jaugeProfil + 10;
        }
        if(isset($email)){
            $jaugeProfil = $jaugeProfil + 15;
        }
        if(isset($pays)){
            $jaugeProfil = $jaugeProfil + 5;
        }
        if(isset($tel)){
            $jaugeProfil = $jaugeProfil + 10;
        }
        if(isset($dateNaissance)){
            $jaugeProfil = $jaugeProfil + 5;
        }
        /*if(isset($photoProfil)){
            $jaugeProfil = $jaugeProfil + 20;
        }*/

        return $jaugeProfil;
    }
}