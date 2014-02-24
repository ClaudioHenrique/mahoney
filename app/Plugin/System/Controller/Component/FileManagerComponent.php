<?php
/**
 * Common tasks to manage static files from Mahoney.
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
                return false;
            }
        else:
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
            throw new Exception("Error trying to delete");
        }
    }

}
