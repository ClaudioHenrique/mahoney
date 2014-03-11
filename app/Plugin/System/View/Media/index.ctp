<input type="hidden" id="popup" value="<?php echo $popup; ?>" />
<input type="hidden" id="view" value="<?php echo $view; ?>" />
<input type="hidden" id="cur_dir" value="<?php echo $cur_dir; ?>" />
<input type="hidden" id="cur_dir_thumb" value="<?php echo $thumbs_path.$subdir; ?>" />
<input type="hidden" id="insert_folder_name" value="<?php echo lang_Insert_Folder_Name; ?>" />
<input type="hidden" id="new_folder" value="<?php echo lang_New_Folder; ?>" />
<input type="hidden" id="ok" value="<?php echo lang_OK; ?>" />
<input type="hidden" id="cancel" value="<?php echo lang_Cancel; ?>" />
<input type="hidden" id="rename" value="<?php echo lang_Rename; ?>" />
<input type="hidden" id="lang_duplicate" value="<?php echo lang_Duplicate; ?>" />
<input type="hidden" id="duplicate" value="<?php if($duplicate_files) echo 1; else echo 0; ?>" />
<input type="hidden" id="base_url" value="<?php echo $base_url?>"/>
<input type="hidden" id="base_url_true" value="<?php echo $FileManager->base_url(); ?>"/>
<input type="hidden" id="fldr_value" value="<?php echo $subdir; ?>"/>
<input type="hidden" id="sub_folder" value="<?php echo $rfm_subfolder; ?>"/>
<input type="hidden" id="file_number_limit_js" value="<?php echo $file_number_limit_js; ?>" />
<input type="hidden" id="descending" value="<?php echo $descending?"true":"false"; ?>" />
<?php $protocol = 'http'; ?>
<input type="hidden" id="current_url" value="<?php echo str_replace(array('&filter='.$filter),array(''),$protocol."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>" />
<input type="hidden" id="lang_show_url" value="<?php echo lang_Show_url; ?>" />
<input type="hidden" id="lang_extract" value="<?php echo lang_Extract; ?>" />
<input type="hidden" id="lang_file_info" value="<?php echo $FileManager->fix_strtoupper(lang_File_info); ?>" />
<input type="hidden" id="lang_edit_image" value="<?php echo lang_Edit_image; ?>" />
<input type="hidden" id="transliteration" value="<?php echo $transliteration?"true":"false"; ?>" />
<?php if($upload_files){ ?>
<!----- uploader div start ------->
<div class="uploader">
    <center><button class="btn btn-inverse close-uploader"><i class="icon-backward icon-white"></i> <?php echo lang_Return_Files_List ?></button></center>
    <div class="space10"></div><div class="space10"></div>
                <form action="media/upload" method="post" enctype="multipart/form-data" id="myAwesomeDropzone" class="dropzone">
                    <input type="hidden" name="path" value="<?php echo $cur_path?>"/>
                    <input type="hidden" name="path_thumb" value="<?php echo $thumbs_path.$subdir?>"/>
                    <div class="fallback">
			<?php echo lang_Upload_file ?>:<br/>
                        <input name="file" type="file" />
                        <input type="hidden" name="fldr" value="<?php echo $subdir; ?>"/>
                        <input type="hidden" name="view" value="<?php echo $view; ?>"/>
                        <input type="hidden" name="type" value="<?php echo $_GET['type']; ?>"/>
                        <input type="hidden" name="field_id" value="<?php echo $_GET['field_id']; ?>"/>
                        <input type="hidden" name="popup" value="<?php echo $popup; ?>"/>
                        <input type="hidden" name="lang" value="<?php echo $lang; ?>"/>
                        <input type="hidden" name="filter" value="<?php echo $filter; ?>"/>
                        <input type="submit" name="submit" value="<?php echo lang_OK?>" />
                    </div>
                </form>
                <div class="upload-help"><?php echo lang_Upload_base_help; ?></div>
        </div>
    </div>

</div>
<!----- uploader div start ------->
<?php } ?>		
<div class="container-fluid">

<?php
	    
$class_ext = '';
$src = '';

