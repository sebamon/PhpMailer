<?php
class AbmArchivo{
public function UploadFile($dato)
    {
        $resultado=null;
        //$nombre=$dato['acnombre'];
        $dir = '../archivos/'; // Definimos Directorio donde se guarda el archivo
        $target_file = $dir . basename($_FILES["file"]["name"]);

        //recupero extension
        $extension=explode('.',$_FILES['file']['name']);
        $extension=$extension[1];
        // Comprobamos que no se hayan producido errores
        if ($_FILES['file']["error"] <= 0) 
        {
           
            $resultado.= "Nombre: " . $_FILES['file']['name'] . "<br />";
            $resultado.= "Tipo: " . $_FILES['file']['type'] . "<br />";
            $resultado.= "Tamaño: " . ($_FILES['file']["size"] / 1024) . " kB<br />";
            $resultado.= "Carpeta temporal: " . $_FILES['file']['tmp_name']." <br />";

            //Renombramos el archivo.
            //$_FILES['file']['name']=$nombre.'.'.$extension;

            // Intentamos copiar el archivo al servidor.
            if (!copy($_FILES['file']['tmp_name'], $dir.$_FILES['file']['name']))
            {
                $resultado.= 'ERROR: no se pudo cargar el archivo ';
            }else
            $resultado.= "El archivo ".$_FILES['file']['name'].' se ha copiado con Éxito <br />';
        }else
            {
                $resultado.= "ERROR: no se pudo cargar el archivo. No se pudo acceder al archivo Temporal";
            }
            return $resultado;
            
        
}
}
?>