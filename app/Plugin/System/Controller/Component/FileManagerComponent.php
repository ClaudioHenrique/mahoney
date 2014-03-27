<?php
/**
 * Common tasks to manage static files from Mahoney.
 * 
 */
class FileManagerComponent extends Component {
    
    /**
     * Common task to exclude a single file
     * 
     * @param string The file to delete
     */
    public function commonExclude($file) {
        unlink($file);
    }
    
//    public function installZipFromWeb($fileName, $zipUrl, $path) {
//        try {
//            $fh = fopen($path . $fileName . '.zip', 'w');
//            $ch = curl_init();
//            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
//            curl_setopt($ch, CURLOPT_URL, $zipUrl); 
//            curl_setopt($ch, CURLOPT_FILE, $fh); 
//            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // this will follow redirects
//            curl_exec($ch);
//            curl_close($ch);
//            fclose($fh);
//            
//            $zip = new ZipArchive;
//            if ($zip->open($path . $fileName . '.zip') === TRUE) {
//                $zip->extractTo($path);
//                $zip->close();
//                rename($path . "mahoney-".strtolower($fileName)."-master", $path . $fileName);
//                return true;
//            } else {
//                return sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), AuthComponent::user()["username"], sprintf(__d("system","File Manager")), sprintf(__d("system","to unzip")), $path.$fileName, "");
//            }
//            
//            return true;
//        } catch (Exception $ex) {
//            return $ex->getMessage();
//        }
//    }
    
    public function templateFile($file, $template, $filename = null) {
        if(is_file($file . ".template")):
            $fileContent = file_get_contents($file . ".template");
            foreach($template as $key => $value):
                if(strpos($fileContent, $key) !== false):
                    $fileContent = str_replace($key, $value, $fileContent);
                endif;
            endforeach;
            try {
                if($filename):
                    file_put_contents($filename, $fileContent, LOCK_EX);
                else:
                    file_put_contents($file, $fileContent, LOCK_EX);
                endif;
                return true;
            } catch(Exception $ex) {
                //CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Component")), AuthComponent::user()["username"], $_SERVER["REMOTE_ADDR"], __d("system", "to template"), $file.".template", sprintf(__d("system","file")), $ex->getMessage()));
                return false;
            }
        else:
            //CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Component")), AuthComponent::user()["username"], $_SERVER["REMOTE_ADDR"], __d("system", "to template"), $file.".template", sprintf(__d("system","file")), __d("system","The specified file/folder don't exist")));
            return false;
        endif;
    }
    
    /**
     * Recursively excludes a directory and all files inside.
     * 
     * @param string The directory to recursively exclude
     */
    public function recursiveExclude($dir) {
        try {
            foreach (glob($dir . '/*') as $file):
                if (is_dir($file)):
                    $this->recursiveExclude($file);
                else:
                    unlink($file);
                endif;
            endforeach;
            rmdir($dir);
        } catch(Exception $ex) {
            //CakeLog::write("activity", sprintf(__d("system","[%s] (User: %s; IP: %s) Error trying %s '%s' %s. Details: %s"), sprintf(__d("system","Component")), AuthComponent::user()["username"], $_SERVER["REMOTE_ADDR"], __d("system", "to delete"), $dir, sprintf(__d("system","file/folder")), $ex->getMessage()));
            throw new Exception(sprintf(__d("system","Error trying %s the '%s' %s."), __d("system", "to delete"), $dir, __d("system","file/folder")));
        }
    }

}