if ($_GET['type']==1) 	 $apply = 'apply_img';
elseif($_GET['type']==2) $apply = 'apply_link';
elseif($_GET['type']==0 && $_GET['field_id']=='') $apply = 'apply_none';
elseif($_GET['type']==3) $apply = 'apply_video';
else $apply = 'apply';

// Create the user folder if not exist
if(is_dir($current_path.$rfm_subfolder.$subdir)):
    $files = scandir($current_path.$rfm_subfolder.$subdir);
else:
    $pathExplode = array_reverse(explode("/", $current_path.$rfm_subfolder.$subdir));
    if(AuthComponent::user()["username"] == $pathExplode[1]):
        $FileManager->create_folder($current_path.$rfm_subfolder.$subdir);
        $files = scandir($current_path.$rfm_subfolder.$subdir);
    else:
        throw new Exception("Invalid folder");
    endif;
endif;
$n_files=count($files);

//php sorting
$sorted=array();
$current_folder=array();
$prev_folder=array();
foreach($files as $k=>$file){
    if($file==".") $current_folder=array('file'=>$file);
    elseif($file=="..") $prev_folder=array('file'=>$file);
    elseif(is_dir($current_path.$rfm_subfolder.$subdir.$file)){
	$date=filemtime($current_path.$rfm_subfolder.$subdir. $file);
	$size=$FileManager->foldersize($current_path.$rfm_subfolder.$subdir. $file);
	$file_ext=lang_Type_dir;
	$sorted[$k]=array('file'=>$file,'date'=>$date,'size'=>$size,'extension'=>$file_ext);
    }else{
	$file_path=$current_path.$rfm_subfolder.$subdir.$file;
	$date=filemtime($file_path);
	$size=filesize($file_path);
	$file_ext = substr(strrchr($file,'.'),1);
	$sorted[$k]=array('file'=>$file,'date'=>$date,'size'=>$size,'extension'=>$file_ext);
    }
}

function filenameSort($x, $y) {
    return $x['file'] <  $y['file'];
}
function dateSort($x, $y) {
    return $x['date'] <  $y['date'];
}
function sizeSort($x, $y) {
    return $x['size'] -  $y['size'];
}
function extensionSort($x, $y) {
    return $x['extension'] <  $y['extension'];
}

switch($sort_by){
    case 'name':
	usort($sorted, 'filenameSort');
	break;
    case 'date':
	usort($sorted, 'dateSort');
	break;
    case 'size':
	usort($sorted, 'sizeSort');
	break;
    case 'extension':
	usort($sorted, 'extensionSort');
	break;
    default:
	break;
    
}

if($descending){
    $sorted=array_reverse($sorted);
}

