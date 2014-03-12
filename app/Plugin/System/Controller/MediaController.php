<?php
App::uses('System.SystemAppController', 'Controller');

class MediaController extends SystemAppController {

    public $uses = array('System.Config');
    public $components = array(
        'System.FileManager'
    );
    
    public $config = array();

    public function isAuthorized($user) {
        parent::isAuthorized($user);
        // TODO -> Check which role can access the MEDIA panel
        if (isset($user['role']) && intval($user['role']) >= 1):
            return true;
        endif;
    }
    
    public function beforeFilter() {
        parent::beforeFilter();
        
        $chroot = "";
        
        // TODO -> MEDIA BEHAVIOR DEPENDING ON USER ROLE
        // Defaults to users with role < 4 (common users)
        if($this->Auth->user()['role'] < 4):
            // Change MAX SIZE UPLOAD (TODO -> GET VALUE FROM DATABASE SYSTEM.CONFIG)
            $userConfig = array(
                "MaxSizeUpload" => 3,
                "delete_files" => false,
                "create_folders" => false,
                "delete_folders" => false,
                "upload_files" => false,
                "rename_files" => false,
                "rename_folders" => false,
                "duplicate_files" => false,
                "image_resizing_width" => 800,
                "image_resize" => true
            );
            // TODO -> User has CHROOT?
            if(true):
                $chroot = $this->Auth->user()["username"] . "/";
            endif;
        endif;
        
        ini_set("upload_max_filesize", "100M");
        ini_set("post_max_size","100M");
        
        $this->config = array(
            "base_url" => substr("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", 0, strpos("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]", "/system")), // DON'T TOUCH (base url (only domain) of site (without final /))
            "upload_dir" => "/files/" . $chroot, // Path from base_url to base of upload folder (with start and final /)
            "current_path" => "../webroot/files/" . $chroot, // Relative path from filemanager folder to upload folder (with final /)
            "thumbs_base_path" => "../webroot/thumbs/", // Relative path from filemanager folder to thumbs folder (with final /)
            "MaxSizeUpload" => 100, // Mb
            "default_language" => "en_US", // Default language file name
            "icon_theme" => "ico", // ico or ico_dark you can cusatomize just putting a folder inside filemanager/img
            "show_folder_size" => true, //Show or not show folder size in list view feature in filemanager (is possible, if there is a large folder, to greatly increase the calculations)
            "show_sorting_bar" => true, //Show or not show sorting feature in filemanager
            "loading_bar" => true, //Show or not show loading bar
            "transliteration" => true, //active or deactive the transliteration (mean convert all strange characters in A..Za..z0..9 characters)
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
            "ext_file" => array('doc', 'docx', 'rtf', 'pdf', 'xls', 'xlsx', 'txt', 'csv', 'html', 'xhtml', 'psd', 'sql', 'log', 'fla', 'xml', 'ade', 'adp', 'mdb', 'accdb', 'ppt', 'pptx', 'odt', 'ots', 'ott', 'odb', 'odg', 'otp', 'otg', 'odf', 'ods', 'odp', 'css', 'ai'),
            "ext_video" => array('mov', 'mpeg', 'mp4', 'avi', 'mpg', 'wma', "flv", "webm"),
            "ext_music" => array('mp3', 'm4a', 'ac3', 'aiff', 'mid', 'ogg', 'wav'),
            "ext_misc" => array('zip', 'rar', 'gz', 'tar', 'iso', 'dmg'),
            "ext" => array_merge(
                    array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg'), array('doc', 'docx', 'rtf', 'pdf', 'xls', 'xlsx', 'txt', 'csv', 'html', 'xhtml', 'psd', 'sql', 'log', 'fla', 'xml', 'ade', 'adp', 'mdb', 'accdb', 'ppt', 'pptx', 'odt', 'ots', 'ott', 'odb', 'odg', 'otp', 'otg', 'odf', 'ods', 'odp', 'css', 'ai'), array('mov', 'mpeg', 'mp4', 'avi', 'mpg', 'wma', "flv", "webm"), array('mp3', 'm4a', 'ac3', 'aiff', 'mid', 'ogg', 'wav'), array('zip', 'rar', 'gz', 'tar', 'iso', 'dmg')
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
            "hidden_files" => array(),
            // JAVA upload
            "java_upload" => false,
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
            "fixed_image_creation_name_to_prepend" => array('', 'test_'), // Name to prepend on filename
            "fixed_image_creation_to_append" => array('_test', ''), // Name to append on filename
            "fixed_image_creation_width" => array(300, 400), // Width of image (you can leave empty if you set height)
            "fixed_image_creation_height" => array(200, ''), // Height of image (you can leave empty if you set width)
            // New image resized creation with relative path inside to upload folder after uploading (thumbnails in relative mode)
            // With Responsive filemanager you can create automatically resized image inside the upload folder, also more than one at a time
            // just simply add a value in the array
            // The image creation path is always relative so if i'm inside source/test/test1 and I upload an image, the path start from here
            "relative_image_creation" => false, //activate or not the creation of one or more image resized with relative path from upload folder
            "relative_path_from_current_pos" => array('small/'), //relative path of the image folder from the current position on upload folder
            "relative_image_creation_name_to_prepend" => array(''), //name to prepend on filename
            "relative_image_creation_name_to_append" => array('-small'), //name to append on filename
            "relative_image_creation_width" => array(550), //width of image (you can leave empty if you set height)
            "relative_image_creation_height" => array() //height of image (you can leave empty if you set width)
        );
        
        // If userConfig exists, merge with this->config
        if(isset($userConfig)):
            $this->config = array_merge($this->config, $userConfig);
        endif;
        
        if (isset($this->params['url']['fldr']) && !empty($this->params['url']['fldr']) && strpos($this->params['url']['fldr'], '../') === FALSE && strpos($this->params['url']['fldr'], './') === FALSE)
            $subdir = urldecode(trim($this->params['url']['fldr'], "/") . "/");
        else
            $subdir = '';

        setcookie('last_position', $subdir, time() + (86400 * 7));

        if ($subdir == "") {
            if (!empty($_COOKIE['last_position']) && strpos($_COOKIE['last_position'], '.') === FALSE)
                $subdir = trim($_COOKIE['last_position']);
        }

        if ($subdir == "/") {
            $subdir = "";
        }

        if (!isset($_SESSION["subfolder"]))
            $_SESSION["subfolder"] = '';
        $rfm_subfolder = '';
        if (!empty($_SESSION["subfolder"]) && strpos($_SESSION["subfolder"], '../') === FALSE && strpos($_SESSION["subfolder"], './') === FALSE && strpos($_SESSION["subfolder"], "/") !== 0 && strpos($_SESSION["subfolder"], '.') === FALSE)
            $rfm_subfolder = $_SESSION['subfolder'];

        $this->config["rfm_subfolder"] = $rfm_subfolder;

        if ($rfm_subfolder != "" && $rfm_subfolder[strlen($rfm_subfolder) - 1] != "/")
            $rfm_subfolder.="/";

        if (!file_exists($this->config["current_path"] . $rfm_subfolder . $subdir)) {
            $subdir = '';
            if (!file_exists($this->config["current_path"] . $rfm_subfolder . $subdir)) {
                $rfm_subfolder = "";
            }
        }

        if (trim($rfm_subfolder) == "") {
            $cur_dir = $this->config["upload_dir"] . $subdir;
            $cur_path = $this->config["current_path"] . $subdir;
            $thumbs_path = $this->config["thumbs_base_path"];
            $parent = $subdir;
        } else {
            $cur_dir = $upload_dir . $rfm_subfolder . $subdir;
            $cur_path = $this->config["current_path"] . $rfm_subfolder . $subdir;
            $thumbs_path = $this->config["thumbs_base_path"] . $rfm_subfolder;
            $parent = $rfm_subfolder . $subdir;
        }

        if (!is_dir($thumbs_path . $subdir)) {
//            $this->FileManager->create_folder(false, $thumbs_path.$subdir);
        }

        if (isset($_GET['popup']))
            $popup = $_GET['popup'];
        else
            $popup = 0;
        //Sanitize popup
        $popup = !!$popup;

        //view type
        if (!isset($_SESSION["view_type"])) {
            $view = $this->config["default_view"];
            $_SESSION["view_type"] = $view;
        }
        if (isset($_GET['view'])) {
            $view = $_GET['view'];
            $_SESSION["view_type"] = $view;
        }
        $view = $_SESSION["view_type"];

        if (isset($_GET["filter"]))
            $filter = $this->FileManager->fix_filename($_GET["filter"], $this->config["transliteration"]);
        else
            $filter = '';

        if (!isset($_SESSION['sort_by']))
            $_SESSION['sort_by'] = '';
        if (isset($_GET["sort_by"]))
            $sort_by = $_SESSION['sort_by'] = $this->FileManager->fix_filename($_GET["sort_by"], $this->config["transliteration"]);
        else
            $sort_by = $_SESSION['sort_by'];

        if (!isset($_SESSION['descending']))
            $_SESSION['descending'] = false;
        if (isset($_GET["descending"]))
            $descending = $_SESSION['descending'] = $this->FileManager->fix_filename($_GET["descending"], $this->config["transliteration"]) === "true";
        else
            $descending = $_SESSION['descending'];

        if (!isset($_GET['type']))
            $_GET['type'] = 0;
        if (!isset($_GET['field_id']))
            $_GET['field_id'] = '';

        $get_params = http_build_query(array(
            'type' => $_GET['type'],
            'lang' => $this->config['default_language'],
            'popup' => $popup,
            'field_id' => isset($_GET['field_id']) ? $_GET['field_id'] : '',
            'fldr' => ''
        ));

        $this->config["lang"] = $this->config['default_language'];
        $this->config["sort_by"] = $sort_by;
        $this->config["descending"] = $descending;
        $this->config["filter"] = $filter;
        $this->config["popup"] = $popup;
        $this->config["view"] = $view;
        $this->config["get_params"] = $get_params;
        $this->config["cur_dir"] = $cur_dir;
        $this->config["cur_path"] = $cur_path;
        $this->config["thumbs_path"] = $thumbs_path;
        $this->config["parent"] = $parent;
        $this->config["rfm_subfolder"] = $rfm_subfolder;
        $this->config["subdir"] = $subdir;

        define('lang_Select', _('Select'));
        define('lang_Erase', __('Erase'));
        define('lang_Open', __('Open'));
        define('lang_Confirm_del', __('Are you sure you want to delete this file?'));
        define('lang_All', __('All'));
        define('lang_Files', __('Files'));
        define('lang_Images', __('Images'));
        define('lang_Archives', __('Archives'));
        define('lang_Error_Upload', __('The uploaded file exceeds the max size allowed.'));
        define('lang_Error_extension', __('File extension is not allowed.'));
        define('lang_Upload_file', __('Upload'));
        define('lang_Filters', __('Filters'));
        define('lang_Videos', __('Videos'));
        define('lang_Music', __('Music'));
        define('lang_New_Folder', __('New Folder'));
        define('lang_Folder_Created', __('Folder correctly created'));
        define('lang_Existing_Folder', __('Existing folder'));
        define('lang_Confirm_Folder_del', __('Are you sure to delete the folder and all the elements in it?'));
        define('lang_Return_Files_List', __('Return to files list'));
        define('lang_Preview', __('Preview'));
        define('lang_Download', __('Download'));
        define('lang_Insert_Folder_Name', __('Insert folder name:'));
        define('lang_Root', __('root'));
        define('lang_Rename', __('Rename'));
        define('lang_Back', __('back'));
        define('lang_View', __('View'));
        define('lang_View_list', __('List view'));
        define('lang_View_columns_list', __('Columns list view'));
        define('lang_View_boxes', __('Box view'));
        define('lang_Toolbar', __('File Manager'));
        define('lang_Actions', __('Actions'));
        define('lang_Rename_existing_file', __('The file is already existing'));
        define('lang_Rename_existing_folder', __('The folder is already existing'));
        define('lang_Empty_name', __('The name is empty'));
        define('lang_Text_filter', __('text filter'));
        define('lang_Swipe_help', __('Swipe the name of file/folder to show options'));
        define('lang_Upload_base', __('Base upload'));
        define('lang_Upload_java', __('JAVA upload (big size files)'));
        define('lang_Upload_java_help', __("If the Java Applet doesn't load, 1. make sure you have Java installed, otherwise <a href='http://java.com/en/download/'>[download link]</a>   2. make sure nothing is blocked by your firewall"));
        define('lang_Upload_base_help', __("Drag & Drop files or click in the area above (modern browsers) and select the file(s). When the upload is complete, click the 'Return to files list' button."));
        define('lang_Type_dir', __('dir'));
        define('lang_Type', __('Type'));
        define('lang_Dimension', __('Dimension'));
        define('lang_Size', __('Size'));
        define('lang_Date', __('Date'));
        define('lang_Filename', __('Filename'));
        define('lang_Operations', __('Operations'));
        define('lang_Date_type', __('y-m-d'));
        define('lang_OK', __('OK'));
        define('lang_Cancel', __('Cancel'));
        define('lang_Sorting', __('sorting'));
        define('lang_Show_url', __('show URL'));
        define('lang_Extract', __('extract here'));
        define('lang_File_info', __('file info'));
        define('lang_Edit_image', __('edit image'));
        define('lang_Duplicate', __('Duplicate'));
        
//        $this->Auth->allow(array('index', 'execute', 'ajax', 'upload', 'download'));

        $pageTitle = __('Media');

        $this->layout = "System.Media";

        $this->set('pageTitle', $pageTitle);
        
        $this->set('FileManager', $this->FileManager);

        $this->set($this->config);
        
    }

    public function ajax() {
        
        $this->autoRender = false;
        
        if (isset($_GET['action']))
            switch ($_GET['action']) {
                case 'view':
                    if (isset($_GET['type']))
                        $_SESSION["view_type"] = $_GET['type'];
                    else
                        throw new Exception('view type number missing');
                    break;
                case 'sort':
                    if (isset($_GET['sort_by']))
                        $_SESSION["sort_by"] = $_GET['sort_by'];
                    if (isset($_GET['descending']))
                        $_SESSION["descending"] = $_GET['descending'] === "true";
                    break;
                case 'image_size':
                    $pos = strpos($_POST['path'], $upload_dir);
                    if ($pos !== false) {
                        $info = getimagesize(substr_replace($_POST['path'], $current_path, $pos, strlen($upload_dir)));
                        echo json_encode($info);
                    }

                    break;
                case 'save_img':
                    $info = pathinfo($_POST['name']);
                    if (strpos($_POST['path'], '/') === 0 || strpos($_POST['path'], '../') !== FALSE || strpos($_POST['path'], './') === 0 || strpos($_POST['url'], 'http://featherfiles.aviary.com/') !== 0 || $_POST['name'] != fix_filename($_POST['name'], $transliteration) || !in_array(strtolower($info['extension']), array('jpg', 'jpeg', 'png')))
                        throw new Exception('wrong data');
                    $image_data = get_file_by_url($_POST['url']);
                    if ($image_data === false) {
                        throw new Exception('file could not be loaded');
                    }
                    file_put_contents($current_path . $_POST['path'] . $_POST['name'], $image_data);
                    //new thumb creation
                    //try{
                    create_img_gd($current_path . $_POST['path'] . $_POST['name'], $thumbs_base_path . $_POST['path'] . $_POST['name'], 122, 91);
                    new_thumbnails_creation($current_path . $_POST['path'], $current_path . $_POST['path'] . $_POST['name'], $_POST['name'], $current_path, $relative_image_creation, $relative_path_from_current_pos, $relative_image_creation_name_to_prepend, $relative_image_creation_name_to_append, $relative_image_creation_width, $relative_image_creation_height, $fixed_image_creation, $fixed_path_from_filemanager, $fixed_image_creation_name_to_prepend, $fixed_image_creation_to_append, $fixed_image_creation_width, $fixed_image_creation_height);
                    /* } catch (Exception $e) {
                      $src_thumb=$mini_src="";
                      } */
                    break;
                case 'extract':
                    if (strpos($_POST['path'], '/') === 0 || strpos($_POST['path'], '../') !== FALSE || strpos($_POST['path'], './') === 0)
                        throw new Exception('wrong path');
                    $path = $current_path . $_POST['path'];
                    $info = pathinfo($path);
                    $base_folder = $current_path . fix_dirname($_POST['path']) . "/";
                    switch ($info['extension']) {
                        case "zip":
                            $zip = new ZipArchive;
                            if ($zip->open($path) === true) {
                                //make all the folders
                                for ($i = 0; $i < $zip->numFiles; $i++) {
                                    $OnlyFileName = $zip->getNameIndex($i);
                                    $FullFileName = $zip->statIndex($i);
                                    if ($FullFileName['name'][strlen($FullFileName['name']) - 1] == "/") {
                                        create_folder($base_folder . $FullFileName['name']);
                                    }
                                }
                                //unzip into the folders
                                for ($i = 0; $i < $zip->numFiles; $i++) {
                                    $OnlyFileName = $zip->getNameIndex($i);
                                    $FullFileName = $zip->statIndex($i);

                                    if (!($FullFileName['name'][strlen($FullFileName['name']) - 1] == "/")) {
                                        $fileinfo = pathinfo($OnlyFileName);
                                        if (in_array(strtolower($fileinfo['extension']), $ext)) {
                                            copy('zip://' . $path . '#' . $OnlyFileName, $base_folder . $FullFileName['name']);
                                        }
                                    }
                                }
                                $zip->close();
                            } else {
                                echo 'failed to open file';
                            }
                            break;
                        case "gz":
                            $p = new PharData($path);
                            $p->decompress(); // creates files.tar
                            break;
                        case "tar":
                            // unarchive from the tar
                            $phar = new PharData($path);
                            $phar->decompressFiles();
                            $files = array();
                            check_files_extensions_on_phar($phar, $files, '', $ext);
                            $phar->extractTo($current_path . fix_dirname($_POST['path']) . "/", $files, TRUE);

                            break;
                    }
                    break;
                case 'media_preview':
                    $preview_file = str_replace("/webroot","",$_GET["file"]);
                    $info = pathinfo($_GET["file"]);
                    ?>
                    <div id="jp_container_1" class="jp-video " style="margin:0 auto;">
                        <div class="jp-type-single">
                            <div id="jquery_jplayer_1" class="jp-jplayer"></div>
                            <div class="jp-gui">
                                <div class="jp-video-play">
                                    <a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a>
                                </div>
                                <div class="jp-interface">
                                    <div class="jp-progress">
                                        <div class="jp-seek-bar">
                                            <div class="jp-play-bar"></div>
                                        </div>
                                    </div>
                                    <div class="jp-current-time"></div>
                                    <div class="jp-duration"></div>
                                    <div class="jp-controls-holder">
                                        <ul class="jp-controls">
                                            <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
                                            <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
                                            <li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
                                            <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
                                            <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
                                            <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
                                        </ul>
                                        <div class="jp-volume-bar">
                                            <div class="jp-volume-bar-value"></div>
                                        </div>
                                        <ul class="jp-toggles">
                                            <li><a href="javascript:;" class="jp-full-screen" tabindex="1" title="full screen">full screen</a></li>
                                            <li><a href="javascript:;" class="jp-restore-screen" tabindex="1" title="restore screen">restore screen</a></li>
                                            <li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
                                            <li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
                                        </ul>
                                    </div>
                                    <div class="jp-title" style="display:none;">
                                        <ul>
                                            <li></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="jp-no-solution">
                                <span>Update Required</span>
                                To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                            </div>
                        </div>
                    </div>
                    <?php if (in_array(strtolower($info['extension']), $this->config["ext_music"])) { ?>

                        <script type="text/javascript">
                            $(document).ready(function() {

                                $("#jquery_jplayer_1").jPlayer({
                                    ready: function() {
                                        $(this).jPlayer("setMedia", {
                                            title: "<?php $_GET['title']; ?>",
                                            mp3: "<?php echo $preview_file; ?>",
                                            m4a: "<?php echo $preview_file; ?>",
                                            oga: "<?php echo $preview_file; ?>",
                                            wav: "<?php echo $preview_file; ?>"
                                        });
                                    },
                                    swfPath: "js",
                                    solution: "html,flash",
                                    supplied: "mp3, m4a, midi, mid, oga,webma, ogg, wav",
                                    smoothPlayBar: true,
                                    keyEnabled: false
                                });
                            });
                        </script>

                        <?php } elseif (in_array(strtolower($info['extension']), $this->config["ext_video"])) {
                        ?>

                        <script type="text/javascript">
                            $(document).ready(function() {

                                $("#jquery_jplayer_1").jPlayer({
                                    ready: function() {
                                        $(this).jPlayer("setMedia", {
                                            title: "<?php $_GET['title']; ?>",
                                            m4v: "<?php echo $preview_file; ?>",
                                            ogv: "<?php echo $preview_file; ?>"
                                        });
                                    },
                                    swfPath: "js",
                                    solution: "html,flash",
                                    supplied: "mp4, m4v, ogv, flv, webmv, webm",
                                    smoothPlayBar: true,
                                    keyEnabled: false
                                });

                            });
                        </script>

                        <?php
                    }
                    break;
            } else
            throw new Exception('no action passed');
    }

    public function index() {

        $this->Session->write("verify", "RESPONSIVEfilemanager");
        
    }

    public function execute() {

        $this->autoRender = false;

        if ($this->Session->read("verify") != "RESPONSIVEfilemanager"):
            throw new Exception(__("Forbidden"));
        endif;

        $thumb_pos = strpos($_POST['path_thumb'], $this->config["thumbs_base_path"]);
        if ($thumb_pos != 0 || strpos($_POST['path_thumb'], '../', strlen($this->config["thumbs_base_path"]) + $thumb_pos) !== FALSE || strpos($_POST['path'], '/') === 0 || strpos($_POST['path'], '../') !== FALSE || strpos($_POST['path'], './') === 0)
            throw new Exception('wrong path');

        $base = $this->config["current_path"];
        $path = $this->config["current_path"] . $_POST['path'];

        $path = $this->config["current_path"] . $_POST['path'];
        $path_thumb = $_POST['path_thumb'];
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
            if (strpos($name, '../') !== FALSE)
                throw new Exception('wrong name');
        }

        $info = pathinfo($path);
        if (isset($info['extension']) && !(isset($_GET['action']) && $_GET['action'] == 'delete_folder') && !in_array(strtolower($info['extension']), $this->config["ext"])) {
            throw new Exception('wrong extension');
        }

        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'delete_file':
                    if ($this->config["delete_files"]) {
                        unlink($path);
                        if (file_exists($path_thumb))
                            unlink($path_thumb);

                        $info = pathinfo($path);
                        if ($this->config["relative_image_creation"]) {
                            foreach ($this->config["relative_path_from_current_pos"] as $k => $path) {
                                if ($path != "" && $path[strlen($path) - 1] != "/")
                                    $path.="/";
                                if (file_exists($info['dirname'] . "/" . $path . $this->config["relative_image_creation_name_to_prepend"][$k] . $info['filename'] . $this->config["relative_image_creation_name_to_append"][$k] . "." . $info['extension'])) {
                                    unlink($info['dirname'] . "/" . $path . $this->config["relative_image_creation_name_to_prepend"][$k] . $info['filename'] . $this->config["relative_image_creation_name_to_append"][$k] . "." . $info['extension']);
                                }
                            }
                        }

                        if ($this->config["fixed_image_creation"]) {
                            foreach ($this->config["fixed_path_from_filemanager"] as $k => $path) {
                                if ($path != "" && $path[strlen($path) - 1] != "/")
                                    $path.="/";
                                $base_dir = $path . substr_replace($info['dirname'] . "/", '', 0, strlen($this->config["current_path"]));
                                if (file_exists($base_dir . $this->config["fixed_image_creation_name_to_prepend"][$k] . $info['filename'] . $this->config["fixed_image_creation_to_append"][$k] . "." . $info['extension'])) {
                                    unlink($base_dir . $this->config["fixed_image_creation_name_to_prepend"][$k] . $info['filename'] . $this->config["fixed_image_creation_to_append"][$k] . "." . $info['extension']);
                                }
                            }
                        }
                    }
                    break;
                case 'delete_folder':
                    if ($this->config["delete_folders"]) {
                        if (is_dir($path_thumb))
                            $this->FileManager->deleteDir($path_thumb);
                        if (is_dir($path)) {
                            $this->FileManager->deleteDir($path);
                            if ($this->config["fixed_image_creation"]) {
                                foreach ($this->config["fixed_path_from_filemanager"] as $k => $paths) {
                                    if ($paths != "" && $paths[strlen($paths) - 1] != "/")
                                        $paths.="/";
                                    $base_dir = $paths . substr_replace($path, '', 0, strlen($this->config["current_path"]));
                                    if (is_dir($base_dir))
                                        $this->FileManager->deleteDir($base_dir);
                                }
                            }
                        }
                    }
                    break;
                case 'create_folder':
                    if ($this->config["create_folders"]) {
                        $this->FileManager->create_folder($this->FileManager->fix_path($path, $this->config["transliteration"]), $this->FileManager->fix_path($path_thumb, $this->config["transliteration"]));
                    }
                    break;
                case 'rename_folder':
                    if ($this->config["rename_folders"]) {
                        $name = $this->FileManager->fix_filename($name, $this->config["transliteration"]);
                        $name = str_replace('.', '', $name);

                        if (!empty($name)) {
                            if (!$this->FileManager->rename_folder($path, $name, $this->config["transliteration"]))
                                throw new Exception(lang_Rename_existing_folder);
                            $this->FileManager->rename_folder($path_thumb, $name, $this->config["transliteration"]);
                            if ($this->config["fixed_image_creation"]) {
                                foreach ($this->config["fixed_path_from_filemanager"] as $k => $paths) {
                                    if ($paths != "" && $paths[strlen($paths) - 1] != "/")
                                        $paths.="/";
                                    $base_dir = $paths . substr_replace($path, '', 0, strlen($this->config["current_path"]));
                                    $this->FileManager->rename_folder($base_dir, $name, $this->config["transliteration"]);
                                }
                            }
                        }else {
                            throw new Exception(lang_Empty_name);
                        }
                    }
                    break;
                case 'rename_file':
                    if ($this->config["rename_files"]) {
                        $name = $this->FileManager->fix_filename($name, $this->config["transliteration"]);
                        if (!empty($name)) {
                            if (!$this->FileManager->rename_file($path, $name, $this->config["transliteration"]))
                                throw new Exception(lang_Rename_existing_file);
                            $this->FileManager->rename_file($path_thumb, $name, $this->config["transliteration"]);
                            if ($this->config["fixed_image_creation"]) {
                                $info = pathinfo($path);
                                foreach ($this->config["fixed_path_from_filemanager"] as $k => $paths) {
                                    if ($paths != "" && $paths[strlen($paths) - 1] != "/")
                                        $paths.="/";
                                    $base_dir = $paths . substr_replace($info['dirname'] . "/", '', 0, strlen($this->config["current_path"]));
                                    if (file_exists($base_dir . $this->config["fixed_image_creation_name_to_prepend"][$k] . $info['filename'] . $this->config["fixed_image_creation_to_append"][$k] . "." . $info['extension'])) {
                                        $this->FileManager->rename_file($base_dir . $this->config["fixed_image_creation_name_to_prepend"][$k] . $info['filename'] . $this->config["fixed_image_creation_to_append"][$k] . "." . $info['extension'], $this->config["fixed_image_creation_name_to_prepend"][$k] . $name . $this->config["fixed_image_creation_to_append"][$k], $this->config["transliteration"]);
                                    }
                                }
                            }
                        } else {
                            throw new Exception(lang_Empty_name);
                        }
                    }
                    break;
                case 'duplicate_file':
                    if ($this->config["duplicate_files"]) {
                        $name = $this->FileManager->fix_filename($name, $this->config["transliteration"]);
                        if (!empty($name)) {
                            if (!$this->FileManager->duplicate_file($path, $name))
                                throw new Exception(lang_Rename_existing_file);
                            $this->FileManager->duplicate_file($path_thumb, $name);
                            if ($this->config["fixed_image_creation"]) {
                                $info = pathinfo($path);
                                foreach ($this->config["fixed_path_from_filemanager"] as $k => $paths) {
                                    if ($paths != "" && $paths[strlen($paths) - 1] != "/")
                                        $paths.="/";
                                    $base_dir = $paths . substr_replace($info['dirname'] . "/", '', 0, strlen($this->config["current_path"]));
                                    if (file_exists($base_dir . $this->config["fixed_image_creation_name_to_prepend"][$k] . $info['filename'] . $this->config["fixed_image_creation_to_append"][$k] . "." . $info['extension'])) {
                                        $this->FileManager->duplicate_file($base_dir . $this->config["fixed_image_creation_name_to_prepend"][$k] . $info['filename'] . $this->config["fixed_image_creation_to_append"][$k] . "." . $info['extension'], $this->config["fixed_image_creation_name_to_prepend"][$k] . $name . $this->config["fixed_image_creation_to_append"][$k]);
                                    }
                                }
                            }
                        } else {
                            throw new Exception(lang_Empty_name);
                        }
                    }
                    break;
                default:
                    throw new Exception('wrong action');
                    break;
            }
        }
    }

    public function download() {
        
        $this->autoRender = false;
        
        if($this->request->is('post')):
            if(strpos($_POST['path'],'/')===0
                || strpos($_POST['path'],'../')!==FALSE
                || strpos($_POST['path'],'./')===0)
                throw new Exception('wrong path');

            if(strpos($_POST['name'],'/')!==FALSE)
                throw new Exception('wrong path');

            $path=$this->config["current_path"].$_POST['path'];
            $name=$_POST['name'];

            $info=pathinfo($name);
            if(!in_array($this->FileManager->fix_strtolower($info['extension']), $this->config["ext"])){
                throw new Exception('wrong extension');
            }

            header('Pragma: private');
            header('Cache-control: private, must-revalidate');
            header("Content-Type: application/octet-stream");
            header("Content-Length: " .(string)(filesize($path.$name)) );
            header('Content-Disposition: attachment; filename="'.($name).'"');
            readfile($path.$name);
        else:
            $this->redirect($this->referer());
        endif;
    }
    
    public function upload() {

        $this->autoRender = false;
        if($this->request->is('post')):

            if ($this->Session->read("verify") != "RESPONSIVEfilemanager"):
                throw new Exception(__("Forbidden"));
            endif;

            $varSend = array(
                "storeFolder" => $this->request->data["path"],
                "storeFolderThumb" => $this->request->data["path_thumb"],
                "path_pos" => strpos($this->request->data["path"], $this->config["current_path"]),
                "thumb_pos" => strpos($this->request->data["path_thumb"], $this->config["thumbs_base_path"]),
                "path" => $this->request->data["path"]
            );

            if ($varSend["path_pos"] !== 0 || $varSend["thumb_pos"] !== 0 || strpos($varSend["storeFolderThumb"], '../', strlen($this->config["thumbs_base_path"])) !== FALSE || strpos($varSend["storeFolderThumb"], './', strlen($this->config["thumbs_base_path"])) !== FALSE || strpos($varSend["storeFolder"], '../', strlen($this->config["current_path"])) !== FALSE || strpos($varSend["storeFolder"], './', strlen($this->config["current_path"])) !== FALSE)
                throw new Exception(__("Wrong path"));

            $path=$varSend["storeFolder"];
            
            if (!empty($_FILES)) {
                $info=pathinfo($_FILES['file']['name']);
                if(in_array($this->FileManager->fix_strtolower($info['extension']), $this->config["ext"])){
                    $tempFile = $_FILES['file']['tmp_name'];   

                    $targetPath = $varSend["storeFolder"];
                    $targetPathThumb = $varSend["storeFolderThumb"];
                    $_FILES['file']['name'] = $this->FileManager->fix_filename($_FILES['file']['name'],$this->config["transliteration"]);

                    if(file_exists($targetPath.$_FILES['file']['name'])){
                        $i = 1;
                        $info=pathinfo($_FILES['file']['name']);
                        while(file_exists($targetPath.$info['filename']."_".$i.".".$info['extension'])) {
                                $i++;
                        }
                        $_FILES['file']['name']=$info['filename']."_".$i.".".$info['extension'];
                    }
                    $targetFile =  $targetPath. $_FILES['file']['name']; 
                    $targetFileThumb =  $targetPathThumb. $_FILES['file']['name'];

                    if(in_array($this->FileManager->fix_strtolower($info['extension']),$this->config["ext_img"])) $is_img=true;
                    else $is_img=false;

                    move_uploaded_file($tempFile,$targetFile);
                    chmod($targetFile, 0755);

                    if($is_img){
                        $memory_error=false;
                        if(!$this->FileManager->create_img_gd($targetFile, $targetFileThumb, 122, 91)){
                            $memory_error=false;
                        }else{
                            if(!$this->FileManager->new_thumbnails_creation($targetPath,$targetFile,$_FILES['file']['name'],$this->config["current_path"],$this->config["relative_image_creation"],$this->config["relative_path_from_current_pos"],$this->config["relative_image_creation_name_to_prepend"],$this->config["relative_image_creation_name_to_append"],$this->config["relative_image_creation_width"],$this->config["relative_image_creation_height"],$this->config["fixed_image_creation"],$this->config["fixed_path_from_filemanager"],$this->config["fixed_image_creation_name_to_prepend"],$this->config["fixed_image_creation_to_append"],$this->config["fixed_image_creation_width"],$this->config["fixed_image_creation_height"])){
                                $memory_error=false;
                            }else{		    
                                $imginfo = getimagesize($targetFile);
                                $srcWidth = $imginfo[0];
                                $srcHeight = $imginfo[1];

                                if($this->config["image_resizing"]){
                                    if($this->config["image_resizing_width"]==0){
                                        if($this->config["image_resizing_height"]==0){
                                            $this->config["image_resizing_width"]=$srcWidth;
                                            $this->config["image_resizing_height"] =$srcHeight;
                                        }else{
                                            $this->config["image_resizing_width"]=$this->config["image_resizing_height"]*$srcWidth/$srcHeight;
                                    }
                                    }elseif($this->config["image_resizing_height"]==0){
                                        $this->config["image_resizing_height"] =$this->config["image_resizing_width"]*$srcHeight/$srcWidth;
                                    }
                                    $srcWidth=$this->config["image_resizing_width"];
                                    $srcHeight=$this->config["image_resizing_height"];
                                    $this->FileManager->create_img_gd($targetFile, $targetFile, $this->config["image_resizing_width"], $this->config["image_resizing_height"]);
                                }
                                //max resizing limit control
                                $resize=false;
                                if($this->config["image_max_width"]!=0 && $srcWidth >$this->config["image_max_width"]){
                                    $resize=true;
                                    $srcHeight=$this->config["image_max_width"]*$srcHeight/$srcWidth;
                                    $srcWidth=$this->config["image_max_width"];
                                }
                                if($this->config["image_max_height"]!=0 && $srcHeight >$this->config["image_max_height"]){
                                    $resize=true;
                                    $srcWidth =$this->config["image_max_height"]*$srcWidth/$srcHeight;
                                    $srcHeight =$this->config["image_max_height"];
                                }
                                if($resize)
                                    $this->FileManager->create_img_gd($targetFile, $targetFile, $srcWidth, $srcHeight);
                            }
                        }		
                        if($memory_error){
                            //error
                            unlink($targetFile);
                            header('HTTP/1.1 406 Not enought Memory',true,406);
                            exit();
                        }
                    }
                }else{
                    header('HTTP/1.1 406 file not permitted',true,406);
                    exit();
                }
            }else{
                header('HTTP/1.1 405 Bad Request', true, 405);
                exit();
            }
            
            $this->set(compact($varSend));
        endif;
        
        $this->redirect($this->referer());
    }

}
