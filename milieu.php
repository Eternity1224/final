<?php
    if(isset($_REQUEST['pages'])){ 
        switch($_REQUEST['pages']){
            case 1:
                include('etudiants.php');
            break;
            case 2:
                include('matieres.php');
            break;
            case 3:
                include('notes.php');
            break;
            case 4:
                include('bulletin.php');
            break;
            case 5:
                include('mod_mat.php');
            break;
            case 6:
                include('mod_etu.php');
            break;
            case 7:
                include('mod_note.php');
            break;
            default:
                include('acceuil.php');
            }
        }else
        {
            include('acceuil.php');
        }
?>