$files=array_merge(array($prev_folder),array($current_folder),$sorted);
?>          
    <!----- header div start ------->
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container-fluid">
                <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="brand"><?php echo lang_Toolbar; ?></div>
                <div class="nav-collapse collapse">
                    <div class="filters">
                        <div class="row-fluid">
                            <div class="span2 half">
                                <span><?php echo lang_Actions; ?>:</span>
                                <?= $this->Html->link("<i class=\"fa fa-angle-left\"></i> <i class=\"fa fa-dashboard\"></i> ", array("plugin"=>"system","controller"=>"dashboard"), array("title"=>"Back to Dashboard", "class" => "tip btn", "escape" => false)); ?>
			    <?php if($upload_files){ ?>
                                <button class="tip btn upload-btn" title="<?php echo  lang_Upload_file; ?>"><i class="icon-plus"></i><i class="icon-file"></i></button> 
			    <?php } ?>
			    <?php if($create_folders){ ?>
                                <button class="tip btn new-folder" title="<?php echo  lang_New_Folder?>"><i class="icon-plus"></i><i class="icon-folder-open"></i></button> 
			    <?php } ?>
                            </div>
                            <div class="span3 half view-controller">
                                <span><?php echo lang_View; ?>:</span>
                                <button class="btn tip<?php if($view==0) echo " btn-inverse"; ?>" id="view0" data-value="0" title="<?php echo lang_View_boxes; ?>"><i class="icon-th <?php if($view==0) echo "icon-white"; ?>"></i></button>
                                <button class="btn tip<?php if($view==1) echo " btn-inverse"; ?>" id="view1" data-value="1" title="<?php echo lang_View_list; ?>"><i class="icon-align-justify <?php if($view==1) echo "icon-white"; ?>"></i></button>
                                <button class="btn tip<?php if($view==2) echo " btn-inverse"; ?>" id="view2" data-value="2" title="<?php echo lang_View_columns_list; ?>"><i class="icon-fire <?php if($view==2) echo "icon-white"; ?>"></i></button>
                            </div>
                            <div class="span6 types">
                                <span><?php echo lang_Filters; ?>:</span>
			    <?php if($_GET['type']!=1 && $_GET['type']!=3){ ?>
                                <input id="select-type-1" name="radio-sort" type="radio" data-item="ff-item-type-1" checked="checked"  class="hide"  />
                                <label id="ff-item-type-1" title="<?php echo lang_Files; ?>" for="select-type-1" class="tip btn ff-label-type-1"><i class="icon-file"></i></label>
                                <input id="select-type-2" name="radio-sort" type="radio" data-item="ff-item-type-2" class="hide"  />
                                <label id="ff-item-type-2" title="<?php echo lang_Images; ?>" for="select-type-2" class="tip btn ff-label-type-2"><i class="icon-picture"></i></label>
                                <input id="select-type-3" name="radio-sort" type="radio" data-item="ff-item-type-3" class="hide"  />
                                <label id="ff-item-type-3" title="<?php echo lang_Archives; ?>" for="select-type-3" class="tip btn ff-label-type-3"><i class="icon-inbox"></i></label>
                                <input id="select-type-4" name="radio-sort" type="radio" data-item="ff-item-type-4" class="hide"  />
                                <label id="ff-item-type-4" title="<?php echo lang_Videos; ?>" for="select-type-4" class="tip btn ff-label-type-4"><i class="icon-film"></i></label>
                                <input id="select-type-5" name="radio-sort" type="radio" data-item="ff-item-type-5" class="hide"  />
                                <label id="ff-item-type-5" title="<?php echo lang_Music; ?>" for="select-type-5" class="tip btn ff-label-type-5"><i class="icon-music"></i></label>
			    <?php } ?>
                                <input accesskey="f" type="text" class="filter-input" id="filter-input" name="filter" placeholder="<?php echo $FileManager->fix_strtolower(lang_Text_filter); ?>..." value="<?php echo $filter; ?>"/><?php if($n_files>$file_number_limit_js){ ?><label id="filter" class="btn"><i class="icon-play"></i></label><?php } ?>

                                <input id="select-type-all" name="radio-sort" type="radio" data-item="ff-item-type-all" class="hide"  />
                                <label id="ff-item-type-all" title="<?php echo lang_All; ?>" <?php if($_GET['type']==1 || $_GET['type']==3){ ?>style="visibility: hidden;" <?php } ?> data-item="ff-item-type-all" for="select-type-all" style="margin-rigth:0px;" class="tip btn btn-inverse ff-label-type-all"><i class="icon-align-justify icon-white"></i></label>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!----- header div end ------->

    <!----- breadcrumb div start ------->

    <div class="row-fluid">
	<?php	
	$link="?".$get_params;
	?>
        <ul class="breadcrumb">	
            <li class="pull-left"><a href="<?php echo $link?>/"><i class="icon-home"></i></a></li>
            <li><span class="divider">/</span></li>
	<?php
	$bc=explode("/",$subdir);
	$tmp_path='';
	if(!empty($bc))
	foreach($bc as $k=>$b){ 
		$tmp_path.=$b."/";
		if($k==count($bc)-2){
	?> <li class="active"><?php echo $b?></li><?php
		}elseif($b!=""){ ?>
            <li><a href="<?php echo $link.$tmp_path?>"><?php echo $b?></a></li><li><span class="divider"><?php echo "/"; ?></span></li>
	<?php }
	}
	?>
            <li class="pull-right"><a class="btn-small" href="javascript:void('')" id="info"><i class="icon-question-sign"></i></a></li>
            <li class="pull-right"><a id="refresh" class="btn-small" href="?<?php echo $get_params.$subdir."&".uniqid() ?>"><i class="icon-refresh"></i></a></li>

            <li class="pull-right">
                <div class="btn-group">
                    <a class="btn dropdown-toggle sorting-btn" data-toggle="dropdown" href="#">
                        <i class="icon-signal"></i> 
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu pull-left sorting">
                        <li><center><strong><?php echo lang_Sorting ?></strong></center></li>
                        <li><a class="sorter sort-name <?php if($sort_by=="name"){ echo ($descending)?"descending":"ascending"; } ?>" href="javascript:void('')" data-sort="name"><?php echo lang_Filename; ?></a></li>
                        <li><a class="sorter sort-date <?php if($sort_by=="date"){ echo ($descending)?"descending":"ascending"; } ?>" href="javascript:void('')" data-sort="date"><?php echo lang_Date; ?></a></li>
                        <li><a class="sorter sort-size <?php if($sort_by=="size"){ echo ($descending)?"descending":"ascending"; } ?>" href="javascript:void('')" data-sort="size"><?php echo lang_Size; ?></a></li>
                        <li><a class="sorter sort-extension <?php if($sort_by=="extension"){ echo ($descending)?"descending":"ascending"; } ?>" href="javascript:void('')" data-sort="extension"><?php echo lang_Type; ?></a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <!----- breadcrumb div end ------->
    <div class="row-fluid ff-container">
        <div class="span12">	    
	    <?php if(@opendir($current_path.$rfm_subfolder.$subdir)===FALSE){ ?>
            <br/>
            <div class="alert alert-error">There is an error! The upload folder there isn't. Check your config.php file. </div> 
	    <?php }else{ ?>
            <h4 id="help"><?php echo lang_Swipe_help; ?></h4>
	    <?php if(isset($folder_message)){ ?>
            <div class="alert alert-block"><?php echo $folder_message; ?></div>
	    <?php } ?>
	    <?php if($show_sorting_bar){ ?>
            <!-- sorter -->
            <div class="sorter-container <?php echo "list-view".$view; ?>">
                <div class="file-name"><a class="sorter sort-name <?php if($sort_by=="name"){ echo ($descending)?"descending":"ascending"; } ?>" href="javascript:void('')" data-sort="name"><?php echo lang_Filename; ?></a></div>
                <div class="file-date"><a class="sorter sort-date <?php if($sort_by=="date"){ echo ($descending)?"descending":"ascending"; } ?>" href="javascript:void('')" data-sort="date"><?php echo lang_Date; ?></a></div>
                <div class="file-size"><a class="sorter sort-size <?php if($sort_by=="size"){ echo ($descending)?"descending":"ascending"; } ?>" href="javascript:void('')" data-sort="size"><?php echo lang_Size; ?></a></div>
                <div class='img-dimension'><?php echo lang_Dimension; ?></div>
                <div class='file-extension'><a class="sorter sort-extension <?php if($sort_by=="extension"){ echo ($descending)?"descending":"ascending"; } ?>" href="javascript:void('')" data-sort="extension"><?php echo lang_Type; ?></a></div>
                <div class='file-operations'><?php echo lang_Operations; ?></div>
            </div>
	    <?php } ?>

            <input type="hidden" id="file_number" value="<?php echo $n_files; ?>" />
            <!--ul class="thumbnails ff-items"-->
            <ul class="grid cs-style-2 <?php echo "list-view".$view; ?>">
		<?php
		
		$jplayer_ext=array("mp4","flv","webmv","webma","webm","m4a","m4v","ogv","oga","mp3","midi","mid","ogg","wav");
		foreach ($files as $file_array) {
		    $file=$file_array['file'];
			if($file == '.' || (isset($file_array['extension']) && $file_array['extension']!=lang_Type_dir) || ($file == '..' && $subdir == '') || in_array($file, $hidden_folders) || ($filter!='' && $file!=".." && strpos($file,$filter)===false))
			    continue;
			$new_name=$FileManager->fix_filename($file,$transliteration);
			if($file!='..' && $file!=$new_name){
			    //rename
			    $FileManager->rename_folder($current_path.$subdir.$new_name,$new_name,$transliteration);
			    $file=$new_name;
			}
			//add in thumbs folder if not exist 
			if (!file_exists($thumbs_path.$subdir.$file)) $FileManager->create_folder(false,$thumbs_path.$subdir.$file);
			$class_ext = 3;			
			if($file=='..' && trim($subdir) != '' ){
			    $src = explode("/",$subdir);
			    unset($src[count($src)-2]);
			    $src=implode("/",$src);
			    if($src=='') $src="/";
			}
			elseif ($file!='..') {
			    $src = $subdir . $file."/";
			}
			
			?>
                <li data-name="<?php echo $file ?>" <?php if($file=='..') echo 'class="back"'; else echo 'class="dir"'; ?>><?php 
			    $file_prevent_rename = false;
			    $file_prevent_delete = false;
			    if (isset($filePermissions[$file])) {
				$file_prevent_rename = isset($filePermissions[$file]['prevent_rename']) && $filePermissions[$file]['prevent_rename'];
				$file_prevent_delete = isset($filePermissions[$file]['prevent_delete']) && $filePermissions[$file]['prevent_delete'];
			    }
			    ?>	<figure data-name="<?php echo $file ?>" class="<?php if($file=="..") echo "back-"; ?>directory" data-type="<?php if($file!=".."){ echo "dir"; } ?>">
                        <a class="folder-link" href="?<?php echo $get_params.rawurlencode($src)."&".uniqid() ?>">
                            <div class="img-precontainer">
                                <div class="img-container directory"><span></span>
                                    <img class="directory-img"  src="com/img/filemanager/<?php echo $icon_theme; ?>/folder<?php if($file==".."){ echo "_back"; }?>.jpg" alt="folder" />
                                </div>
                            </div>
                            <div class="img-precontainer-mini directory">
                                <div class="img-container-mini">
                                    <span></span>
                                    <img class="directory-img"  src="com/img/filemanager/<?php echo $icon_theme; ?>/folder<?php if($file==".."){ echo "_back"; }?>.png" alt="folder" />
                                </div>
                            </div>
			<?php if($file==".."){ ?>
                            <div class="box no-effect">
                                <h4><?php echo lang_Back ?></h4>
                            </div>
                        </a>

			<?php }else{ ?>
                        </a>
                        <div class="box">
                            <h4 class="<?php if($ellipsis_title_after_first_row){ echo "ellipsis"; } ?>"><a class="folder-link" data-file="<?php echo $file ?>" href="?<?php echo $get_params.rawurlencode($src)."&".uniqid() ?>"><?php echo $file; ?></a></h4>
                        </div>
                        <input type="hidden" class="name" value=""/>
                        <input type="hidden" class="date" value="<?php echo $file_array['date']; ?>"/>
                        <input type="hidden" class="size" value="<?php echo $file_array['size'];  ?>"/>
                        <input type="hidden" class="extension" value="<?php echo lang_Type_dir; ?>"/>
                        <div class="file-date"><?php echo date(lang_Date_type,$file_array['date'])?></div>
				    <?php if($show_folder_size){ ?><div class="file-size"><?php echo $FileManager->makeSize($file_array['size'])?></div><?php } ?>
                        <div class='file-extension'><?php echo lang_Type_dir; ?></div>
                        <figcaption>
                            <a href="javascript:void('')" class="tip-left edit-button rename-file-paths <?php if($rename_folders && !$file_prevent_rename) echo "rename-folder"; ?>" title="<?php echo lang_Rename?>" data-path="<?php echo $rfm_subfolder.$subdir.$file; ?>" data-thumb="<?php echo $thumbs_path.$subdir.$file; ?>">
                                <i class="icon-pencil <?php if(!$rename_folders || $file_prevent_rename) echo 'icon-white'; ?>"></i></a>
                            <a href="javascript:void('')" class="tip-left erase-button <?php if($delete_folders && !$file_prevent_delete) echo "delete-folder"; ?>" title="<?php echo lang_Erase?>" data-confirm="<?php echo lang_Confirm_Folder_del; ?>" data-path="<?php echo $rfm_subfolder.$subdir.$file; ?>"  data-thumb="<?php echo $thumbs_path.$subdir .$file; ?>">
                                <i class="icon-trash <?php if(!$delete_folders || $file_prevent_delete) echo 'icon-white'; ?>"></i>
                            </a>
                        </figcaption>
			<?php } ?>
                    </figure>
                </li>
			<?php
		    }
			
            $files_prevent_duplicate = array();
		    foreach ($files as $nu=>$file_array) {		
			$file=$file_array['file'];
		    
			    if($file == '.' || $file == '..' || is_dir($current_path.$rfm_subfolder.$subdir.$file) || in_array($file, $hidden_files) || !in_array($FileManager->fix_strtolower($file_array['extension']), $ext) || ($filter!='' && strpos($file,$filter)===false))
				    continue;
			    
			    $file_path=$current_path.$rfm_subfolder.$subdir.$file;
			    //check if file have illegal caracter
			    
			    $filename=substr($file, 0, '-' . (strlen($file_array['extension']) + 1));
			    
			    if($file!=$FileManager->fix_filename($file,$transliteration)){
				$file1=$FileManager->fix_filename($file,$transliteration);
				$file_path1=($current_path.$rfm_subfolder.$subdir.$file1);
				if(file_exists($file_path1)){
				    $i = 1;
				    $info=pathinfo($file1);
				    while(file_exists($current_path.$rfm_subfolder.$subdir.$info['filename'].".[".$i."].".$info['extension'])) {
					    $i++;
				    }
				    $file1=$info['filename'].".[".$i."].".$info['extension'];
				    $file_path1=($current_path.$rfm_subfolder.$subdir.$file1);
				}
				
				$filename=substr($file1, 0, '-' . (strlen($file_array['extension']) + 1));
				$FileManager->rename_file($file_path,$FileManager->fix_filename($filename,$transliteration),$transliteration);
				$file=$file1;
				$file_array['extension']=$FileManager->fix_filename($file_array['extension'],$transliteration);
				$file_path=$file_path1;
			    }
			    
			    $is_img=false;
			    $is_video=false;
			    $is_audio=false;
			    $show_original=false;
			    $show_original_mini=false;
			    $mini_src="";
			    $src_thumb="";
			    $extension_lower=$FileManager->fix_strtolower($file_array['extension']);
			    if(in_array($extension_lower, $ext_img)){
				$src = $base_url . $cur_dir . rawurlencode($file);
				$mini_src = $src_thumb = $thumbs_path.$subdir. $file;
				//add in thumbs folder if not exist
				if(!file_exists($src_thumb)){
				    try {
					$FileManager->create_img_gd($file_path, $src_thumb, 122, 91);
					$FileManager->new_thumbnails_creation($current_path.$rfm_subfolder.$subdir,$file_path,$file,$current_path,$relative_image_creation,$relative_path_from_current_pos,$relative_image_creation_name_to_prepend,$relative_image_creation_name_to_append,$relative_image_creation_width,$relative_image_creation_height,$fixed_image_creation,$fixed_path_from_filemanager,$fixed_image_creation_name_to_prepend,$fixed_image_creation_to_append,$fixed_image_creation_width,$fixed_image_creation_height);
				    } catch (Exception $e) {
					$src_thumb=$mini_src="";
				    }
				}
				$is_img=true;
				//check if is smaller than thumb
				list($img_width, $img_height, $img_type, $attr)=getimagesize($file_path);
				if($img_width<122 && $img_height<91){ 
					$src_thumb=$current_path.$rfm_subfolder.$subdir.$file;
					$show_original=true;
				}
				
				if($img_width<45 && $img_height<38){
				    $mini_src=$current_path.$rfm_subfolder.$subdir.$file;
				    $show_original_mini=true;
				}
			    }
			    
			    $is_icon_thumb=false;
			    $is_icon_thumb_mini=false;
			    $no_thumb=false;
			    if($src_thumb==""){
				$no_thumb=true;
				if(file_exists('com/img/filemanager/'.$icon_theme.'/'.$extension_lower.".jpg")){
					$src_thumb ='com/img/filemanager/'.$icon_theme.'/'.$extension_lower.".jpg";
				}else{
					$src_thumb = "com/img/filemanager/".$icon_theme."/default.jpg";
				}
				$is_icon_thumb=true;
			    }
			    if($mini_src==""){
				$is_icon_thumb_mini=false;
			    }
			    
			    $class_ext=0;
			    if (in_array($extension_lower, $ext_video)) {
				    $class_ext = 4;
				    $is_video=true;
			    }elseif (in_array($extension_lower, $ext_img)) {
				    $class_ext = 2;
			    }elseif (in_array($extension_lower, $ext_music)) {
				    $class_ext = 5;
				    $is_audio=true;
			    }elseif (in_array($extension_lower, $ext_misc)) {
				    $class_ext = 3;
			    }else{
				    $class_ext = 1;
			    }
			    if((!($_GET['type']==1 && !$is_img) && !(($_GET['type']==3 && !$is_video) && ($_GET['type']==3 && !$is_audio))) && $class_ext>0){
?>
                <li class="ff-item-type-<?php echo $class_ext; ?> file"  data-name="<?php echo $file; ?>"><?php
		    $file_prevent_rename = false;
		    $file_prevent_delete = false;
		    if (isset($filePermissions[$file])) {
			if (isset($filePermissions[$file]['prevent_duplicate']) && $filePermissions[$file]['prevent_duplicate']) {
			    $files_prevent_duplicate[] = $file;
			}
			$file_prevent_rename = isset($filePermissions[$file]['prevent_rename']) && $filePermissions[$file]['prevent_rename'];
			$file_prevent_delete = isset($filePermissions[$file]['prevent_delete']) && $filePermissions[$file]['prevent_delete'];
		    }
            ?>		<figure data-name="<?php echo $file ?>" data-type="<?php if($is_img){ echo "img"; }else{ echo "file"; } ?>">
                        <a href="javascript:void('')" class="link" data-file="<?php echo $file; ?>" data-field_id="<?php echo $_GET['field_id']; ?>" data-function="<?php echo $apply; ?>">
                            <div class="img-precontainer">
				    <?php if($is_icon_thumb){ ?><div class="filetype"><?php echo $extension_lower ?></div><?php } ?>
                                <div class="img-container">
                                    <span></span>
                                    <img alt="<?php echo $filename." thumbnails";?>" class="<?php echo $show_original ? "original" : "" ?> <?php echo $is_icon_thumb ? "icon" : "" ?>" src="<?php echo str_replace("/webroot", "", $src_thumb); ?>">
                                </div>
                            </div>
                            <div class="img-precontainer-mini <?php if($is_img) echo 'original-thumb' ?>">
                                <div class="filetype <?php echo $extension_lower ?> <?php if(!$is_icon_thumb){ echo "hide"; }?>"><?php echo $extension_lower ?></div>
                                <div class="img-container-mini">
                                    <span></span>
					<?php if($mini_src!=""){ ?>
                                    <img alt="<?php echo $filename." thumbnails";?>" class="<?php echo $show_original_mini ? "original" : "" ?> <?php echo $is_icon_thumb_mini ? "icon" : "" ?>" src="<?php echo str_replace("/webroot", "", $mini_src); ?>">
					<?php } ?>
                                </div>
                            </div>
				<?php if($is_icon_thumb){ ?>
                            <div class="cover"></div>
				<?php } ?>
                        </a>	
                        <div class="box">				
                            <h4 class="<?php if($ellipsis_title_after_first_row){ echo "ellipsis"; } ?>"><a href="javascript:void('')" class="link" data-file="<?php echo $file; ?>" data-field_id="<?php echo $_GET['field_id']; ?>" data-function="<?php echo $apply; ?>">
				<?php echo $filename; ?></a> </h4>
                        </div>
                        <input type="hidden" class="date" value="<?php echo $file_array['date']; ?>"/>
                        <input type="hidden" class="size" value="<?php echo $file_array['size'] ?>"/>
                        <input type="hidden" class="extension" value="<?php echo $extension_lower; ?>"/>
                        <input type="hidden" class="name" value=""/>
                        <div class="file-date"><?php echo date(lang_Date_type,$file_array['date'])?></div>
                        <div class="file-size"><?php echo $FileManager->makeSize($file_array['size'])?></div>
                        <div class='img-dimension'><?php if($is_img){ echo $img_width."x".$img_height; } ?></div>
                        <div class='file-extension'><?php echo $extension_lower; ?></div>
                        <figcaption>
                            <form action="media/download" method="post" class="download-form" id="form<?php echo $nu; ?>">
                                <input type="hidden" name="path" value="<?php echo $rfm_subfolder.$subdir?>"/>
                                <input type="hidden" class="name_download" name="name" value="<?php echo $file?>"/>

                                <a title="<?php echo lang_Download?>" class="tip-right" href="javascript:void('')" onclick="$('#form<?php echo $nu; ?>').submit();"><i class="icon-download"></i></a>
				    <?php if($is_img && $src_thumb!=""){ ?>
                                <a class="tip-right preview" title="<?php echo lang_Preview?>" data-url="<?php echo $src;?>" data-toggle="lightbox" href="#previewLightbox"><i class=" icon-eye-open"></i></a>
				    <?php }elseif(($is_video || $is_audio) && in_array($extension_lower,$jplayer_ext)){ ?>
                                <a class="tip-right modalAV <?php if($is_audio){ echo "audio"; }else{ echo "video"; } ?>"
                                   title="<?php echo lang_Preview?>" data-url="media/ajax?action=media_preview&title=<?php echo $filename; ?>&file=<?php echo $current_path.$rfm_subfolder.$subdir.$file;; ?>"
                                   href="javascript:void('');" ><i class=" icon-eye-open"></i></a>
				    <?php }else{ ?>
                                <a class="preview disabled"><i class="icon-eye-open icon-white"></i></a>
				    <?php } ?>
                                <a href="javascript:void('')" class="tip-left edit-button rename-file-paths <?php if($rename_files && !$file_prevent_rename) echo "rename-file"; ?>" title="<?php echo lang_Rename?>" data-path="<?php echo $rfm_subfolder.$subdir .$file; ?>" data-thumb="<?php echo $thumbs_path.$subdir .$file; ?>">
                                    <i class="icon-pencil <?php if(!$rename_files || $file_prevent_rename) echo 'icon-white'; ?>"></i></a>

                                <a href="javascript:void('')" class="tip-left erase-button <?php if($delete_files && !$file_prevent_delete) echo "delete-file"; ?>" title="<?php echo lang_Erase?>" data-confirm="<?php echo lang_Confirm_del; ?>" data-path="<?php echo $rfm_subfolder.$subdir.$file; ?>" data-thumb="<?php echo $thumbs_path.$subdir .$file; ?>">
                                    <i class="icon-trash <?php if(!$delete_files || $file_prevent_delete) echo 'icon-white'; ?>"></i>
                                </a>
                            </form>
                        </figcaption>
                    </figure>			
                </li>
			<?php
			}
		    }
		
	?></div>
        </ul>
	    <?php } ?>
    </div>
