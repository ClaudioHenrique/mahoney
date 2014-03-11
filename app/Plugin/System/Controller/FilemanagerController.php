<?php
App::uses('System.SystemAppController', 'Controller');

class FilemanagerController extends SystemAppController {
    
    public $uses = array();
    
    public $components = array("System.FileManager");
    
    public $config = array();
    
    public function __construct($request = null, $response = null){
        parent::__construct($request, $response);
        $this->config = array(
            "base_url" => "http://" . $_SERVER['HTTP_HOST'], // DON'T TOUCH (base url (only domain) of site (without final /))
            "upload_dir" => APP . "Plugin\\System\\webroot\\files\\", // Path from base_url to base of upload folder (with start and final /)
            "current_path" => APP . "Plugin\\System\\webroot\\files\\", // Relative path from filemanager folder to upload folder (with final /)
            "thumbs_base_path" => APP . "Plugin\\System\\webroot\\thumbs\\", // Relative path from filemanager folder to thumbs folder (with final /)
            "MaxSizeUpload" => 100, // Mb
            "default_language" => "pt_BR", // Default language file name
            "icon_theme" => "ico", // ico or ico_dark you can cusatomize just putting a folder inside filemanager/img
            "show_folder_size" => true, //Show or not show folder size in list view feature in filemanager (is possible, if there is a large folder, to greatly increase the calculations)
            "show_sorting_bar" => true, //Show or not show sorting feature in filemanager
            "loading_bar" => true, //Show or not show loading bar
            "transliteration" => false, //active or deactive the transliteration (mean convert all strange characters in A..Za..z0..9 characters)
            // Set maximum pixel width and/or maximum pixel height for all images
            // If you set a maximum width or height, oversized images are converted to those limits. Images smaller than the limit(s) are unaffected
            // if you don't need a limit set both to 0
            "image_max_width" => 0,
            "image_max_height" => 0,
            // If you set $image_resizing to true the script converts all uploaded images exactly to image_resizing_width x image_resizing_height dimension
            // If you set width or height to 0 the script automatically calculates the other dimension
            // Is possible that if you upload very big images the script not work to overcome this increase the php configuration of memory and time limit
            "image_resizing" => false,
            "image_resizing_width" => 0,
            "image_resizing_height" => 0,
            //******************
            // Default layout setting
            //
            // 0 => boxes
            // 1 => detailed list (1 column)
            // 2 => columns list (multiple columns depending on the width of the page)
            // YOU CAN ALSO PASS THIS PARAMETERS USING SESSION VAR => $_SESSION["VIEW"]=
            //
            //******************
            "default_view" => 0,
            // Set if the filename is truncated when overflow first row 
            "ellipsis_title_after_first_row" => true,
            // Permissions configuration
            "delete_files" => true,
            "create_folders" => true,
            "delete_folders" => true,
            "upload_files" => true,
            "rename_files" => true,
            "rename_folders" => true,
            "duplicate_files" => true,
            // Allowed extensions (lowercase insert)
            "ext_img" => array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg'),
            "ext_file" => array('doc', 'docx','rtf', 'pdf', 'xls', 'xlsx', 'txt', 'csv','html','xhtml','psd','sql','log','fla','xml','ade','adp','mdb','accdb','ppt','pptx','odt','ots','ott','odb','odg','otp','otg','odf','ods','odp','css','ai'),
            "ext_video" => array('mov', 'mpeg', 'mp4', 'avi', 'mpg','wma',"flv","webm"),
            "ext_music" => array('mp3', 'm4a', 'ac3', 'aiff', 'mid','ogg','wav'),
            "ext_misc" => array('zip', 'rar','gz','tar','iso','dmg'),
            "ext" => array_merge(
                array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg'),
                array('doc', 'docx','rtf', 'pdf', 'xls', 'xlsx', 'txt', 'csv','html','xhtml','psd','sql','log','fla','xml','ade','adp','mdb','accdb','ppt','pptx','odt','ots','ott','odb','odg','otp','otg','odf','ods','odp','css','ai'),
                array('mov', 'mpeg', 'mp4', 'avi', 'mpg','wma',"flv","webm"),
                array('mp3', 'm4a', 'ac3', 'aiff', 'mid','ogg','wav'),
                array('zip', 'rar','gz','tar','iso','dmg')
            ),
            // AVIARY config
            "aviary_active" => false,
            "aviary_key" => "",
            "aviary_secret" => "",
            "aviary_version" => 3,
            "aviary_language" => "pt",
            // The filter and sorter are managed through both javascript and php scripts because if you have a lot of
            // file in a folder the javascript script can't sort all or filter all, so the filemanager switch to php script.
            // The plugin automatic swich javascript to php when the current folder exceeds the below limit of files number
            "file_number_limit_js" => 500,
            // Set the names of any folders you want hidden (eg "hidden_folder1", "hidden_folder2" ) Remember all folders with these names will be hidden (you can set any exceptions in config.php files on folders)
            "hidden_folders" => array(),
            // Set the names of any files you want hidden. Remember these names will be hidden in all folders (eg "this_document.pdf", "that_image.jpg" )
            "hidden_files" => array('config.php'),
            // JAVA upload
            "java_upload" => true,
            "JAVAMaxSizeUpload" => 200,
            // Thumbnail for external use creation
            // New image resized creation with fixed path from filemanager folder after uploading (thumbnails in fixed mode)
            // If you want create images resized out of upload folder for use with external script you can choose this method, 
            // You can create also more than one image at a time just simply add a value in the array
            // Remember than the image creation respect the folder hierarchy so if you are inside source/test/test1/ the new image will create at
            // path_from_filemanager/test/test1/
            // PS if there isn't write permission in your destination folder you must set it
            "fixed_image_creation" => false, // Activate or not the creation of one or more image resized with fixed path from filemanager folder
            "fixed_path_from_filemanager" => array('/system/files'), // Fixed path of the image folder from the current position on upload folder
            "fixed_image_creation_name_to_prepend" => array('','test_'), // Name to prepend on filename
            "fixed_image_creation_to_append" => array('_test',''), // Name to append on filename
            "fixed_image_creation_width" => array(300, 400), // Width of image (you can leave empty if you set height)
            "fixed_image_creation_height" => array(200, ''), // Height of image (you can leave empty if you set width)
            // New image resized creation with relative path inside to upload folder after uploading (thumbnails in relative mode)
            // With Responsive filemanager you can create automatically resized image inside the upload folder, also more than one at a time
            // just simply add a value in the array
            // The image creation path is always relative so if i'm inside source/test/test1 and I upload an image, the path start from here
            "relative_image_creation" => false, //activate or not the creation of one or more image resized with relative path from upload folder
            "relative_path_from_current_pos" => array('thumb/','thumb/'), //relative path of the image folder from the current position on upload folder
            "relative_image_creation_name_to_prepend" => array('','test_'), //name to prepend on filename
            "relative_image_creation_name_to_append" => array('_test',''), //name to append on filename
            "relative_image_creation_width" => array(300,400), //width of image (you can leave empty if you set height)
            "relative_image_creation_height" => array(200,'') //height of image (you can leave empty if you set width)
        );
        
        if (isset($this->params['url']['fldr'])
            && !empty($this->params['url']['fldr'])
            && strpos($this->params['url']['fldr'],'../')===FALSE
            && strpos($this->params['url']['fldr'],'./')===FALSE)
            $subdir = $FileManager->urldecode(trim($this->params['url']['fldr'],"/") ."/");
        else
            $subdir = '';
        
        setcookie('last_position', $subdir, time() + (86400 * 7));
        
        if($subdir==""){
            if(!empty($_COOKIE['last_position'])
                && strpos($_COOKIE['last_position'],'.')===FALSE)
                $subdir= trim($_COOKIE['last_position']);
        }

        if($subdir=="/"){
            $subdir="";
        }
        
        if(!isset($_SESSION["subfolder"])) $_SESSION["subfolder"] = '';
        $rfm_subfolder = '';
        if(!empty($_SESSION["subfolder"]) && strpos($_SESSION["subfolder"],'../')===FALSE
           && strpos($_SESSION["subfolder"],'./')===FALSE && strpos($_SESSION["subfolder"],"/")!==0
            && strpos($_SESSION["subfolder"],'.')===FALSE) $rfm_subfolder = $_SESSION['subfolder'];
        
//        $this->config["rfm_subfolder"] = $rfm_subfolder;
        
        if($rfm_subfolder!="" && $rfm_subfolder[strlen($rfm_subfolder)-1]!="/") $rfm_subfolder.="/";
   
        if(!file_exists($this->config["current_path"] . $rfm_subfolder.$subdir)){
            $subdir='';
            if(!file_exists($this->config["current_path"] . $rfm_subfolder.$subdir)){
                $rfm_subfolder="";
            }
        }
        
        if(trim($rfm_subfolder)==""){
            $cur_dir = $this->config["upload_dir"] . $subdir;
            $cur_path = $this->config["current_path"] . $subdir;
            $thumbs_path = $this->config["thumbs_base_path"];
            $parent = $subdir;
        }else{
            $cur_dir = $upload_dir . $rfm_subfolder.$subdir;
            $cur_path = $current_path . $rfm_subfolder.$subdir;
            $thumbs_path = $thumbs_base_path. $rfm_subfolder;
            $parent=$rfm_subfolder.$subdir;
        }
        
        if(!is_dir($thumbs_path.$subdir)){
//            $this->FileManager->create_folder(false, $thumbs_path.$subdir);
        }

        if(isset($_GET['popup'])) $popup= $_GET['popup']; else $popup=0;
        //Sanitize popup
        $popup=!!$popup;

        //view type
        if(!isset($_SESSION["view_type"])){ $view=$default_view; $_SESSION["view_type"] = $view; }
        if(isset($_GET['view'])){ $view=$_GET['view']; $_SESSION["view_type"] = $view; }
        $view=$_SESSION["view_type"];

        if(isset($_GET["filter"])) $filter=fix_filename($_GET["filter"],$transliteration);
        else $filter='';

        if(!isset($_SESSION['sort_by'])) $_SESSION['sort_by']='';
        if(isset($_GET["sort_by"])) $sort_by=$_SESSION['sort_by']=fix_filename($_GET["sort_by"],$transliteration);
        else $sort_by=$_SESSION['sort_by'];

        if(!isset($_SESSION['descending'])) $_SESSION['descending']=false;
        if(isset($_GET["descending"])) $descending=$_SESSION['descending']=fix_filename($_GET["descending"],$transliteration)==="true";
        else $descending=$_SESSION['descending'];

        if(!isset($_GET['type'])) $_GET['type']=0;
        if(!isset($_GET['field_id'])) $_GET['field_id']='';

        $get_params = http_build_query(array(
            'type'      => $_GET['type'],
            'lang'      => $default_language,
            'popup'     => $popup,
            'field_id'  => isset($_GET['field_id']) ? $_GET['field_id'] : '',
            'fldr'      => ''
        ));

        $this->config["view"] = $view;
        $this->config["get_params"] = $get_params;
        $this->config["cur_dir"] = $cur_dir;
        $this->config["cur_path"] = $cur_path;
        $this->config["thumbs_path"] = $thumbs_path;
        $this->config["parent"] = $parent;
        $this->config["rfm_subfolder"] = $rfm_subfolder;
        $this->config["subdir"] = $subdir;
        
        define('lang_Select',_('Select'));
        define('lang_Erase',__('Erase'));
        define('lang_Open',__('Open'));
        define('lang_Confirm_del',__('Are you sure you want to delete this file?'));
        define('lang_All',__('All'));
        define('lang_Files',__('Files'));
        define('lang_Images',__('Images'));
        define('lang_Archives',__('Archives'));
        define('lang_Error_Upload',__('The uploaded file exceeds the max size allowed.'));
        define('lang_Error_extension',__('File extension is not allowed.'));
        define('lang_Upload_file',__('Upload'));
        define('lang_Filters',__('Filters'));
        define('lang_Videos',__('Videos'));
        define('lang_Music',__('Music'));
        define('lang_New_Folder',__('New Folder'));
        define('lang_Folder_Created',__('Folder correctly created'));
        define('lang_Existing_Folder',__('Existing folder'));
        define('lang_Confirm_Folder_del',__('Are you sure to delete the folder and all the elements in it?'));
        define('lang_Return_Files_List',__('Return to files list'));
        define('lang_Preview',__('Preview'));
        define('lang_Download',__('Download'));
        define('lang_Insert_Folder_Name',__('Insert folder name:'));
        define('lang_Root',__('root'));
        define('lang_Rename',__('Rename'));
        define('lang_Back',__('back'));
        define('lang_View',__('View'));
        define('lang_View_list',__('List view'));
        define('lang_View_columns_list',__('Columns list view'));
        define('lang_View_boxes',__('Box view'));
        define('lang_Toolbar',__('Toolbar'));
        define('lang_Actions',__('Actions'));
        define('lang_Rename_existing_file',__('The file is already existing'));
        define('lang_Rename_existing_folder',__('The folder is already existing'));
        define('lang_Empty_name',__('The name is empty'));
        define('lang_Text_filter',__('text filter'));
        define('lang_Swipe_help',__('Swipe the name of file/folder to show options'));
        define('lang_Upload_base',__('Base upload'));
        define('lang_Upload_java',__('JAVA upload (big size files)'));
        define('lang_Upload_java_help',"If the Java Applet doesn't load, 1. make sure you have Java installed, otherwise <a href='http://java.com/en/download/'>[download link]</a>   2. make sure nothing is blocked by your firewall");
        define('lang_Upload_base_help',"Drag & Drop files or click in the area above (modern browsers) and select the file(s). When the upload is complete, click the 'Return to files list' button.");
        define('lang_Type_dir',__('dir'));
        define('lang_Type',__('Type'));
        define('lang_Dimension',__('Dimension'));
        define('lang_Size',__('Size'));
        define('lang_Date',__('Date'));
        define('lang_Filename',__('Filename'));
        define('lang_Operations',__('Operations'));
        define('lang_Date_type',__('y-m-d'));
        define('lang_OK',__('OK'));
        define('lang_Cancel',__('Cancel'));
        define('lang_Sorting',__('sorting'));
        define('lang_Show_url',__('show URL'));
        define('lang_Extract',__('extract here'));
        define('lang_File_info',__('file info'));
        define('lang_Edit_image',__('edit image'));
        define('lang_Duplicate',__('Duplicate'));
    }
    