</div>
</div>
<script>
    var files_prevent_duplicate = new Array();
    <?php
    foreach ($files_prevent_duplicate as $key => $value): ?>
        files_prevent_duplicate[<?php echo $key;?>] = '<?php echo $value; ?>';
    <?php endforeach; ?>
</script>

<!----- lightbox div start ------->    
<div id="previewLightbox" class="lightbox hide fade"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class='lightbox-content'>
        <img id="full-img" src="">
    </div>    
</div>
<!----- lightbox div end ------->

<!----- loading div start ------->  
<div id="loading_container" style="display:none;">
    <div id="loading" style="background-color:#000; position:fixed; width:100%; height:100%; top:0px; left:0px;z-index:100000"></div>
    <img id="loading_animation" src="com/img/filemanager/storing_animation.gif" alt="loading" style="z-index:10001; margin-left:-32px; margin-top:-32px; position:fixed; left:50%; top:50%"/>
</div>
<!----- loading div end ------->

<!----- player div start ------->
<div class="modal hide fade" id="previewAV">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3><?php echo lang_Preview; ?></h3>
    </div>
    <div class="modal-body">
        <div class="row-fluid body-preview">
        </div>
    </div>

</div>
<!----- player div end ------->
<img id='aviary_img' src='' class="hide"/>