    public function beforeFilter() {
        parent::beforeFilter();
        
        $this->Auth->allow('index');
        
        $pageTitle = __('FileManager');
        
        $this->layout = "System.FileManager";
        
        $this->set('FileManager', $this->FileManager);
        
        $this->set($this->config);
    }
    
    public function index() {
        
        $pageTitle = "File Manager";
        
        $this->Session->write("verify", "RESPONSIVEfilemanager");
        
        $this->set('pageTitle', $pageTitle);
        
    }
    
    public function upload() {
        
        if($this->Session->read("verify") != "RESPONSIVEfilemanager"):
            throw new Exception(__("Forbidden"));
        endif;
        
        $varSend = array(
            "storeFolder" => $this->request->data["path"],
            "storeFolderThumb" => $this->request->data["path_thumb"],
            "path_pos" => strpos($this->request->data["path"],$this->config["current_path"]),
            "thumb_pos" => strpos($this->request->data["path_thumb"],$this->config["thumbs_base_path"]),
            "path" => $this->request->data["path"]
            
        );
        
        if($varSend["path_pos"] !== 0
        || $varSend["thumb_pos"] !==0
        || strpos($varSend["storeFolderThumb"],'../',strlen($this->config["thumbs_base_path"])) !== FALSE
        || strpos($varSend["storeFolderThumb"],'./',strlen($this->config["thumbs_base_path"])) !== FALSE
        || strpos($varSend["storeFolder"],'../',strlen($this->config["current_path"])) !== FALSE
        || strpos($varSend["storeFolder"],'./',strlen($this->config["current_path"])) !== FALSE)
        throw new Exception(__("Wrong path"));
        
        $this->set(compact($varSend));
        
    }
}